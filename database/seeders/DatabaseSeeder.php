<?php

namespace Database\Seeders;

use App\Models\AlumniTracer;
use App\Models\Announcement;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\SemesterEvaluation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin.simbamipa@gmail.com'],
            [
                'name' => 'Administrator SIMBA',
                'password' => 'Admin12345',
                'role' => 'admin',
                'nim_nip' => '100000001',
                'major' => null,
                'academic_status' => null,
                'is_awardee' => false,
                'is_active' => true,
                'phone' => '081270000001',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        $dosen1 = User::updateOrCreate(
            ['email' => 'dosen1@simba.test'],
            [
                'name' => 'Muhammad Afdhaluddin, M.Kom',
                'password' => 'password',
                'role' => 'dosen_pa',
                'nim_nip' => '198001012005011001',
                'major' => 'Ilmu Komputer',
                'academic_status' => null,
                'is_awardee' => false,
                'is_active' => true,
                'phone' => '081270000002',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        $dosen2 = User::updateOrCreate(
            ['email' => 'dosen2@simba.test'],
            [
                'name' => 'Dr. Siti Rahmawati, M.Si',
                'password' => 'password',
                'role' => 'dosen_pa',
                'nim_nip' => '198502022010012002',
                'major' => 'Matematika',
                'academic_status' => null,
                'is_awardee' => false,
                'is_active' => true,
                'phone' => '081270000003',
                'avatar' => null,
                'email_verified_at' => now(),
            ]
        );

        $students = [
            [
                'name' => 'M. Surya Gymnastyar',
                'email' => 'surya@simba.test',
                'nim_nip' => '2417051011',
                'major' => 'Ilmu Komputer',
                'phone' => '081234567890',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Lestari Putri',
                'email' => 'lestari@simba.test',
                'nim_nip' => '2317041020',
                'major' => 'Fisika',
                'phone' => '081270000102',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Zahira Adiah Safa',
                'email' => 'zahira@simba.test',
                'nim_nip' => '2417051012',
                'major' => 'Ilmu Komputer',
                'phone' => '081270000103',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia@simba.test',
                'nim_nip' => '2317031005',
                'major' => 'Matematika',
                'phone' => '081270000104',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'dimas@simba.test',
                'nim_nip' => '2217041015',
                'major' => 'Fisika',
                'phone' => '081270000105',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Salsa Amelia',
                'email' => 'salsa@simba.test',
                'nim_nip' => '2317021008',
                'major' => 'Kimia',
                'phone' => '081270000106',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar@simba.test',
                'nim_nip' => '2217011009',
                'major' => 'Biologi',
                'phone' => '081270000107',
                'dosen_pa_id' => $dosen2->id,
            ],
            [
                'name' => 'FX Novryandhika Widyanto',
                'email' => 'fx@simba.test',
                'nim_nip' => '2457051013',
                'major' => 'Ilmu Komputer',
                'phone' => '081270000108',
                'dosen_pa_id' => $dosen1->id,
            ],
            [
                'name' => 'Muhamad Arif',
                'email' => 'arif@simba.test',
                'nim_nip' => '2417051045',
                'major' => 'Ilmu Komputer',
                'phone' => '081270000109',
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
                    'is_active' => true,
                    'avatar' => null,
                    'email_verified_at' => now(),
                ])
            );
        }

        $scholarshipData = [
            [
                'name' => 'Beasiswa Bantuan Pendidikan Kebanksentralan 2026',
                'provider' => 'Bank Indonesia',
                'description' => 'Program beasiswa reguler dan unggulan Bank Indonesia bagi mahasiswa S1 berprestasi serta aktif dalam komunitas Generasi Baru Indonesia (GenBI).',
                'registration_url' => 'https://www.bi.go.id',
                'min_gpa' => 3.00,
                'quota' => 20,
                'open_date' => '2026-10-01',
                'close_date' => '2026-12-15',
                'status' => 'open',
            ],
            [
                'name' => 'Djarum Beasiswa Plus',
                'provider' => 'Djarum Foundation',
                'description' => 'Beasiswa prestasi disertai pelatihan soft skills kepemimpinan bagi mahasiswa S1 semester IV dari seluruh jurusan.',
                'registration_url' => 'https://djarumbeasiswaplus.org',
                'min_gpa' => 3.20,
                'quota' => 20,
                'open_date' => '2026-10-05',
                'close_date' => '2026-12-20',
                'status' => 'open',
            ],
            [
                'name' => 'Beasiswa KIP Kuliah',
                'provider' => 'Kemendikbudristek',
                'description' => 'Bantuan biaya pendidikan dan biaya hidup dari pemerintah bagi mahasiswa berprestasi dengan keterbatasan ekonomi.',
                'registration_url' => 'https://kip-kuliah.kemdikbud.go.id',
                'min_gpa' => 2.75,
                'quota' => null,
                'open_date' => '2026-09-01',
                'close_date' => '2026-11-30',
                'status' => 'open',
            ],
            [
                'name' => 'Beasiswa Unggulan',
                'provider' => 'Kemendikbudristek',
                'description' => 'Program beasiswa bagi mahasiswa berprestasi tingkat nasional maupun internasional yang sedang menempuh pendidikan jenjang S1.',
                'registration_url' => 'https://beasiswaunggulan.kemdikbud.go.id',
                'min_gpa' => 3.50,
                'quota' => 15,
                'open_date' => '2026-08-01',
                'close_date' => '2026-09-30',
                'status' => 'closed',
            ],
            [
                'name' => 'Beasiswa Prestasi Akademik FMIPA',
                'provider' => 'FMIPA Universitas Lampung',
                'description' => 'Program apresiasi akademik internal FMIPA Universitas Lampung untuk mahasiswa aktif dengan capaian IPK unggul.',
                'registration_url' => 'https://fmipa.unila.ac.id',
                'min_gpa' => 3.25,
                'quota' => 25,
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

        $applications = [
            [
                'email' => 'zahira@simba.test',
                'scholarship' => 'Beasiswa KIP Kuliah',
                'gpa' => 3.45,
                'status' => 'pending',
                'recommendation_letter_file' => null,
                'acceptance_proof_file' => null,
                'dosen_notes' => null,
                'admin_notes' => null,
            ],
            [
                'email' => 'fajar@simba.test',
                'scholarship' => 'Beasiswa KIP Kuliah',
                'gpa' => 3.38,
                'status' => 'verified_by_dosen',
                'recommendation_letter_file' => null,
                'acceptance_proof_file' => null,
                'dosen_notes' => 'Berkas lengkap dan memenuhi persyaratan akademik.',
                'admin_notes' => null,
            ],
            [
                'email' => 'dimas@simba.test',
                'scholarship' => 'Beasiswa Bantuan Pendidikan Kebanksentralan 2026',
                'gpa' => 3.72,
                'status' => 'rejected_by_dosen',
                'recommendation_letter_file' => null,
                'acceptance_proof_file' => null,
                'dosen_notes' => 'Transkrip sementara belum ditandatangani, silakan unggah ulang.',
                'admin_notes' => null,
            ],
            [
                'email' => 'salsa@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'gpa' => 3.80,
                'status' => 'rejected_by_admin',
                'recommendation_letter_file' => null,
                'acceptance_proof_file' => null,
                'dosen_notes' => 'Dokumen valid dan direkomendasikan.',
                'admin_notes' => 'Kuota rekomendasi jurusan untuk periode ini sudah terpenuhi.',
            ],
            [
                'email' => 'surya@simba.test',
                'scholarship' => 'Beasiswa Bantuan Pendidikan Kebanksentralan 2026',
                'gpa' => 3.96,
                'status' => 'approved_by_admin',
                'recommendation_letter_file' => 'documents/surat-rekomendasi-surya.pdf',
                'acceptance_proof_file' => null,
                'dosen_notes' => 'Memenuhi syarat IPK dan aktif berorganisasi.',
                'admin_notes' => 'Surat rekomendasi resmi FMIPA telah diterbitkan.',
            ],
            [
                'email' => 'fx@simba.test',
                'scholarship' => 'Beasiswa Unggulan',
                'gpa' => 3.95,
                'status' => 'loa_submitted',
                'recommendation_letter_file' => 'documents/surat-rekomendasi-fx.pdf',
                'acceptance_proof_file' => 'documents/loa-fx.pdf',
                'dosen_notes' => 'Direkomendasikan untuk pengajuan beasiswa.',
                'admin_notes' => 'Menunggu verifikasi akhir dokumen LoA oleh Admin.',
            ],
            [
                'email' => 'nadia@simba.test',
                'scholarship' => 'Beasiswa Prestasi Akademik FMIPA',
                'gpa' => 3.91,
                'status' => 'awardee_confirmed',
                'recommendation_letter_file' => 'documents/surat-rekomendasi-nadia.pdf',
                'acceptance_proof_file' => 'documents/sk-penerima-nadia.pdf',
                'dosen_notes' => 'Capaian akademik sangat baik.',
                'admin_notes' => 'SK Penerima valid, status akun ditingkatkan menjadi Awardee.',
            ],
            [
                'email' => 'lestari@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'gpa' => 3.65,
                'status' => 'awardee_confirmed',
                'recommendation_letter_file' => 'documents/surat-rekomendasi-lestari.pdf',
                'acceptance_proof_file' => 'documents/sk-penerima-lestari.pdf',
                'dosen_notes' => 'Dokumen lengkap dan memenuhi persyaratan.',
                'admin_notes' => 'Bukti kelolosan terverifikasi, aktif sebagai Awardee.',
            ],
        ];

        foreach ($applications as $item) {
            $user = $mahasiswa[$item['email']];
            $scholarship = $scholarships[$item['scholarship']];

            ScholarshipApplication::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'scholarship_id' => $scholarship->id,
                ],
                [
                    'gpa_score' => $item['gpa'],
                    'document_file' => 'documents/contoh-berkas.pdf',
                    'recommendation_letter_file' => $item['recommendation_letter_file'],
                    'acceptance_proof_file' => $item['acceptance_proof_file'],
                    'status' => $item['status'],
                    'dosen_notes' => $item['dosen_notes'],
                    'admin_notes' => $item['admin_notes'],
                ]
            );

            if ($item['status'] === 'awardee_confirmed') {
                $user->update(['is_awardee' => true]);
            }
        }

        $evaluations = [
            [
                'email' => 'nadia@simba.test',
                'scholarship' => 'Beasiswa Prestasi Akademik FMIPA',
                'semester' => 3,
                'ips' => 3.88,
                'ipk' => 3.90,
                'verification_status' => 'verified',
                'ews_status' => 'aman',
                'notes' => 'Prestasi akademik sangat stabil dan di atas syarat minimal.',
            ],
            [
                'email' => 'nadia@simba.test',
                'scholarship' => 'Beasiswa Prestasi Akademik FMIPA',
                'semester' => 4,
                'ips' => 3.85,
                'ipk' => 3.89,
                'verification_status' => 'pending',
                'ews_status' => 'aman',
                'notes' => null,
            ],
            [
                'email' => 'lestari@simba.test',
                'scholarship' => 'Djarum Beasiswa Plus',
                'semester' => 4,
                'ips' => 3.05,
                'ipk' => 3.18,
                'verification_status' => 'verified',
                'ews_status' => 'warning',
                'notes' => 'IPK berada sedikit di bawah batas minimal 3.20, disarankan mengikuti konseling akademik bersama Dosen PA.',
            ],
        ];

        foreach ($evaluations as $item) {
            SemesterEvaluation::updateOrCreate(
                [
                    'user_id' => $mahasiswa[$item['email']]->id,
                    'scholarship_id' => $scholarships[$item['scholarship']]->id,
                    'semester_ke' => $item['semester'],
                ],
                [
                    'ips_score' => $item['ips'],
                    'ipk_score' => $item['ipk'],
                    'khs_file' => 'documents/contoh-khs.pdf',
                    'verification_status' => $item['verification_status'],
                    'ews_status' => $item['ews_status'],
                    'evaluator_notes' => $item['notes'],
                ]
            );
        }

        $alumni = [
            [
                'name' => 'Alumni Pertama',
                'email' => 'alumni1@simba.test',
                'nim_nip' => '2017051001',
                'major' => 'Ilmu Komputer',
                'phone' => '081270000201',
                'employment_status' => 'bekerja',
                'company' => 'PT Teknologi Indonesia',
                'job' => 'Software Developer',
                'city' => 'Bandar Lampung',
                'waiting_months' => 2,
                'ready_for_sharing' => true,
            ],
            [
                'name' => 'Alumni Kedua',
                'email' => 'alumni2@simba.test',
                'nim_nip' => '2017041002',
                'major' => 'Fisika',
                'phone' => '081270000202',
                'employment_status' => 'studi_lanjut',
                'company' => 'Institut Teknologi Bandung',
                'job' => 'Mahasiswa S2 Fisika',
                'city' => 'Bandung',
                'waiting_months' => 3,
                'ready_for_sharing' => true,
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
                    'academic_status' => 'lulus',
                    'is_awardee' => true,
                    'is_active' => true,
                    'phone' => $item['phone'],
                    'avatar' => null,
                    'email_verified_at' => now(),
                ]
            );

            AlumniTracer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employment_status' => $item['employment_status'],
                    'company_name' => $item['company'],
                    'job_title' => $item['job'],
                    'city' => $item['city'],
                    'waiting_months' => $item['waiting_months'],
                    'ready_for_sharing' => $item['ready_for_sharing'],
                    'contact_linkedin' => 'https://www.linkedin.com/',
                ]
            );
        }

        $announcements = [
            [
                'title' => 'Pembukaan Pendaftaran Beasiswa Semester Ganjil 2026/2027',
                'content' => 'Pendaftaran program beasiswa FMIPA Universitas Lampung telah dibuka. Silakan periksa katalog beasiswa dan ajukan surat rekomendasi fakultas melalui SIMBA-MIPA.',
                'target_role' => 'public',
            ],
            [
                'title' => 'Batas Akhir Unggah KHS Evaluasi Semester Awardee',
                'content' => 'Seluruh mahasiswa penerima beasiswa aktif diwajibkan mengunggah KHS semester berjalan beserta capaian IPS dan IPK sebelum akhir bulan.',
                'target_role' => 'mahasiswa',
            ],
            [
                'title' => 'Jadwal Verifikasi Rekomendasi dan Pemantauan EWS FMIPA',
                'content' => 'Kepada Bapak/Ibu Dosen PA dan mahasiswa bimbingan, mohon memastikan verifikasi tahap 1 dan peninjauan status EWS diselesaikan sesuai lini masa semester berjalan.',
                'target_role' => 'all',
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::updateOrCreate(
                ['title' => $announcement['title']],
                [
                    'content' => $announcement['content'],
                    'target_role' => $announcement['target_role'],
                    'is_active' => true,
                    'created_by' => $admin->id,
                ]
            );
        }
    }
}