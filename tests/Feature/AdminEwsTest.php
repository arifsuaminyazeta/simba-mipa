<?php

use App\Models\Scholarship;
use App\Models\SemesterEvaluation;
use App\Models\User;

it('shows EWS summaries and filters semester evaluations', function () {
    $scholarship = Scholarship::create([
        'name' => 'Beasiswa Sains',
        'provider' => 'FMIPA',
        'min_gpa' => 3.00,
        'quota' => 10,
        'remaining_quota' => 8,
        'open_date' => '2026-09-01',
        'close_date' => '2026-12-01',
        'status' => 'open',
    ]);

    $createEvaluation = function (string $name, string $nim, float $ips, string $status) use ($scholarship): void {
        $user = User::factory()->create([
            'name' => $name,
            'nim_nip' => $nim,
        ]);

        SemesterEvaluation::create([
            'user_id' => $user->id,
            'scholarship_id' => $scholarship->id,
            'semester_ke' => 3,
            'ips_score' => $ips,
            'khs_file' => 'khs/' . $nim . '.pdf',
            'status' => $status,
        ]);
    };

    $createEvaluation('Mahasiswa Aman', '123456', 3.60, 'verified');
    $createEvaluation('Mahasiswa Waspada', '234567', 3.10, 'warning');
    $createEvaluation('Mahasiswa Kritis', '345678', 2.80, 'verified');
    $createEvaluation('Mahasiswa Menunggu', '456789', 3.50, 'pending');

    $this->get(route('akademik.evaluasi'))
        ->assertOk()
        ->assertSee('Total Evaluasi')
        ->assertSee('Mahasiswa Aman')
        ->assertSee('Mahasiswa Waspada')
        ->assertSee('Mahasiswa Kritis')
        ->assertSee('2 evaluasi')
        ->assertSee('1 evaluasi');

    $this->get(route('akademik.evaluasi', ['status' => 'warning', 'search' => '234567']))
        ->assertOk()
        ->assertSee('Mahasiswa Waspada')
        ->assertDontSee('Mahasiswa Aman')
        ->assertDontSee('Mahasiswa Kritis');
});
