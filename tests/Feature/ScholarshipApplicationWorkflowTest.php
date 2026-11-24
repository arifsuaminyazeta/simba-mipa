<?php

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SemesterEvaluation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('stores eligible scholarship applications and blocks duplicates', function () {
    $student = User::factory()->create(['role' => 'mahasiswa']);
    $scholarship = Scholarship::create([
        'name' => 'Beasiswa Sains',
        'provider' => 'FMIPA',
        'registration_url' => 'https://example.test/registration',
        'min_gpa' => 3.00,
        'quota' => 10,
        'open_date' => today()->subDay(),
        'close_date' => today()->addMonth(),
        'status' => 'open',
    ]);

    SemesterEvaluation::create([
        'user_id' => $student->id,
        'scholarship_id' => $scholarship->id,
        'semester_ke' => 4,
        'ips_score' => 3.50,
        'ipk_score' => 3.55,
        'khs_file' => 'khs/latest.pdf',
    ]);

    $payload = [
        'scholarship_id' => $scholarship->id,
        'document_file' => UploadedFile::fake()->createWithContent('transkrip.pdf', '%PDF-1.4 transcript'),
        'statement_file' => UploadedFile::fake()->createWithContent('pernyataan.pdf', '%PDF-1.4 statement'),
        'motivation_file' => UploadedFile::fake()->createWithContent('esai.pdf', '%PDF-1.4 essay'),
        'declaration' => '1',
    ];

    $this->actingAs($student)
        ->post(route('pendaftaran.store'), $payload)
        ->assertRedirect(route('pendaftaran.index', absolute: false));

    $application = ScholarshipApplication::firstOrFail();
    expect($application->status)->toBe('pending')
        ->and((float) $application->gpa_score)->toBe(3.55);

    $this->actingAs($student)
        ->get(route('pendaftaran.index'))
        ->assertOk()
        ->assertSee('Beasiswa Sains')
        ->assertSee('Menunggu Verifikasi Dosen PA');

    $this->actingAs($student)
        ->get(route('pendaftaran.show', $application))
        ->assertOk()
        ->assertSee('Catatan Dosen PA')
        ->assertSee('Catatan Admin');

    $this->actingAs($student)
        ->post(route('pendaftaran.store'), $payload)
        ->assertSessionHasErrors('scholarship_id');

    expect(ScholarshipApplication::count())->toBe(1);
});

it('rejects an IPK below the scholarship minimum', function () {
    $student = User::factory()->create(['role' => 'mahasiswa']);
    $scholarship = Scholarship::create([
        'name' => 'Beasiswa Sains',
        'provider' => 'FMIPA',
        'registration_url' => 'https://example.test/registration',
        'min_gpa' => 3.00,
        'quota' => 10,
        'open_date' => today()->subDay(),
        'close_date' => today()->addMonth(),
        'status' => 'open',
    ]);

    $this->actingAs($student)
        ->post(route('pendaftaran.store'), [
            'scholarship_id' => $scholarship->id,
            'gpa_score' => 2.90,
            'document_file' => UploadedFile::fake()->createWithContent('transkrip.pdf', '%PDF-1.4 transcript'),
            'statement_file' => UploadedFile::fake()->createWithContent('pernyataan.pdf', '%PDF-1.4 statement'),
            'motivation_file' => UploadedFile::fake()->createWithContent('esai.pdf', '%PDF-1.4 essay'),
            'declaration' => '1',
        ])
        ->assertSessionHasErrors('scholarship_id');

    expect(ScholarshipApplication::count())->toBe(0);
});

