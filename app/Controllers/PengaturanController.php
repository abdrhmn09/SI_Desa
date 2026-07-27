<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IdentitasDesaModel;

class PengaturanController extends BaseController
{
    protected IdentitasDesaModel $identitasDesaModel;

    public function __construct()
    {
        $this->identitasDesaModel = new IdentitasDesaModel();
    }

    /**
     * Menampilkan form pengaturan identitas desa.
     * Selalu ambil baris pertama (singleton row).
     */
    public function index()
    {
        $data['identitas']  = $this->identitasDesaModel->first();
        $data['validation'] = \Config\Services::validation();
        $data['title']      = 'Pengaturan Aplikasi';

        return view('pengaturan/index', $data);
    }

    /**
     * Menyimpan perubahan identitas desa.
     * Jika belum ada baris, insert; jika sudah ada, update.
     */
    public function update()
    {
        $rules = [
            'nama_desa'        => 'required|max_length[100]',
            'kode_desa'        => 'permit_empty|max_length[20]',
            'nama_kepala_desa' => 'permit_empty|max_length[100]',
            'nip_kepala_desa'  => 'permit_empty|max_length[30]',
            'alamat_kantor'    => 'permit_empty',
            'provinsi'         => 'permit_empty|max_length[100]',
            'kabupaten'        => 'permit_empty|max_length[100]',
            'kecamatan'        => 'permit_empty|max_length[100]',
            'kodepos'          => 'permit_empty|max_length[10]',
            'logo'             => 'permit_empty|max_length[255]',
            'sejarah'          => 'permit_empty',
            'visi_misi'        => 'permit_empty',
            'geografis'        => 'permit_empty',
            'demografi'        => 'permit_empty',
            'email'            => 'permit_empty|valid_email|max_length[100]',
            'telepon'          => 'permit_empty|max_length[50]',
            'facebook'         => 'permit_empty|max_length[150]',
            'instagram'        => 'permit_empty|max_length[150]',
            'youtube'          => 'permit_empty|max_length[150]',
            'twitter'          => 'permit_empty|max_length[150]',
            'embed_peta'       => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $payload = [
            'nama_desa'        => $this->request->getPost('nama_desa'),
            'kode_desa'        => $this->request->getPost('kode_desa'),
            'nama_kepala_desa' => $this->request->getPost('nama_kepala_desa'),
            'nip_kepala_desa'  => $this->request->getPost('nip_kepala_desa'),
            'alamat_kantor'    => $this->request->getPost('alamat_kantor'),
            'provinsi'         => $this->request->getPost('provinsi'),
            'kabupaten'        => $this->request->getPost('kabupaten'),
            'kecamatan'        => $this->request->getPost('kecamatan'),
            'kodepos'          => $this->request->getPost('kodepos'),
            'logo'             => $this->request->getPost('logo'),
            'sejarah'          => $this->request->getPost('sejarah'),
            'visi_misi'        => $this->request->getPost('visi_misi'),
            'geografis'        => $this->request->getPost('geografis'),
            'demografi'        => $this->request->getPost('demografi'),
            'email'            => $this->request->getPost('email'),
            'telepon'          => $this->request->getPost('telepon'),
            'facebook'         => $this->request->getPost('facebook'),
            'instagram'        => $this->request->getPost('instagram'),
            'youtube'          => $this->request->getPost('youtube'),
            'twitter'          => $this->request->getPost('twitter'),
            'embed_peta'       => $this->request->getPost('embed_peta'),
        ];

        $identitas = $this->identitasDesaModel->first();

        if ($identitas) {
            // Update baris yang sudah ada
            $this->identitasDesaModel->update($identitas['id'], $payload);
        } else {
            // Belum ada baris sama sekali, insert baru
            $this->identitasDesaModel->save($payload);
        }

        return redirect()->to('/pengaturan')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
