<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint; // Tidak diperlukan jika hanya insert data
// use Illuminate\Support\Facades\Schema; // Tidak diperlukan jika hanya insert data
use App\Models\ForumCategory; // Pastikan path ke model Anda benar
use Illuminate\Support\Str; // Jika Anda ingin generate slug di sini (opsional jika model sudah handle)

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => 'Teknologi & Komputer',
                'description' => 'Diskusi seputar dunia IT, pemrograman, software, hardware, jaringan, dan tren teknologi terkini.'
            ],
            [
                'name' => 'Bisnis & Pemasaran',
                'description' => 'Topik mengenai manajemen, strategi bisnis, kewirausahaan, pemasaran digital, keuangan, dan investasi.'
            ],
            [
                'name' => 'Pengembangan Diri & Karir',
                'description' => 'Meningkatkan soft skills, produktivitas, kepemimpinan, manajemen waktu, dan pengembangan profesional.'
            ],
            [
                'name' => 'Bahasa & Komunikasi',
                'description' => 'Pembelajaran berbagai bahasa asing, sastra, serta teknik komunikasi dan public speaking.'
            ],
            [
                'name' => 'Seni, Desain, & Kreativitas',
                'description' => 'Ekspresi kreatif melalui desain grafis, seni rupa, musik, fotografi, videografi, dan penulisan kreatif.'
            ],
            [
                'name' => 'Hobi & Gaya Hidup',
                'description' => 'Berbagi minat dan hobi seperti olahraga, kesehatan, memasak, travel, game, dan topik gaya hidup lainnya.'
            ],
            [
                'name' => 'Edukasi Umum',
                'description' => 'Diskusi topik pembelajaran umum, materi akademis lintas disiplin, atau hal yang tidak masuk kategori spesifik.'
            ],
        ];

        foreach ($categories as $category) {
            // Jika model ForumCategory Anda sudah memiliki boot method untuk auto-generate slug berdasarkan 'name':
            ForumCategory::create([
                'name' => $category['name'],
                'description' => $category['description'] ?? null,
            ]);

            // Jika Anda ingin generate slug secara manual di sini (dan model tidak auto-generate):
            /*
            ForumCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'] ?? null,
            ]);
            */
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Jika Anda ingin bisa melakukan rollback data ini, Anda bisa menghapus kategori
        // yang spesifik ditambahkan oleh migrasi ini.
        // Contoh:
        // $categoryNames = [
        //     'Teknologi & Komputer',
        //     'Bisnis & Pemasaran',
        //     'Pengembangan Diri & Karir',
        //     'Bahasa & Komunikasi',
        //     'Seni, Desain, & Kreativitas',
        //     'Hobi & Gaya Hidup',
        //     'Edukasi Umum',
        // ];
        // DB::table('forum_categories')->whereIn('name', $categoryNames)->delete();

        // Atau biarkan kosong jika tidak ingin ada aksi saat rollback data.
    }
};