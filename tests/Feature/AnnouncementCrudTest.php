<?php

use App\Models\Announcement;
use App\Models\User;

it('allows administrators to create, edit, publish, and delete announcements', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('announcements.manage'))
        ->assertOk()
        ->assertSee('Kelola Pengumuman');

    $this->actingAs($admin)
        ->post(route('announcements.store'), [
            'title' => 'Jadwal Beasiswa',
            'content' => 'Pengumpulan berkas dibuka minggu depan.',
            'is_active' => '1',
        ])
        ->assertRedirect(route('announcements.manage'));

    $announcement = Announcement::query()->where('title', 'Jadwal Beasiswa')->firstOrFail();
    expect($announcement->created_by)->toBe($admin->id)
        ->and($announcement->is_active)->toBeTrue();

    $this->get(route('announcements.index'))
        ->assertOk()
        ->assertSee('Jadwal Beasiswa')
        ->assertSee('Pengumpulan berkas dibuka minggu depan.');

    $this->actingAs($admin)
        ->put(route('announcements.update', $announcement), [
            'title' => 'Jadwal Beasiswa Diperbarui',
            'content' => 'Informasi terbaru untuk mahasiswa.',
        ])
        ->assertRedirect(route('announcements.manage'));

    expect($announcement->fresh()->is_active)->toBeFalse();

    $this->get(route('announcements.index'))
        ->assertOk()
        ->assertDontSee('Jadwal Beasiswa Diperbarui');

    $this->actingAs($admin)
        ->delete(route('announcements.destroy', $announcement))
        ->assertRedirect(route('announcements.manage'));

    $this->assertDatabaseMissing('announcements', ['id' => $announcement->id]);
});

it('does not allow non-admin users to manage announcements', function () {
    $user = User::factory()->create(['role' => 'mahasiswa']);

    $this->actingAs($user)
        ->get(route('announcements.manage'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('announcements.create'))
        ->assertForbidden();
});
