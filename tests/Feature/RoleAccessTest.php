<?php

use App\Models\User;

it('requires authentication for user management and dashboards', function () {
    $this->get(route('users.index'))
        ->assertRedirect(route('login'));

    $this->get(route('dashboard.admin'))
        ->assertRedirect(route('login'));

    $this->get(route('dashboard.dosen'))
        ->assertRedirect(route('login'));

    $this->get(route('dashboard.mahasiswa'))
        ->assertRedirect(route('login'));

    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('restricts dashboards to the authenticated user role', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertRedirect(route('dashboard.admin'));

    $this->actingAs($admin)
        ->get(route('dashboard.mahasiswa'))
        ->assertForbidden();

    $student = User::factory()->create(['role' => 'mahasiswa']);

    $this->actingAs($student)
        ->get(route('dashboard.mahasiswa'))
        ->assertOk();

    $this->actingAs($student)
        ->get(route('dashboard.admin'))
        ->assertForbidden();
});

it('keeps the login page reachable to guests', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Silakan Login');
});
