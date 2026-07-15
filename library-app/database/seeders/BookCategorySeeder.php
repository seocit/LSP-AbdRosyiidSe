<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Novel, cerita pendek, dan karya sastra imajinatif.'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku berbasis fakta, biografi, dan memoar.'],
            ['name' => 'Sains & Teknologi', 'description' => 'Ilmu pengetahuan alam, komputer, dan inovasi teknologi.'],
            ['name' => 'Sejarah & Politik', 'description' => 'Peristiwa sejarah, pemerintahan, dan ilmu politik.'],
            ['name' => 'Ekonomi & Bisnis', 'description' => 'Manajemen, keuangan, kewirausahaan, dan pemasaran.'],
            ['name' => 'Pendidikan', 'description' => 'Buku pelajaran, referensi akademik, dan kurikulum.'],
            ['name' => 'Agama & Spiritualitas', 'description' => 'Kitab suci, tafsir, dan kajian keagamaan.'],
            ['name' => 'Kesehatan & Kedokteran', 'description' => 'Ilmu kedokteran, gizi, dan gaya hidup sehat.'],
            ['name' => 'Filsafat & Psikologi', 'description' => 'Pemikiran filosofis dan ilmu perilaku manusia.'],
            ['name' => 'Seni & Budaya', 'description' => 'Musik, lukisan, arsitektur, dan kebudayaan lokal.'],
            ['name' => 'Hukum', 'description' => 'Perundang-undangan, jurisprudensi, dan tata hukum.'],
            ['name' => 'Anak & Remaja', 'description' => 'Buku cerita bergambar, komik edukatif, dan novel remaja.'],
        ];

        foreach ($categories as $category) {
            BookCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
