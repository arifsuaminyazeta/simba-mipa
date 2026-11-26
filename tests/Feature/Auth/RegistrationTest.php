<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200)
        ->assertSee('NPM')
        ->assertSee('name="npm"', false);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'npm' => '2417051999',
        'email' => 'test@example.com',
        'major' => 'Ilmu Komputer',
        'phone' => '081234567890',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard.mahasiswa', absolute: false));
});

test('registration rejects passwords shorter than eight characters', function () {
    $this->post('/register', [
        'name' => 'Short Password User',
        'npm' => '2417051888',
        'email' => 'short-password@example.com',
        'major' => 'Ilmu Komputer',
        'password' => 'short12',
        'password_confirmation' => 'short12',
    ])->assertSessionHasErrors('password');
});
