<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(['email' => 'admin@simba.test'], [
            'name' => 'Admin SIMBA',
            'password' => 'password',
            'role' => 'admin',
            'nim_nip' => '100000001',
            'major' => 'Admin',
        ]);

        $dosen = User::updateOrCreate(['email' => 'dosen@simba.test'], [
            'name' => 'Dosen PA',
            'password' => 'password',
            'role' => 'dosen',
            'nim_nip' => '198001012005011001',
            'major' => 'Ilmu Komputer',
        ]);

        User::updateOrCreate(['email' => 'mahasiswa@simba.test'], [
            'name' => 'Mahasiswa Test',
            'password' => 'password',
            'role' => 'mahasiswa',
            'nim_nip' => '2517051001',
            'major' => 'Ilmu Komputer',
            'dosen_pa_id' => $dosen->id,
        ]);
    }
}