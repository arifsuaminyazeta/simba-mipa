<?php

use App\Models\User;

it('allows administrators to create lecturers and map active students', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $lecturer = User::factory()->create([
        'name' => 'Dosen Pembimbing',
        'role' => 'dosen',
        'major' => 'Ilmu Komputer',
    ]);
    $student = User::factory()->create([
        'role' => 'mahasiswa',
        'academic_status' => 'aktif',
        'dosen_pa_id' => null,
    ]);
    $secondStudent = User::factory()->create([
        'role' => 'mahasiswa',
        'academic_status' => 'aktif',
        'dosen_pa_id' => null,
    ]);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertOk()
        ->assertSee('Manajemen Pengguna')
        ->assertSee('Dosen Pembimbing');

    $this->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'Dosen Baru',
            'email' => 'dosen.baru@example.test',
            'nim_nip' => '198001012009011001',
            'major' => 'Fisika',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertRedirect(route('users.index'));

    $createdLecturer = User::query()->where('email', 'dosen.baru@example.test')->firstOrFail();
    expect($createdLecturer->role)->toBe('dosen');

    $this->actingAs($admin)
        ->get(route('users.advisees', $lecturer))
        ->assertOk()
        ->assertSee($student->name)
        ->assertSee($secondStudent->name);

    $this->actingAs($admin)
        ->put(route('users.advisees.update', $lecturer), [
            'student_ids' => [$student->id, $secondStudent->id],
        ])
        ->assertRedirect(route('users.advisees', $lecturer));

    expect($student->fresh()->dosen_pa_id)->toBe($lecturer->id)
        ->and($secondStudent->fresh()->dosen_pa_id)->toBe($lecturer->id);
});

it('rejects mapping non-active or non-student accounts to an advisor', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $lecturer = User::factory()->create(['role' => 'dosen']);
    $inactiveStudent = User::factory()->create([
        'role' => 'mahasiswa',
        'academic_status' => 'alumni',
    ]);

    $this->actingAs($admin)
        ->put(route('users.advisees.update', $lecturer), [
            'student_ids' => [$inactiveStudent->id],
        ])
        ->assertSessionHasErrors('student_ids.0');

    expect($inactiveStudent->fresh()->dosen_pa_id)->toBeNull();
});

it('restricts user management to administrators and lecturer records', function () {
    $student = User::factory()->create(['role' => 'mahasiswa']);
    $lecturer = User::factory()->create(['role' => 'dosen']);

    $this->actingAs($student)
        ->get(route('users.index'))
        ->assertForbidden();

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('users.edit', $student))
        ->assertNotFound();

    $this->actingAs($admin)
        ->get(route('users.advisees', $lecturer))
        ->assertOk();
});
