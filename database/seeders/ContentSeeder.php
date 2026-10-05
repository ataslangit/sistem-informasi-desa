<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@sidesa.id')->first()
            ?? User::where('email', 'perangkat@sidesa.id')->first();

        // 1. Kategori Berita & Artikel
        $categoriesData = [
            ['name' => 'Kabar Desa', 'slug' => 'kabar-desa', 'type' => 'category'],
            ['name' => 'Pembangunan', 'slug' => 'pembangunan', 'type' => 'category'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'type' => 'category'],
            ['name' => 'Kesehatan & Sosial', 'slug' => 'kesehatan-sosial', 'type' => 'category'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'type' => $cat['type']]
            );
        }

        // 2. Halaman Statis Desa (type: page)
        $pages = [
            [
                'title' => 'Profil Singkat Desa Sukamaju',
                'slug' => 'profil-desa',
                'type' => Content::TYPE_PAGE,
                'summary' => 'Gambaran umum, letak geografis, demografi, dan potensi wilayah Desa Sukamaju.',
                'body' => '<p><strong>Desa Sukamaju</strong> merupakan salah satu desa di wilayah Kecamatan Cibinong, Kabupaten Bogor yang memiliki potensi unggulan di bidang pertanian, peternakan, dan UMKM kreatif. Terletak di dataran yang subur dengan lanskap persawahan dan perbukitan hijau, Desa Sukamaju terus berkembang menjadi desa modern yang mandiri dan berdaya saing.</p>
<h3>Kondisi Geografis</h3>
<p>Secara astronomis dan geografis, Desa Sukamaju berbatasan langsung dengan desa-desa tetangga yang memiliki akses jalan strategis penghubung sentra perekonomian kecamatan. Luas wilayah desa didominasi oleh lahan pertanian produktif dan pemukiman warga yang guyub dan rukun.</p>
<h3>Potensi Desa</h3>
<p>Mayoritas masyarakat berprofesi sebagai petani, pengrajin makanan tradisional, dan pedagang kelontong. Dengan hadirnya sistem digitalisasi SiDesa, transparansi dan kemudahan birokrasi terus dioptimalkan untuk memajukan kesejahteraan seluruh warga.</p>',
                'status' => Content::STATUS_PUBLISHED,
                'sort_order' => 1,
                'published_at' => Carbon::now()->subMonths(1),
            ],
            [
                'title' => 'Visi dan Misi Pembangunan Desa',
                'slug' => 'visi-misi',
                'type' => Content::TYPE_PAGE,
                'summary' => 'Arah kebijakan dan target strategis pembangunan Desa Sukamaju periode 2024-2029.',
                'body' => '<h3>Visi Desa Sukamaju</h3>
<p class="lead"><em>"Terwujudnya Desa Sukamaju yang Maju, Religius, Sejahtera, dan Berkeadilan Melalui Tata Kelola Pemerintahan yang Bersih, Cerdas, dan Transparan."</em></p>
<hr>
<h3>Misi Pembangunan Desa</h3>
<ol>
    <li>Meningkatkan kualitas pelayanan administrasi dan birokrasi desa berbasis teknologi informasi (E-Government & E-Surat).</li>
    <li>Mengembangkan potensi ekonomi lokal melalui pemberdayaan BUMDes, UMKM, dan pertanian terpadu.</li>
    <li>Meningkatkan kualitas sarana dan prasarana infrastruktur desa yang merata dan berkelanjutan.</li>
    <li>Mewujudkan masyarakat yang sehat, berpendidikan, serta menjunjung tinggi nilai gotong royong dan kearifan lokal.</li>
    <li>Menjamin transparansi pengelolaan keuangan dan aset desa yang akuntabel.</li>
</ol>',
                'status' => Content::STATUS_PUBLISHED,
                'sort_order' => 2,
                'published_at' => Carbon::now()->subMonths(1),
            ],
            [
                'title' => 'Struktur Organisasi & Tata Kerja (SOTK)',
                'slug' => 'struktur-organisasi',
                'type' => Content::TYPE_PAGE,
                'summary' => 'Bagan susunan kepengurusan dan perangkat pemerintah Desa Sukamaju.',
                'body' => '<p>Pemerintahan Desa Sukamaju dipimpin oleh Kepala Desa dibantu oleh Sekretaris Desa, Kepala Seksi (Kasi), Kepala Urusan (Kaur), dan Kepala Dusun (Kadus) yang berdedikasi melayani kepentingan warga masyarakat.</p>
<ul>
    <li><strong>Kepala Desa:</strong> H. Mulyadi, S.Sos.</li>
    <li><strong>Sekretaris Desa:</strong> Hendra Gunawan, S.AP.</li>
    <li><strong>Kasi Pemerintahan:</strong> Rahmat Hidayat</li>
    <li><strong>Kasi Kesejahteraan:</strong> Siti Sarah, S.Pd.</li>
    <li><strong>Kasi Pelayanan:</strong> Andi Prasetyo</li>
    <li><strong>Kaur Tata Usaha & Umum:</strong> Dian Anggraeni</li>
    <li><strong>Kaur Keuangan:</strong> Budi Santoso, S.E.</li>
    <li><strong>Kepala Dusun Sukamaju:</strong> Sukardi</li>
</ul>',
                'status' => Content::STATUS_PUBLISHED,
                'sort_order' => 3,
                'published_at' => Carbon::now()->subMonths(1),
            ],
        ];

        foreach ($pages as $pageData) {
            Content::updateOrCreate(
                ['slug' => $pageData['slug'], 'type' => Content::TYPE_PAGE],
                array_merge($pageData, [
                    'author_id' => $admin?->id,
                    'tenant_type' => 'village',
                    'tenant_id' => '1',
                ])
            );
        }

        // 3. Artikel Berita Desa (type: post)
        $posts = [
            [
                'title' => 'Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Triwulan Berjalan Sukses',
                'slug' => 'penyaluran-blt-dana-desa-sukses',
                'type' => Content::TYPE_POST,
                'summary' => 'Pemerintah Desa Sukamaju menyalurkan bantuan sosial langsung tunai kepada keluarga penerima manfaat secara tertib dan transparan.',
                'body' => '<p>Pemerintah Desa Sukamaju kembali merealisasikan penyaluran Bantuan Langsung Tunai (BLT) yang bersumber dari Dana Desa bertempat di Balai Pertemuan Desa. Penyaluran bantuan ini dihadiri langsung oleh Kepala Desa, Bhabinkamtibmas, Babinsa, serta perwakilan Badan Permusyawaratan Desa (BPD).</p>
<p>Total sebanyak 45 Keluarga Penerima Manfaat (KPM) menerima bantuan secara penuh tanpa potongan apapun. Kriteria penerima manfaat telah diverifikasi dan dimusyawarahkan secara transparan melalui Musyawarah Desa Khusus (Musdessus).</p>
<p>"Kami berharap dana bantuan ini dapat dimanfaatkan secara bijak untuk memenuhi kebutuhan pokok keluarga dan meringankan beban ekonomi warga," tutur Kepala Desa dalam sambutannya.</p>',
                'status' => Content::STATUS_PUBLISHED,
                'view_count' => 128,
                'published_at' => Carbon::now()->subDays(2),
                'meta' => [
                    'cover_image' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=1200&q=80',
                    'seo_title' => 'Penyaluran BLT Dana Desa Sukamaju Sukses dan Transparan',
                    'seo_description' => 'Realisasi penyaluran BLT Dana Desa kepada 45 KPM di Desa Sukamaju secara transparan.',
                ],
                'categories' => ['kabar-desa', 'pengumuman'],
            ],
            [
                'title' => 'Pembangunan Jalan Usaha Tani Dusun Sukamaju Resmi Dimulai',
                'slug' => 'pembangunan-jalan-usaha-tani-dimulai',
                'type' => Content::TYPE_POST,
                'summary' => 'Akses jalan baru sepanjang 800 meter dibuka untuk mempermudah distribusi hasil panen pertanian warga.',
                'body' => '<p>Dukungan terhadap sektor pertanian terus digenjot oleh Pemerintah Desa Sukamaju. Melalui program padat karya tunai desa (PKTD), pembangunan dan rabat beton jalan usaha tani sepanjang 800 meter di Dusun Sukamaju resmi dimulai hari ini.</p>
<p>Sebelumnya, petani kerap mengeluhkan sulitnya mengangkut hasil panen padi dan sayuran saat musim hujan karena kondisi tanah yang becek. Dengan adanya pembangunan akses jalan ini, kendaraan roda tiga maupun mobil bak terbuka akan dapat langsung menjangkau area persawahan.</p>
<p>Pekerjaan fisik melibatkan tenaga kerja lokal warga sekitar sebagai wujud pemberdayaan masyarakat dan pemerataan perputaran roda ekonomi di tingkat desa.</p>',
                'status' => Content::STATUS_PUBLISHED,
                'view_count' => 95,
                'published_at' => Carbon::now()->subDays(5),
                'meta' => [
                    'cover_image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80',
                    'seo_title' => 'Pembangunan Jalan Usaha Tani Dusun Sukamaju Dimulai',
                    'seo_description' => 'Pembukaan dan rabat beton akses jalan usaha tani untuk mendukung mobilitas pertanian warga.',
                ],
                'categories' => ['pembangunan', 'kabar-desa'],
            ],
            [
                'title' => 'Jadwal Pelayanan Posyandu Balita dan Lansia Serentak Bulan Ini',
                'slug' => 'jadwal-posyandu-balita-dan-lansia',
                'type' => Content::TYPE_POST,
                'summary' => 'Kader Posyandu bersama bidan desa menggelar penimbangan rutin, imunisasi, dan pemeriksaan kesehatan berkala.',
                'body' => '<p>Diberitahukan kepada seluruh warga Desa Sukamaju, khususnya para ibu yang memiliki balita dan keluarga lansia, bahwa kegiatan Posyandu Terpadu akan dilaksanakan serentak di masing-masing Pos RW mulai pekan depan.</p>
<p>Pelayanan yang disediakan meliputi:</p>
<ul>
    <li>Penimbangan berat badan dan pengukuran tinggi badan balita (pencegahan stunting).</li>
    <li>Pemberian makanan tambahan (PMT) bergizi.</li>
    <li>Imunisasi dasar lengkap dipandu Bidan Desa.</li>
    <li>Pemeriksaan tensi darah, gula darah, dan kolesterol bagi lansia.</li>
</ul>
<p>Mari bersama-sama menjaga kesehatan generasi penerus dan orang tua kita dengan rutin memeriksakan diri ke Posyandu terdekat.</p>',
                'status' => Content::STATUS_PUBLISHED,
                'view_count' => 64,
                'published_at' => Carbon::now()->subDays(7),
                'meta' => [
                    'cover_image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=80',
                    'seo_title' => 'Jadwal Posyandu Balita & Lansia Desa Sukamaju',
                    'seo_description' => 'Pelayanan imunisasi balita dan cek kesehatan lansia serentak di Desa Sukamaju.',
                ],
                'categories' => ['kesehatan-sosial', 'pengumuman'],
            ],
        ];

        foreach ($posts as $postData) {
            $catSlugs = $postData['categories'];
            unset($postData['categories']);

            $content = Content::updateOrCreate(
                ['slug' => $postData['slug'], 'type' => Content::TYPE_POST],
                array_merge($postData, [
                    'author_id' => $admin?->id,
                    'tenant_type' => 'village',
                    'tenant_id' => '1',
                ])
            );

            $catIds = collect($catSlugs)->map(fn ($slug) => $categories[$slug]->id ?? null)->filter();
            $content->categories()->sync($catIds);
        }
    }
}
