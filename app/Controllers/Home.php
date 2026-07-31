<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $identitasModel = new \App\Models\IdentitasDesaModel();
        $data['identitas'] = $identitasModel->getIdentitas();

        $strukturModel = new \App\Models\StrukturPemerintahanModel();
        $data['struktur'] = $strukturModel->findAll();

        $artikelModel = new \App\Models\ArtikelModel();
        $data['artikel'] = $artikelModel->getPublished(3); // Ambil 3 artikel terbaru

        $galeriModel = new \App\Models\GaleriModel();
        $data['galeri'] = $galeriModel->orderBy('created_at', 'DESC')->findAll(6); // Ambil 6 foto

        $videoModel = new \App\Models\VideoLinkModel();
        $data['videos'] = $videoModel->orderBy('created_at', 'DESC')->findAll(3); // Ambil 3 video
        foreach ($data['videos'] as &$v) {
            $v['embed_url'] = \App\Models\VideoLinkModel::toEmbedUrl($v['url_video']);
        }

        $sejarahModel = new \App\Models\SejarahKepemimpinanModel();
        $data['sejarah'] = $sejarahModel->orderBy('id', 'ASC')->findAll();

        $db = \Config\Database::connect();
        $data['statPenduduk'] = $db->table('penduduk')->countAllResults();
        $data['statKK']       = $db->table('kartu_keluarga')->countAllResults();
        $data['statArtikel']  = $db->table('artikel')->where('status', 'published')->countAllResults();

        return view('Landing_page', $data);
    }

    public function berita()
    {
        $identitasModel = new \App\Models\IdentitasDesaModel();
        $artikelModel   = new \App\Models\ArtikelModel();

        $kategori = $this->request->getGet('kategori');

        $query = $artikelModel->where('status', 'published')->orderBy('created_at', 'DESC');
        if ($kategori) {
            $query = $query->where('kategori', $kategori);
        }

        $artikel = $query->paginate(9);

        return view('berita_publik', [
            'identitas' => $identitasModel->getIdentitas(),
            'artikel'   => $artikel,
            'kategori'  => $kategori,
            'pager'     => $artikelModel->pager,
        ]);
    }

    /**
     * Baca detail satu artikel.
     *
     * BUG FIX: sebelumnya artikel/berita yang diklik dari landing page / halaman
     * berita kadang tidak muncul ke halaman detailnya. Penyebab paling umum:
     *   1) Kolom `slug` kosong/null untuk sebagian data (mis. data lama sebelum
     *      slug dibuat otomatis), sehingga link menjadi site_url('artikel/')
     *      TANPA segmen — itu match ke rute admin ArtikelController::index()
     *      (yang ada di balik filter login), bukan ke halaman baca publik.
     *   2) Rute publik 'artikel/(:segment)' tidak sengaja ikut terbungkus di
     *      dalam grup filter 'auth' milik admin di Routes.php.
     *
     * Fix di sisi controller ini: kalau pencarian berdasarkan slug tidak
     * ketemu TAPI segmen yang dikirim berupa angka murni, coba juga cari
     * berdasarkan ID. Ini jaga-jaga supaya artikel tetap bisa dibuka meskipun
     * slug-nya belum terisi. Untuk penyebab (2), cek Routes.php — pastikan
     * baris berikut TIDAK berada di dalam group yang memakai ['filter' => 'auth']:
     *
     *   $routes->get('artikel/(:segment)', 'Home::bacaArtikel/$1');
     *   $routes->get('berita', 'Home::berita');
     *
     * dan letakkan keduanya SEBELUM (di luar) grup admin:
     *
     *   $routes->group('artikel', ['filter' => 'auth'], static function ($routes) {
     *       $routes->get('/', 'ArtikelController::index');
     *       $routes->get('(:num)', 'ArtikelController::show/$1'); // pakai (:num), bukan (:segment)
     *       ...
     *   });
     */
    public function bacaArtikel($slug)
    {
        $artikelModel = new \App\Models\ArtikelModel();

        $artikel = $artikelModel->where('slug', $slug)->where('status', 'published')->first();

        if (!$artikel && ctype_digit((string) $slug)) {
            $artikel = $artikelModel->where('id', (int) $slug)->where('status', 'published')->first();
        }

        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan atau belum dipublikasi.');
        }

        $identitasModel = new \App\Models\IdentitasDesaModel();

        return view('artikel_publik', [
            'identitas' => $identitasModel->getIdentitas(),
            'artikel'   => $artikel,
        ]);
    }
}