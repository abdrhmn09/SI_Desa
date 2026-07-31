<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\UserModel;
use App\Models\KartuKeluargaModel;

class ProfilPendudukController extends BaseController
{
    protected PendudukModel     $pendudukModel;
    protected UserModel         $userModel;
    protected KartuKeluargaModel $kkModel;

    public function __construct()
    {
        $this->pendudukModel = new PendudukModel();
        $this->userModel     = new UserModel();
        $this->kkModel       = new KartuKeluargaModel();
    }

    // =====================================================================
    // index() — Tampilkan form profil data diri penduduk
    // =====================================================================
    public function index()
    {
        $userId   = session()->get('user_id');
        $user     = $this->userModel->find($userId);
        $penduduk = null;
        $kk       = null;

        // Jika akun sudah terhubung ke data penduduk
        if (!empty($user['penduduk_id'])) {
            $penduduk = $this->pendudukModel->find($user['penduduk_id']);
            if ($penduduk) {
                // Jika email_penduduk di tabel penduduk masih kosong, otomatis default ke email akun user
                if (empty($penduduk['email_penduduk']) && !empty($user['email'])) {
                    $penduduk['email_penduduk'] = $user['email'];
                }
                if ($penduduk['kartu_keluarga_id']) {
                    $kk = $this->kkModel->find($penduduk['kartu_keluarga_id']);
                }
            }
        }

        return view('profil/index', [
            'title'     => 'Profil Data Diri Saya',
            'user'      => $user,
            'penduduk'  => $penduduk,
            'kk'        => $kk,
            'nikError'  => session()->getFlashdata('nik_error'),
        ]);
    }

    // =====================================================================
    // linkAkun() — Menghubungkan akun user ke data penduduk via NIK
    // Digunakan saat akun belum terhubung (penduduk_id = null)
    // =====================================================================
    public function linkAkun()
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);
        $nik    = trim($this->request->getPost('nik'));

        if (empty($nik) || strlen($nik) !== 16 || !ctype_digit($nik)) {
            return redirect()->back()->with('nik_error', 'NIK harus 16 digit angka.');
        }

        $penduduk = $this->pendudukModel->findByNik($nik);

        if (!$penduduk) {
            return redirect()->back()->with('nik_error', 'NIK tidak ditemukan dalam database. Hubungi admin desa untuk mendaftarkan data Anda terlebih dahulu.');
        }

        // Cek apakah NIK ini sudah ditautkan ke akun lain
        $existingLink = $this->userModel
            ->where('penduduk_id', $penduduk['id'])
            ->where('id !=', $userId)
            ->first();

        if ($existingLink) {
            return redirect()->back()->with('nik_error', 'NIK ini sudah terhubung ke akun lain. Hubungi admin jika ini kesalahan.');
        }

        // Tautkan akun ke penduduk
        $this->userModel->update($userId, ['penduduk_id' => $penduduk['id']]);

        // Otomatis sinkronkan email dari user jika email_penduduk masih kosong
        if (empty($penduduk['email_penduduk']) && !empty($user['email'])) {
            $this->pendudukModel->update($penduduk['id'], ['email_penduduk' => $user['email']]);
        }

        return redirect()->to('/profil')->with('success', 'Akun berhasil ditautkan! Data email Anda disinkronkan dari akun login. Silakan lengkapi data diri Anda.');
    }

    // =====================================================================
    // simpan() — Simpan/update data profil penduduk
    // =====================================================================
    public function simpan()
    {
        $userId   = session()->get('user_id');
        $user     = $this->userModel->find($userId);

        if (empty($user['penduduk_id'])) {
            return redirect()->to('/profil')->with('error', 'Tautkan NIK Anda terlebih dahulu sebelum mengisi profil.');
        }

        $pendudukId = $user['penduduk_id'];

        $rules = [
            'tempat_lahir'    => 'permit_empty|max_length[100]',
            'tanggal_lahir'   => 'permit_empty|valid_date',
            'jenis_kelamin'   => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'agama'           => 'permit_empty|max_length[30]',
            'pendidikan'      => 'permit_empty|max_length[50]',
            'pekerjaan'       => 'permit_empty|max_length[100]',
            'status_kawin'    => 'permit_empty|in_list[Belum Kawin,Kawin,Cerai Hidup,Cerai Mati]',
            'golongan_darah'  => 'permit_empty|in_list[A,B,AB,O,Tidak Tahu]',
            'kewarganegaraan' => 'permit_empty|in_list[WNI,WNA]',
            'status_tinggal'  => 'permit_empty|in_list[Tetap,Kontrak,Kos,Domisili Sementara]',
            'nik_ayah'        => 'permit_empty|exact_length[16]|numeric',
            'nama_ayah'       => 'permit_empty|max_length[100]',
            'nik_ibu'         => 'permit_empty|exact_length[16]|numeric',
            'nama_ibu'        => 'permit_empty|max_length[100]',
            'no_hp'           => 'permit_empty|max_length[15]',
            'email_penduduk'  => "permit_empty|valid_email|max_length[100]|is_unique[users.email,id,{$userId}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $p        = $this->request->getPost();
        $newEmail = !empty($p['email_penduduk']) ? trim($p['email_penduduk']) : null;

        // 1. Update data kependudukan
        $this->pendudukModel->update($pendudukId, [
            'tempat_lahir'    => $p['tempat_lahir']    ?? null,
            'tanggal_lahir'   => $p['tanggal_lahir']   ?? null,
            'jenis_kelamin'   => $p['jenis_kelamin']   ?? null,
            'agama'           => $p['agama']           ?? null,
            'pendidikan'      => $p['pendidikan']      ?? null,
            'pekerjaan'       => $p['pekerjaan']       ?? null,
            'status_kawin'    => $p['status_kawin']    ?? null,
            'golongan_darah'  => $p['golongan_darah']  ?? null,
            'kewarganegaraan' => $p['kewarganegaraan'] ?? 'WNI',
            'status_tinggal'  => $p['status_tinggal']  ?? null,
            'nik_ayah'        => $p['nik_ayah']        ?: null,
            'nama_ayah'       => $p['nama_ayah']       ?? null,
            'nik_ibu'         => $p['nik_ibu']         ?: null,
            'nama_ibu'        => $p['nama_ibu']        ?? null,
            'no_hp'           => $p['no_hp']           ?? null,
            'email_penduduk'  => $newEmail,
            'is_dtks'         => isset($p['is_dtks']) ? 1 : 0,
        ]);

        // 2. SINKRONISASI EMAIL AKUN LOGIN (USERS) untuk pengiriman OTP dll.
        if (!empty($newEmail) && $newEmail !== $user['email']) {
            $this->userModel->update($userId, ['email' => $newEmail]);
        }

        return redirect()->to('/profil')->with('success', 'Data profil & email akun login (OTP) berhasil diperbarui dan disinkronkan.');
    }
}