it('allows editing and cancelling a pending application only', function () {
    $student = User::factory()->create(['role' => 'mahasiswa']);
    $scholarship = Scholarship::create([
        'name' => 'Beasiswa Sains',
        'provider' => 'FMIPA',
        'registration_url' => 'https://example.test/registration',
        'min_gpa' => 3.00,
        'quota' => 10,
        'open_date' => today()->subDay(),
        'close_date' => today()->addMonth(),
        'status' => 'open',
    ]);
    SemesterEvaluation::create([
        'user_id' => $student->id,
        'scholarship_id' => $scholarship->id,
        'semester_ke' => 4,
        'ips_score' => 3.50,
        'ipk_score' => 3.55,
        'khs_file' => 'khs/latest.pdf',
    ]);
    $application = ScholarshipApplication::create([
        'user_id' => $student->id,
        'scholarship_id' => $scholarship->id,
        'gpa_score' => 3.55,
        'document_file' => 'applications/transkrip.pdf',
        'status' => 'pending',
    ]);

    $this->actingAs($student)
        ->get(route('pendaftaran.edit', $application))
        ->assertOk();

    $this->actingAs($student)
        ->put(route('pendaftaran.update', $application), [
            'scholarship_id' => $scholarship->id,
            'declaration' => '1',
        ])
        ->assertRedirect(route('pendaftaran.show', $application, absolute: false));

    $this->actingAs($student)
        ->delete(route('pendaftaran.destroy', $application))
        ->assertRedirect(route('pendaftaran.index', absolute: false));

    expect(ScholarshipApplication::find($application->id))->toBeNull();
});

it('requires a recommendation and confirms an awardee only after LoA review', function () {
    $advisor = User::factory()->create(['role' => 'dosen_pa']);
    $student = User::factory()->create([
        'role' => 'mahasiswa',
        'dosen_pa_id' => $advisor->id,
    ]);
    $admin = User::factory()->create(['role' => 'admin']);
    $scholarship = Scholarship::create([
        'name' => 'Beasiswa Sains',
        'provider' => 'FMIPA',
        'registration_url' => 'https://example.test/registration',
        'min_gpa' => 3.00,
        'quota' => 10,
        'open_date' => today()->subDay(),
        'close_date' => today()->addMonth(),
        'status' => 'open',
    ]);
    $application = ScholarshipApplication::create([
        'user_id' => $student->id,
        'scholarship_id' => $scholarship->id,
        'gpa_score' => 3.55,
        'document_file' => 'applications/transkrip.pdf',
        'status' => 'pending',
    ]);

    $this->actingAs($advisor)
        ->post(route('verifikasi.dosen', $application), [
            'decision' => 'verify',
            'dosen_notes' => 'Dokumen lengkap.',
        ])
        ->assertRedirect(route('verifikasi.awal', absolute: false));

    $application->refresh();
    expect($application->status)->toBe('verified_by_dosen');

    $this->actingAs($admin)
        ->get(route('verifikasi.akhir'))
        ->assertOk()
        ->assertSee('Antrean Surat Rekomendasi')
        ->assertSee('Antrean Konfirmasi LoA/SK');

    $this->actingAs($admin)
        ->get(route('verifikasi.detail', $application))
        ->assertOk()
        ->assertSee('Surat Rekomendasi (PDF)')
        ->assertSee('Catatan Dosen PA')
        ->assertSee('Catatan Admin');

    $this->actingAs($admin)
        ->post(route('verifikasi.admin', $application), [
            'decision' => 'approve',
            'admin_notes' => 'Disetujui.',
        ])
        ->assertSessionHasErrors('recommendation_letter_file');

    $this->actingAs($admin)
        ->post(route('verifikasi.admin', $application), [
            'decision' => 'approve',
            'admin_notes' => 'Disetujui.',
            'recommendation_letter_file' => UploadedFile::fake()->createWithContent('recommendation.pdf', '%PDF-1.4 recommendation'),
        ])
        ->assertRedirect(route('verifikasi.akhir', absolute: false));

    $application->refresh();
    expect($application->status)->toBe('approved_by_admin')
        ->and($application->recommendation_letter_file)->not->toBeNull();

    $this->actingAs($student)
        ->get(route('pendaftaran.upload', $application))
        ->assertOk()
        ->assertSee('Bukti kelolosan resmi LoA/SK');

    $this->actingAs($student)
        ->post(route('pendaftaran.upload-sk.store', $application), [
            'acceptance_proof_file' => UploadedFile::fake()->createWithContent('loa.pdf', '%PDF-1.4 loa'),
        ])
        ->assertRedirect(route('pendaftaran.index', absolute: false));

    $application->refresh();
    expect($application->status)->toBe('loa_submitted');

    $this->actingAs($admin)
        ->post(route('verifikasi.admin', $application), [
            'decision' => 'approve',
            'admin_notes' => 'LoA terverifikasi.',
        ])
        ->assertRedirect(route('verifikasi.akhir', absolute: false));

    expect($application->fresh()->status)->toBe('awardee_confirmed')
        ->and($student->fresh()->is_awardee)->toBeTrue();
});
