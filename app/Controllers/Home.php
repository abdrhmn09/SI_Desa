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
        
        $db = \Config\Database::connect();
        $data['statPenduduk'] = $db->table('penduduk')->countAllResults();
        $data['statKK']       = $db->table('kartu_keluarga')->countAllResults();
        $data['statArtikel']  = $db->table('artikel')->where('status', 'published')->countAllResults();

        return view('Landing_page', $data);
    }

    public function bacaArtikel($slug)
    {
        $artikelModel = new \App\Models\ArtikelModel();
        $artikel = $artikelModel->where('slug', $slug)->where('status', 'published')->first();

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
