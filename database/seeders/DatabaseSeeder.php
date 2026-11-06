<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SemesterEvaluation;
use App\Models\AlumniTracer;
use App\Models\Announcement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        $admin = User::updateOrCreate(
            ['email' => 'admin.simbamipa@gmail.com'],
            [
                'name' => 'Administrator SIMBA',
                'password' => 'Admin12345',
                'role' => 'admin',
                'nim_nip' => '100000001',
                'major' => 'Admin',
                'academic_status' => 'aktif',
                'is_awardee' => false,
                'email_verified_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | DOSEN
        |--------------------------------------------------------------------------
        */

        $dosen1 = User::updateOrCreate(
            ['email' => 'dosen1@simba.test'],
            [
                'name' => 'Dr. Budi Santoso, M.Kom',
                'password' => 'password',
                'role' => 'dosen',
                'nim_nip' => '198001012005011001',
                'major' => 'Ilmu Komputer',
                'academic_status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        $dosen2 = User::updateOrCreate(
            ['email' => 'dosen2@simba.test'],
            [
                'name' => 'Dr. Siti Rahmawati, M.Si',
                'password' => 'password',
                'role' => 'dosen',
                'nim_nip' => '198502022010012002',
                'major' => 'Matematika',
                'academic_status' => 'aktif',
                'email_verified_at' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | MAHASISWA
        |--------------------------------------------------------------------------
        */

        $students = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@simba.test',
                'nim_nip' => '2217051001',
                'major' => 'Ilmu Komputer',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Lestari Putri',
                'email' => 'lestari@simba.test',
                'nim_nip' => '2317041020',
                'major' => 'Fisika',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@simba.test',
                'nim_nip' => '2317051012',
                'major' => 'Ilmu Komputer',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia@simba.test',
                'nim_nip' => '2317031005',
                'major' => 'Matematika',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'dimas@simba.test',
                'nim_nip' => '2217041015',
                'major' => 'Fisika',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Salsa Amelia',
                'email' => 'salsa@simba.test',
                'nim_nip' => '2317021008',
                'major' => 'Kimia',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar@simba.test',
                'nim_nip' => '2217011009',
                'major' => 'Biologi',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'Putri Maharani',
                'email' => 'putri@simba.test',
                'nim_nip' => '2317051025',
                'major' => 'Ilmu Komputer',
                'dosen_pa_id' => $dosen1->id,
            ],
        ];

        $mahasiswa = [];

        foreach ($students as $student) {
            $mahasiswa[$student['email']] = User::updateOrCreate(
                ['email' => $student['email']],
                array_merge($student, [
                    'password' => 'password',
                    'role' => 'mahasiswa',
                    'academic_status' => 'aktif',
                    'is_awardee' => false,
                    'email_verified_at' => now(),
                ])
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA BEASISWA
        |--------------------------------------------------------------------------
        */

        $scholarshipData = [
            [
                'name' => 'Beasiswa Bank Indonesia',
                'provider' => 'Bank Indonesia',
                'min_gpa' => 3.00,
                'quota' => 30,
                'remaining_quota' => 22,
                'open_date' => '2026-10-01',
                'close_date' => '2026-12-15',
                'status' => 'open',
            ],
            [
                'name' => 'Djarum Beasiswa Plus',
                'provider' => 'Djarum Foundation',
                'min_gpa' => 3.20,
                'quota' => 20,
                'remaining_quota' => 14,
                'open_date' => '2026-10-05',
                'close_date' => '2026-12-20',
                'status' => 'open',
            ],
            [
                'name' => 'Beasiswa KIP Kuliah',
                'provider' => 'Kemendikbudristek',
                'min_gpa' => 2.75,
                'quota' => 50,
                'remaining_quota' => 35,
                'open_date' => '2026-09-01',
                'close_date' => '2026-11-30',
                'status' => 'open',
            ],
            [
                'name' => 'Beasiswa Unggulan',
                'provider' => 'Kemendikbudristek',
                'min_gpa' => 3.50,
                'quota' => 15,
                'remaining_quota' => 10,
                'open_date' => '2026-08-01',
                'close_date' => '2026-09-30',
                'status' => 'closed',
            ],
            [
                'name' => 'Beasiswa Prestasi Akademik FMIPA',
                'provider' => 'FMIPA Universitas Lampung',
                'min_gpa' => 3.25,
                'quota' => 25,
                'remaining_quota' => 17,
                'open_date' => '2026-10-10',
                'close_date' => '2026-12-10',
                'status' => 'open',
            ],
        ];

        $scholarships = [];

        foreach ($scholarshipData as $data) {
            $scholarships[$data['name']] = Scholarship::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PENGAJUAN BEASISWA
        |--------------------------------------------------------------------------
        */

        $applications = [
            [
                'email' => 'ahmad@simba.test',
                'scholarship' => 'Beasiswa Bank Indonesia',
                'gpa' => 3.88,
                'status' => 'verified_by_dosen',
                'notes' => 'Berkas lengkap dan memenuhi persyaratan akademik.',
            ],
            [
                'email' => 'lestari@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'gpa' => 3.65,
                'status' => 'verified_by_dosen',
                'notes' => 'Dokumen telah diperiksa dan dinyatakan memenuhi syarat.',
            ],
            [
                'email' => 'rizky@simba.test',
                'scholarship' => 'Beasiswa KIP Kuliah',
                'gpa' => 3.45,
                'status' => 'pending',
                'notes' => null,
            ],
            [
                'email' => 'nadia@simba.test',
                'scholarship' => 'Beasiswa Prestasi Akademik FMIPA',
                'gpa' => 3.91,
                'status' => 'approved_by_admin',
                'notes' => 'Pengajuan disetujui.',
            ],
            [
                'email' => 'dimas@simba.test',
                'scholarship' => 'Beasiswa Bank Indonesia',
                'gpa' => 3.72,
                'status' => 'rejected_by_dosen',
                'notes' => 'Dokumen persyaratan belum lengkap.',
            ],
            [
                'email' => 'salsa@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'gpa' => 3.80,
                'status' => 'rejected_by_admin',
                'notes' => 'Tidak lolos seleksi akhir.',
            ],
            [
                'email' => 'fajar@simba.test',
                'scholarship' => 'Beasiswa KIP Kuliah',
                'gpa' => 3.25,
                'status' => 'pending',
                'notes' => null,
            ],
            [
                'email' => 'putri@simba.test',
                'scholarship' => 'Beasiswa Unggulan',
                'gpa' => 3.95,
                'status' => 'verified_by_dosen',
                'notes' => 'Direkomendasikan untuk seleksi akhir.',
            ],
        ];

        foreach ($applications as $item) {
            $user = $mahasiswa[$item['email']];
            $scholarship = $scholarships[$item['scholarship']];

            $application = ScholarshipApplication::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'scholarship_id' => $scholarship->id,
                ],
                [
                    'gpa_score' => $item['gpa'],
                    'document_file' => 'documents/contoh-berkas.pdf',
                    'acceptance_proof_file' => $item['status'] === 'approved_by_admin'
                        ? 'documents/contoh-sk.pdf'
                        : null,
                    'status' => $item['status'],
                    'dosen_notes' => $item['notes'],
                ]
            );

            if ($item['status'] === 'approved_by_admin') {
                $user->update(['is_awardee' => true]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EVALUASI KHS
        |--------------------------------------------------------------------------
        */

        $evaluations = [
            [
                'email' => 'nadia@simba.test',
                'scholarship' => 'Beasiswa Prestasi Akademik FMIPA',
                'semester' => 4,
                'ips' => 3.85,
                'status' => 'verified',
            ],
            [
                'email' => 'ahmad@simba.test',
                'scholarship' => 'Beasiswa Bank Indonesia',
                'semester' => 5,
                'ips' => 3.78,
                'status' => 'pending',
            ],
            [
                'email' => 'lestari@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'semester' => 4,
                'ips' => 3.10,
                'status' => 'warning',
            ],
            [
                'email' => 'putri@simba.test',
                'scholarship' => 'Beasiswa Unggulan',
                'semester' => 5,
                'ips' => 3.92,
                'status' => 'verified',
            ],
        ];

        foreach ($evaluations as $item) {
            SemesterEvaluation::firstOrCreate(
                [
                    'user_id' => $mahasiswa[$item['email']]->id,
                    'scholarship_id' => $scholarships[$item['scholarship']]->id,
                    'semester_ke' => $item['semester'],
                ],
                [
                    'ips_score' => $item['ips'],
                    'khs_file' => 'documents/contoh-khs.pdf',
                    'status' => $item['status'],
                    'evaluator_notes' => 'Data evaluasi contoh untuk demonstrasi.',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TRACER STUDY ALUMNI
        |--------------------------------------------------------------------------
        */

        $alumni = [
            [
                'name' => 'Alumni Pertama',
                'email' => 'alumni1@simba.test',
                'nim_nip' => '2017051001',
                'major' => 'Ilmu Komputer',
                'company' => 'PT Teknologi Indonesia',
                'job' => 'Software Developer',
                'city' => 'Bandar Lampung',
            ],
            [
                'name' => 'Alumni Kedua',
                'email' => 'alumni2@simba.test',
                'nim_nip' => '2017041002',
                'major' => 'Fisika',
                'company' => 'PT Energi Nusantara',
                'job' => 'Data Analyst',
                'city' => 'Jakarta',
            ],
        ];

        foreach ($alumni as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => 'password',
                    'role' => 'mahasiswa',
                    'nim_nip' => $item['nim_nip'],
                    'major' => $item['major'],
                    'academic_status' => 'alumni',
                    'is_awardee' => false,
                    'email_verified_at' => now(),
                ]
            );

            AlumniTracer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $item['company'],
                    'job_title' => $item['job'],
                    'city' => $item['city'],
                    'waiting_months' => 2,
                    'ready_for_sharing' => true,
                    'contact_linkedin' => 'https://www.linkedin.com/',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN
        |--------------------------------------------------------------------------
        */

        $announcements = [
            [
                'title' => 'Pembukaan Pendaftaran Beasiswa Semester Ganjil 2026/2027',
                'content' => 'Pendaftaran program beasiswa FMIPA Universitas Lampung telah dibuka. Mahasiswa dapat melihat katalog beasiswa dan melengkapi dokumen persyaratan melalui sistem SIMBA-MIPA.',
            ],
            [
                'title' => 'Pengumpulan Berkas Persyaratan Beasiswa',
                'content' => 'Seluruh mahasiswa yang mendaftar diharapkan memeriksa kembali kelengkapan dokumen sebelum batas akhir pendaftaran.',
            ],
            [
                'title' => 'Evaluasi Kartu Hasil Studi Awardee',
                'content' => 'Mahasiswa penerima beasiswa diwajibkan mengunggah KHS sebagai bagian dari evaluasi akademik setiap semester.',
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::updateOrCreate(
                ['title' => $announcement['title']],
                [
                    'content' => $announcement['content'],
                    'is_active' => true,
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}