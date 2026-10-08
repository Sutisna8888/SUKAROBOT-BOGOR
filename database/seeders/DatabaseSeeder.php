<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Cabang Bogor
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin Sukarobot Bogor',
            'username' => 'admin_bogor',
            'email' => 'admin@sukarobot.com',
            'phone' => '081234567890',
            'job' => 'Branch Manager',
            'address' => 'Bogor, Jawa Barat',
            'country' => 'Indonesia',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Akun & Profil Trainer / Instruktur
        $trainerUserId = DB::table('users')->insertGetId([
            'name' => 'Kak Fajar (Trainer Robotika)',
            'username' => 'fajar_trainer',
            'email' => 'trainer@sukarobot.com',
            'phone' => '081234567891',
            'job' => 'Lead Robotics Instructor',
            'address' => 'Kota Bogor, Jawa Barat',
            'country' => 'Indonesia',
            'password' => Hash::make('trainer123'),
            'role' => 'instructor',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $trainerId = DB::table('data_trainers')->insertGetId([
            'nama' => 'Kak Fajar (Trainer Robotika)',
            'email' => 'trainer@sukarobot.com',
            'telephone' => '081234567891',
            'keahlian' => 'Arduino, IoT, LEGO Robotics & Python',
            'pekerjaan' => 'Lead Robotics Instructor',
            'status_trainer' => 'Aktif',
            'pengalaman' => '5',
            'bio' => 'Instruktur robotika berpengalaman lebih dari 5 tahun dalam membina tim robotika anak dan remaja di tingkat nasional.',
            'foto' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Akun Siswa Contoh
        DB::table('users')->insert([
            'name' => 'Siswa Contoh',
            'username' => 'siswa_bogor',
            'email' => 'siswa@sukarobot.com',
            'phone' => '081234567892',
            'job' => 'Student',
            'address' => 'Bogor, Jawa Barat',
            'country' => 'Indonesia',
            'password' => Hash::make('siswa123'),
            'role' => 'user',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Contoh Program / Kelas Robotika
        DB::table('data_programs')->insert([
            [
                'program' => 'Robotika Dasar untuk Anak (Kids STEM)',
                'slug' => 'robotika-dasar-untuk-anak',
                'description' => 'Program pengenalan robotika dan logika komputasi untuk anak usia 7-14 tahun. Mempelajari sensor, aktuator, dan pemrograman visual secara menyenangkan.',
                'price' => 350000.00,
                'category' => 'Kursus',
                'type' => 'Offline',
                'image' => null,
                'zoom_link' => null,
                'status' => 'published',
                'instructor_id' => $trainerId,
                'quota' => 20,
                'enrolled_count' => 5,
                'rating' => 5.0,
                'total_reviews' => 5,
                'province' => 'Jawa Barat',
                'city' => 'Kota Bogor',
                'district' => 'Bogor Tengah',
                'village' => 'Paledang',
                'full_address' => 'Jl. Sukarobot No. 1, Kota Bogor',
                'start_date' => now()->addDays(7)->toDateString(),
                'start_time' => '09:00:00',
                'end_date' => now()->addDays(30)->toDateString(),
                'end_time' => '11:00:00',
                'tools' => json_encode(['Kit Robot Pemula', 'Software Visual Block Programming', 'Buku Panduan']),
                'learning_materials' => json_encode(['Pengenalan Komponen Robot', 'Dasar Logika Algoritma', 'Merakit Robot Pertama']),
                'benefits' => json_encode(['Sertifikat Resmi', 'Kit Robot Bawa Pulang', 'Konsultasi Belajar']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program' => 'IoT & Arduino Mastery: Smart Home System',
                'slug' => 'iot-arduino-mastery-smart-home',
                'description' => 'Pelatihan intensif pengembangan perangkat Internet of Things (IoT) berbasis Arduino dan ESP32 untuk otomasi perangkat rumah cerdas.',
                'price' => 500000.00,
                'category' => 'Pelatihan',
                'type' => 'Online',
                'image' => null,
                'zoom_link' => 'https://zoom.us/j/123456789',
                'status' => 'published',
                'instructor_id' => $trainerId,
                'quota' => 30,
                'enrolled_count' => 8,
                'rating' => 4.9,
                'total_reviews' => 4,
                'province' => 'Jawa Barat',
                'city' => 'Kota Bogor',
                'district' => 'Bogor Timur',
                'village' => 'Baranangsiang',
                'full_address' => 'Online via Zoom',
                'start_date' => now()->addDays(5)->toDateString(),
                'start_time' => '13:00:00',
                'end_date' => now()->addDays(25)->toDateString(),
                'end_time' => '15:00:00',
                'tools' => json_encode(['ESP32 Development Board', 'Sensor Suhu & Kelembaban DHT11', 'Relay Module']),
                'learning_materials' => json_encode(['Dasar Pemrograman C++ Arduino', 'Konektivitas WiFi ESP32', 'Integrasi Dashboard Web IoT']),
                'benefits' => json_encode(['Sertifikat Kelulusan', 'Source Code Lengkap', 'Portofolio Project']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 5. Contoh Artikel Berita
        DB::table('articles')->insert([
            'title' => 'Selamat Datang di Portal Sukarobot Cabang Bogor!',
            'slug' => 'selamat-datang-sukarobot-bogor',
            'content' => '<p>Kami dengan bangga mengumumkan kehadiran portal resmi <strong>Sukarobot Cabang Bogor</strong>! Melalui platform ini, masyarakat dan para pelajar di Kota Bogor serta sekitarnya dapat mengakses berbagai program pelatihan robotika, coding, kecerdasan buatan (AI), dan IoT berstandar nasional.</p><p>Mari bergabung bersama kami untuk mempersiapkan generasi muda yang unggul di era digital dan otomasi.</p>',
            'excerpt' => 'Sukarobot kini resmi hadir di Bogor untuk mendukung edukasi teknologi dan robotika bagi generasi muda.',
            'category' => 'Berita',
            'image' => null,
            'is_published' => true,
            'published_at' => now(),
            'author_id' => $adminId,
            'views' => 12,
            'meta_title' => 'Sukarobot Cabang Bogor Resmi Dibuka',
            'meta_description' => 'Website resmi Sukarobot cabang Bogor untuk pelatihan dan kursus robotika.',
            'meta_keywords' => 'robotika bogor, kursus coding bogor, sukarobot bogor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
