<?php

use App\Models\AlumniTracer;
use App\Models\User;

it('shows tracer study summaries and filters alumni responses', function () {
    $workingAlumni = User::factory()->create([
        'name' => 'Alumni Bekerja',
        'nim_nip' => '111111',
        'major' => 'Ilmu Komputer',
        'academic_status' => 'alumni',
        'is_awardee' => true,
    ]);

    AlumniTracer::create([
        'user_id' => $workingAlumni->id,
        'company_name' => 'PT Contoh',
        'job_title' => 'Software Engineer',
        'city' => 'Bandar Lampung',
        'waiting_months' => 2,
        'ready_for_sharing' => true,
        'contact_linkedin' => 'https://www.linkedin.com/in/alumni-contoh',
    ]);

    $otherAlumni = User::factory()->create([
        'name' => 'Alumni Belum Bekerja',
        'nim_nip' => '222222',
        'major' => 'Fisika',
        'academic_status' => 'alumni',
        'is_awardee' => true,
    ]);

    AlumniTracer::create([
        'user_id' => $otherAlumni->id,
        'waiting_months' => 0,
        'ready_for_sharing' => false,
    ]);

    $nonAwardee = User::factory()->create([
        'name' => 'Bukan Alumni Awardee',
        'academic_status' => 'alumni',
        'is_awardee' => false,
    ]);

    AlumniTracer::create([
        'user_id' => $nonAwardee->id,
        'company_name' => 'PT Contoh',
        'job_title' => 'Staff',
    ]);

    $this->get(route('tracer.rekap'))
        ->assertOk()
        ->assertSee('Alumni Awardee')
        ->assertSee('Alumni Bekerja')
        ->assertSee('Alumni Belum Bekerja')
        ->assertDontSee('Bukan Alumni Awardee')
        ->assertSee('Software Engineer')
        ->assertSee('Respons per Jurusan')
        ->assertSee('Ekspor CSV');

    $this->get(route('tracer.rekap', [
        'search' => '111111',
        'major' => 'Ilmu Komputer',
        'sharing' => 'yes',
    ]))
        ->assertOk()
        ->assertSee('Alumni Bekerja')
        ->assertDontSee('Alumni Belum Bekerja');
});

it('exports filtered tracer data as a CSV download', function () {
    $alumni = User::factory()->create([
        'name' => 'Alumni Narasumber',
        'nim_nip' => '333333',
        'major' => 'Kimia',
        'academic_status' => 'alumni',
        'is_awardee' => true,
    ]);

    AlumniTracer::create([
        'user_id' => $alumni->id,
        'company_name' => 'PT Ekspor',
        'job_title' => 'Analis',
        'city' => 'Bandar Lampung',
        'waiting_months' => 4,
        'ready_for_sharing' => true,
        'contact_linkedin' => 'https://www.linkedin.com/in/alumni-narasumber',
    ]);

    $response = $this->get(route('tracer.rekap.export', ['major' => 'Kimia']));

    $response->assertOk()
        ->assertDownload();

    expect($response->streamedContent())
        ->toContain('Nama Alumni')
        ->toContain('Alumni Narasumber')
        ->toContain('https://www.linkedin.com/in/alumni-narasumber');
});
