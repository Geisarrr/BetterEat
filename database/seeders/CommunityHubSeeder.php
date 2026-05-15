<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CommunityHubSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // 1. DISEASE CATEGORIES
        // ─────────────────────────────────────────────
        $categories = [
            ['name' => 'Diet Nusantara',    'description' => 'Tips dan resep diet berbasis makanan khas nusantara.'],
            ['name' => 'Resep Sehat',        'description' => 'Kumpulan resep sehat rendah kalori dan bergizi tinggi.'],
            ['name' => 'Makanan Bersanding', 'description' => 'Kombinasi makanan yang baik untuk kesehatan.'],
            ['name' => 'Olahraga Seimbang',  'description' => 'Tips olahraga dan nutrisi yang seimbang.'],
            ['name' => 'Diabetes',           'description' => 'Panduan makan sehat untuk penderita diabetes.'],
            ['name' => 'Hipertensi',         'description' => 'Pola makan rendah garam untuk hipertensi.'],
            ['name' => 'Kolesterol',         'description' => 'Makanan penurun kolesterol alami.'],
        ];


        foreach ($categories as $cat) {
            DB::table('disease_categories')->insertOrIgnore([
                'name'        => $cat['name'],
                'description' => $cat['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $catIds = DB::table('disease_categories')->pluck('category_id', 'name');

        // ─────────────────────────────────────────────
        // 2. USERS
        // ─────────────────────────────────────────────
        $users = [
            [
                'full_name'     => 'Siti Nurhaliza',
                'username'      => 'siti_nurhaliza',
                'email'         => 'siti@example.com',
                'password_hash' => Hash::make('password'),
                'role'          => 'user',
                'profile_photo' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=D6EAB5&color=3C4C25',
            ],
            [
                'full_name'     => 'Budi Santoso',
                'username'      => 'budi_santoso',
                'email'         => 'budi@example.com',
                'password_hash' => Hash::make('password'),
                'role'          => 'user',
                'profile_photo' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=BFD4FF&color=1E3A8A',
            ],
            [
                'full_name'     => 'Rina Savitri',
                'username'      => 'rina_savitri',
                'email'         => 'rina@example.com',
                'password_hash' => Hash::make('password'),
                'role'          => 'user',
                'profile_photo' => 'https://ui-avatars.com/api/?name=Rina+Savitri&background=FFD6D6&color=8A1E1E',
            ],
            [
                'full_name'     => 'Ahmad Fauzi',
                'username'      => 'ahmad_fauzi',
                'email'         => 'ahmad@example.com',
                'password_hash' => Hash::make('password'),
                'role'          => 'user',
                'profile_photo' => 'https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=FFF3CD&color=856404',
            ],
            [
                'full_name'     => 'Dewi Lestari',
                'username'      => 'dewi_lestari',
                'email'         => 'dewi@example.com',
                'password_hash' => Hash::make('password'),
                'role'          => 'user',
                'profile_photo' => 'https://ui-avatars.com/api/?name=Dewi+Lestari&background=E8D5FF&color=5B21B6',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insertOrIgnore(array_merge($user, [
                'created_at' => now(),
            ]));
        }

        $userIds = DB::table('users')
            ->whereIn('username', array_column($users, 'username'))
            ->pluck('user_id', 'username');

        // ─────────────────────────────────────────────
        // 3. USER PROFILES
        // ─────────────────────────────────────────────
        $profiles = [
            ['username' => 'siti_nurhaliza', 'health_condition' => 'Diabetes Tipe 2', 'age' => 34, 'weight_kg' => 58, 'daily_calorie_target' => 1800],
            ['username' => 'budi_santoso',   'health_condition' => 'Hipertensi',       'age' => 45, 'weight_kg' => 75, 'daily_calorie_target' => 2000],
            ['username' => 'rina_savitri',   'health_condition' => 'Kolesterol Tinggi','age' => 38, 'weight_kg' => 62, 'daily_calorie_target' => 1600],
            ['username' => 'ahmad_fauzi',    'health_condition' => 'Sehat',            'age' => 28, 'weight_kg' => 70, 'daily_calorie_target' => 2200],
            ['username' => 'dewi_lestari',   'health_condition' => 'Sehat',            'age' => 26, 'weight_kg' => 52, 'daily_calorie_target' => 1700],
        ];

        foreach ($profiles as $p) {
            $userId = $userIds[$p['username']] ?? null;
            if (!$userId) continue;

            DB::table('user_profiles')->insertOrIgnore([
                'user_id'              => $userId,
                'health_condition'     => $p['health_condition'],
                'age'                  => $p['age'],
                'weight_kg'            => $p['weight_kg'],
                'daily_calorie_target' => $p['daily_calorie_target'],
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);
        }

        // ─────────────────────────────────────────────
        // 4. POSTS
        // ─────────────────────────────────────────────
        $posts = [
            [
                'username'     => 'siti_nurhaliza',
                'category'     => 'Diet Nusantara',
                'title'        => 'Gado-Gado Rendah Kalori untuk Penderita Diabetes',
                'content'      => 'Baru coba resep Gado-Gado rendah karbohidrat kemarin, hasilnya luar biasa! Kunci suksesnya adalah mengganti bumbu kacang biasa dengan bumbu kacang homemade tanpa gula tambahan. Saya juga menambahkan lebih banyak sayuran hijau seperti kangkung dan bayam. Gula darah saya stabil setelah makan ini. Siapa yang mau coba?',
                'image_url'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Gado-gado_Betawi.jpg/1280px-Gado-gado_Betawi.jpg',
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subHours(3),
            ],
            [
                'username'     => 'budi_santoso',
                'category'     => 'Hipertensi',
                'title'        => 'Tips Sarapan Sehat untuk Penderita Hipertensi',
                'content'      => 'Tips sarapan sehat hari ini. Daripada mie instan yang tinggi sodium, coba sarapan dengan oatmeal + buah pisang + susu rendah lemak. Sodium rendah, serat tinggi, dan bikin kenyang sampai siang. Saya sudah rutin 3 bulan dan tekanan darah saya turun dari 150/90 menjadi 130/80. Ingat ya, konsultasi dokter tetap wajib ya teman-teman! #HipertensiBerkelanjutan #BetterEat',
                'image_url'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Oatmeal_with_berries.jpg/1280px-Oatmeal_with_berries.jpg',
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subHours(7),
            ],
            [
                'username'     => 'rina_savitri',
                'category'     => 'Resep Sehat',
                'title'        => 'Nasi Merah + Sayur Asem: Combo Sempurna untuk Kolesterol',
                'content'      => 'Siapa bilang makan sehat itu membosankan? Nasi merah dengan sayur asem khas Sunda adalah jawaban sempurna untuk teman-teman dengan kolesterol tinggi. Nasi merah kaya serat yang membantu menyerap kolesterol jahat, sementara sayur asem penuh antioksidan dari asam jawa dan berbagai rempah. Resep lengkap ada di kolom komentar!',
                'image_url'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Sayur_asem.jpg/1280px-Sayur_asem.jpg',
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subDays(1),
            ],
            [
                'username'     => 'ahmad_fauzi',
                'category'     => 'Olahraga Seimbang',
                'title'        => 'Kombinasi Lari Pagi + Sarapan Bergizi: 30 Hari Challenge',
                'content'      => 'Hari ke-15 dari 30 hari challenge rutin lari pagi + sarapan bergizi. Hasilnya? Berat badan turun 2 kg, energi lebih stabil sepanjang hari, dan mood jauh lebih baik! Yang paling penting adalah konsistensi. Sarapan saya setiap pagi: 2 butir telur rebus + roti gandum + jus jeruk. Kalori total sekitar 450 kkal, cukup untuk aktivitas pagi hari.',
                'image_url'    => null,
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subDays(2),
            ],
            [
                'username'     => 'dewi_lestari',
                'category'     => 'Makanan Bersanding',
                'title'        => 'Smoothie Bowl Nusantara: Enak, Sehat, dan Instagramable!',
                'content'      => 'Perkenalkan kreasi terbaru saya: Smoothie Bowl Nusantara! Bahan utamanya pisang, mangga harum manis, dan yogurt plain. Topping-nya granola oats, irisan buah naga, biji chia, dan madu asli. Total kalori sekitar 380 kkal tapi mengenyangkan dan kaya nutrisi. Buah-buahan lokal kita memang juara! Coba sekarang dan tag @BetterEat ya!',
                'image_url'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Acai_bowl.jpg/1280px-Acai_bowl.jpg',
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subDays(3),
            ],
            [
                'username'     => 'siti_nurhaliza',
                'category'     => 'Diabetes',
                'title'        => 'Pengganti Nasi untuk Diabetesi: Apa Saja Pilihannya?',
                'content'      => 'Sebagai penderita diabetes tipe 2 sudah 2 tahun, saya sudah mencoba berbagai pengganti nasi putih. Berikut review jujur saya: 1) Nasi merah — tekstur oke, indeks glikemik lebih rendah. 2) Nasi Shirataki — sangat rendah kalori tapi perlu adaptasi rasa. 3) Kembang kol cacah — mengejutkan enak jika dimasak dengan bumbu yang tepat! 4) Ubi rebus — manis alami, serat tinggi. Mana favorit kalian?',
                'image_url'    => null,
                'is_moderated' => true,
                'created_at'   => Carbon::now()->subDays(4),
            ],
        ];

        $postIds = [];
        foreach ($posts as $post) {
            $userId = $userIds[$post['username']] ?? null;
            $catId  = $catIds[$post['category']] ?? null;
            if (!$userId || !$catId) continue;

            $id = DB::table('posts')->insertGetId([
                'user_id'      => $userId,
                'category_id'  => $catId,
                'title'        => $post['title'],
                'content'      => $post['content'],
                'image_url'    => $post['image_url'],
                'is_moderated' => $post['is_moderated'],
                'created_at'   => $post['created_at'],
            ]);

            $postIds[$post['title']] = $id;
        }

        // ─────────────────────────────────────────────
        // 5. COMMENTS
        // ─────────────────────────────────────────────
        $allPostIds   = array_values($postIds);
        $allUserIds   = array_values($userIds->toArray());

        $commentsData = [
            // Post 1 (Gado-Gado)
            [
                'post_key'  => 'Gado-Gado Rendah Kalori untuk Penderita Diabetes',
                'username'  => 'budi_santoso',
                'content'   => 'Wah resepnya keren banget kak! Boleh minta detail takaran bumbu kacangnya?',
                'parent'    => null,
                'created_at'=> Carbon::now()->subHours(2),
            ],
            [
                'post_key'  => 'Gado-Gado Rendah Kalori untuk Penderita Diabetes',
                'username'  => 'siti_nurhaliza',
                'content'   => 'Tentu! Kacang tanah 100g sangrai, bawang putih 2 siung, cabe rawit sesuai selera, garam sedikit, dan perasan jeruk nipis. Semua diblender tanpa gula sama sekali!',
                'parent'    => 'budi_santoso_gado',
                'created_at'=> Carbon::now()->subHours(1),
            ],
            [
                'post_key'  => 'Gado-Gado Rendah Kalori untuk Penderita Diabetes',
                'username'  => 'dewi_lestari',
                'content'   => 'Saya sudah coba resep ini minggu lalu, enak banget dan memang bikin kenyang lama. Recommended!',
                'parent'    => null,
                'created_at'=> Carbon::now()->subMinutes(45),
            ],

            // Post 2 (Oatmeal Hipertensi)
            [
                'post_key'  => 'Tips Sarapan Sehat untuk Penderita Hipertensi',
                'username'  => 'rina_savitri',
                'content'   => 'Saya juga sudah coba teknik ini! Tambahkan kayu manis ke oatmeal, konon membantu mengatur tekanan darah juga.',
                'parent'    => null,
                'created_at'=> Carbon::now()->subHours(5),
            ],
            [
                'post_key'  => 'Tips Sarapan Sehat untuk Penderita Hipertensi',
                'username'  => 'ahmad_fauzi',
                'content'   => 'Mantap pak! Konsisten memang kuncinya. Saya sudah coba 1 bulan juga hasilnya positif.',
                'parent'    => null,
                'created_at'=> Carbon::now()->subHours(4),
            ],

            // Post 3 (Nasi Merah)
            [
                'post_key'  => 'Nasi Merah + Sayur Asem: Combo Sempurna untuk Kolesterol',
                'username'  => 'siti_nurhaliza',
                'content'   => 'Boleh minta resep sayur asemnya kak? Mau coba masak besok!',
                'parent'    => null,
                'created_at'=> Carbon::now()->subHours(20),
            ],
            [
                'post_key'  => 'Nasi Merah + Sayur Asem: Combo Sempurna untuk Kolesterol',
                'username'  => 'rina_savitri',
                'content'   => 'Tentu! Bahan: jagung manis, labu siam, kacang panjang, daun melinjo, asam jawa, lengkuas, bawang putih, bawang merah, cabe merah. Rebus semua dengan air 1 liter, tambah asam jawa dan garam secukupnya. Sehat banget!',
                'parent'    => 'siti_nasi_merah',
                'created_at'=> Carbon::now()->subHours(19),
            ],
        ];

        // Map to insert comments (simplified, without nested parent tracking complexity)
        $parentCommentIdMap = [];
        foreach ($commentsData as $c) {
            $userId = $userIds[$c['username']] ?? null;
            $postId = $postIds[$c['post_key']] ?? null;
            if (!$userId || !$postId) continue;

            // Handle parent comment (set to null for top-level, look up for replies)
            $parentId = null;
            if ($c['parent'] !== null && isset($parentCommentIdMap[$c['parent']])) {
                $parentId = $parentCommentIdMap[$c['parent']];
            }

            $commentId = DB::table('comments')->insertGetId([
                'post_id'           => $postId,
                'user_id'           => $userId,
                'parent_comment_id' => $parentId,
                'content'           => $c['content'],
                'created_at'        => $c['created_at'],
            ]);

            // Track first comment by user on specific post as potential parent for replies
            $key = $c['username'] . '_' . substr($c['post_key'], 0, 10);
            if (!isset($parentCommentIdMap[$key])) {
                $parentCommentIdMap[$key] = $commentId;
            }
            // Also track specific parent keys from our data
            if ($c['parent'] === null) {
                // Use shorthand keys that replies will reference
                if ($c['username'] === 'budi_santoso' && str_contains($c['post_key'], 'Gado')) {
                    $parentCommentIdMap['budi_santoso_gado'] = $commentId;
                }
                if ($c['username'] === 'siti_nurhaliza' && str_contains($c['post_key'], 'Nasi')) {
                    $parentCommentIdMap['siti_nasi_merah'] = $commentId;
                }
            }
        }

        // ─────────────────────────────────────────────
        // 6. POST LIKES
        // ─────────────────────────────────────────────
        $likesData = [];
        foreach ($allPostIds as $pid) {
            // Randomly assign 2–4 likes per post from different users
            $shuffled = $allUserIds;
            shuffle($shuffled);
            $likers = array_slice($shuffled, 0, rand(2, 4));
            foreach ($likers as $uid) {
                $likesData[] = ['post_id' => $pid, 'user_id' => $uid];
            }
        }

        // Insert unique likes only (no duplicate post_id + user_id)
        $inserted = [];
        foreach ($likesData as $like) {
            $key = $like['post_id'] . '_' . $like['user_id'];
            if (!isset($inserted[$key])) {
                DB::table('post_likes')->insertOrIgnore($like);
                $inserted[$key] = true;
            }
        }

        // ─────────────────────────────────────────────
        // 7. RECIPES (Sidebar data)
        // ─────────────────────────────────────────────
        // Only seed if recipes table is empty to avoid conflicts
        if (DB::table('recipes')->count() === 0) {
            $recipes = [
                [
                    'title'       => 'Tempe Goreng untuk Anak Diet Sehat',
                    'description' => 'Tempe goreng renyah tanpa tepung, kaya protein, rendah kalori.',
                    'image_url'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Tempeh.jpg/640px-Tempeh.jpg',
                    'category'    => 'Diet Nusantara',
                ],
                [
                    'title'       => 'Perkedel Kentang Sehat Makanane Bersanding',
                    'description' => 'Perkedel kentang dipanggang, bukan digoreng, tanpa mengurangi cita rasa.',
                    'image_url'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Perkedel.jpg/640px-Perkedel.jpg',
                    'category'    => 'Resep Sehat',
                ],
                [
                    'title'       => 'Pepes Ikan Nila Bumbu Rempah',
                    'description' => 'Pepes ikan nila dikukus dengan daun pisang, kaya omega-3 dan serat.',
                    'image_url'   => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Pepes_ikan.jpg/640px-Pepes_ikan.jpg',
                    'category'    => 'Diet Nusantara',
                ],
            ];

            foreach ($recipes as $recipe) {
                $catId = $catIds[$recipe['category']] ?? $catIds->first();
                DB::table('recipes')->insertOrIgnore([
                    'category_id'  => $catId,
                    'title'        => $recipe['title'],
                    'description'  => $recipe['description'],
                    'image_url'    => $recipe['image_url'],
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }

        $this->command->info('✅ CommunityHubSeeder selesai!');
        $this->command->info('   → ' . count($categories) . ' kategori penyakit');
        $this->command->info('   → ' . count($users)      . ' user dummy');
        $this->command->info('   → ' . count($posts)      . ' postingan');
        $this->command->info('   → Komentar + balasan + likes sudah ditambahkan');
        $this->command->info('');
        $this->command->info('Login dengan: email = siti@example.com | password = password');
    }
}