<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Cover buku menggunakan path dummy — ganti file di public/images/books/ saat demo.
     */
    public function run(): void
    {
        $books = [
            // Fiksi
            [
                'category' => 'Fiksi',
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'publish_year' => '2005',
                'isbn' => '978-979-1227-00-1',
                'stock' => 5,
                'cover' => 'images/books/laskar-pelangi.jpg',
                'description' => 'Novel tentang perjuangan anak-anak Belitung dalam meraih pendidikan di tengah keterbatasan.',
            ],
            [
                'category' => 'Fiksi',
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'publish_year' => '1980',
                'isbn' => '978-979-413-940-3',
                'stock' => 3,
                'cover' => 'images/books/bumi-manusia.jpg',
                'description' => 'Kisah Minke, seorang priyayi Jawa yang bersekolah di HBS di zaman kolonial Belanda.',
            ],
            [
                'category' => 'Fiksi',
                'title' => 'Dilan 1990',
                'author' => 'Pidi Baiq',
                'publisher' => 'Mizan',
                'publish_year' => '2014',
                'isbn' => '978-979-433-878-1',
                'stock' => 4,
                'cover' => 'images/books/dilan-1990.jpg',
                'description' => 'Novel roman remaja yang mengisahkan hubungan Dilan dan Milea di Bandung tahun 1990.',
            ],

            // Sains & Teknologi
            [
                'category' => 'Sains & Teknologi',
                'title' => 'Pengantar Pemrograman Python',
                'author' => 'Dr. Bambang Haryanto',
                'publisher' => 'Informatika',
                'publish_year' => '2021',
                'isbn' => '978-602-0917-25-3',
                'stock' => 6,
                'cover' => 'images/books/pemrograman-python.jpg',
                'description' => 'Buku panduan belajar Python dari dasar hingga tingkat mahir untuk pemula.',
            ],
            [
                'category' => 'Sains & Teknologi',
                'title' => 'Kecerdasan Buatan: Konsep dan Implementasi',
                'author' => 'Agus Harjoko',
                'publisher' => 'Andi Offset',
                'publish_year' => '2020',
                'isbn' => '978-979-29-6723-4',
                'stock' => 4,
                'cover' => 'images/books/kecerdasan-buatan.jpg',
                'description' => 'Membahas konsep dasar dan implementasi kecerdasan buatan dalam berbagai bidang.',
            ],

            // Sejarah & Politik
            [
                'category' => 'Sejarah & Politik',
                'title' => 'Sejarah Indonesia Modern 1200–2004',
                'author' => 'M.C. Ricklefs',
                'publisher' => 'Serambi',
                'publish_year' => '2008',
                'isbn' => '978-979-1106-36-5',
                'stock' => 3,
                'cover' => 'images/books/sejarah-indonesia-modern.jpg',
                'description' => 'Pandangan komprehensif atas sejarah Indonesia dari era Hindu-Buddha hingga masa kontemporer.',
            ],
            [
                'category' => 'Sejarah & Politik',
                'title' => 'Diplomasi Indonesia',
                'author' => 'Mochtar Kusumaatmadja',
                'publisher' => 'Alumni',
                'publish_year' => '2003',
                'isbn' => '978-979-414-004-1',
                'stock' => 2,
                'cover' => 'images/books/diplomasi-indonesia.jpg',
                'description' => 'Analisis kebijakan luar negeri dan diplomasi Indonesia dalam percaturan politik internasional.',
            ],

            // Ekonomi & Bisnis
            [
                'category' => 'Ekonomi & Bisnis',
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert T. Kiyosaki',
                'publisher' => 'Gramedia',
                'publish_year' => '2000',
                'isbn' => '978-979-22-6657-5',
                'stock' => 7,
                'cover' => 'images/books/rich-dad-poor-dad.jpg',
                'description' => 'Pelajaran tentang uang, investasi, dan kebebasan finansial dari dua sudut pandang berbeda.',
            ],
            [
                'category' => 'Ekonomi & Bisnis',
                'title' => 'Zero to One',
                'author' => 'Peter Thiel',
                'publisher' => 'Gramedia',
                'publish_year' => '2014',
                'isbn' => '978-979-22-9849-1',
                'stock' => 5,
                'cover' => 'images/books/zero-to-one.jpg',
                'description' => 'Panduan membangun startup inovatif dan menciptakan sesuatu yang benar-benar baru.',
            ],

            // Pendidikan
            [
                'category' => 'Pendidikan',
                'title' => 'Guru Profesional',
                'author' => 'Hamzah B. Uno',
                'publisher' => 'Bumi Aksara',
                'publish_year' => '2010',
                'isbn' => '978-979-010-523-7',
                'stock' => 4,
                'cover' => 'images/books/guru-profesional.jpg',
                'description' => 'Panduan pengembangan kompetensi dan profesionalisme guru di era modern.',
            ],

            // Agama & Spiritualitas
            [
                'category' => 'Agama & Spiritualitas',
                'title' => 'La Tahzan',
                'author' => 'Dr. Aidh Al-Qarni',
                'publisher' => 'Qisthi Press',
                'publish_year' => '2004',
                'isbn' => '978-979-3715-00-3',
                'stock' => 8,
                'cover' => 'images/books/la-tahzan.jpg',
                'description' => 'Buku motivasi Islami yang mengajarkan cara menghadapi masalah dengan ketenangan hati.',
            ],

            // Kesehatan & Kedokteran
            [
                'category' => 'Kesehatan & Kedokteran',
                'title' => 'Hidup Sehat ala Rasulullah',
                'author' => 'Zaidul Akbar',
                'publisher' => 'Tiga Serangkai',
                'publish_year' => '2018',
                'isbn' => '978-602-2013-04-2',
                'stock' => 6,
                'cover' => 'images/books/hidup-sehat-rasulullah.jpg',
                'description' => 'Panduan pola hidup sehat berdasarkan sunnah Nabi Muhammad SAW.',
            ],

            // Anak & Remaja
            [
                'category' => 'Anak & Remaja',
                'title' => 'Harry Potter dan Batu Bertuah',
                'author' => 'J.K. Rowling',
                'publisher' => 'Gramedia',
                'publish_year' => '2000',
                'isbn' => '978-979-22-0474-4',
                'stock' => 5,
                'cover' => 'images/books/harry-potter-1.jpg',
                'description' => 'Kisah ajaib bocah penyihir Harry Potter yang memulai petualangannya di Hogwarts.',
            ],
            [
                'category' => 'Anak & Remaja',
                'title' => 'Doraemon Vol. 1',
                'author' => 'Fujiko F. Fujio',
                'publisher' => 'Elex Media',
                'publish_year' => '2010',
                'isbn' => '978-979-27-6789-0',
                'stock' => 10,
                'cover' => 'images/books/doraemon-vol-1.jpg',
                'description' => 'Komik petualangan robot kucing dari masa depan dan sahabatnya Nobita.',
            ],

            // Non-Fiksi
            [
                'category' => 'Non-Fiksi',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'publisher' => 'Gramedia',
                'publish_year' => '2019',
                'isbn' => '978-979-22-9641-1',
                'stock' => 6,
                'cover' => 'images/books/atomic-habits.jpg',
                'description' => 'Panduan membangun kebiasaan baik dan menghilangkan kebiasaan buruk secara bertahap.',
            ],
        ];

        foreach ($books as $bookData) {
            $category = BookCategory::where('name', $bookData['category'])->first();

            if (! $category) {
                continue;
            }

            Book::firstOrCreate(
                ['title' => $bookData['title'], 'author' => $bookData['author']],
                [
                    'category_id' => $category->id,
                    'publisher' => $bookData['publisher'],
                    'publish_year' => $bookData['publish_year'],
                    'isbn' => $bookData['isbn'],
                    'stock' => $bookData['stock'],
                    'cover' => $bookData['cover'],
                    'description' => $bookData['description'],
                ]
            );
        }
    }
}
