<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan form login.
     */
    public function index()
    {
        // Kalau sudah login, langsung lempar ke dashboard
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari user berdasarkan username
        $user = $this->userModel->where('username', $username)->first();

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        if (! $user['is_active']) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Hubungi Administrator.');
        }

        if (! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        // Ambil nama role untuk ditampilkan di session (opsional, buat kemudahan tampilan)
        $roleModel = new \App\Models\RoleModel();
        $role      = $roleModel->find($user['role_id']);

        // Simpan data penting ke session
        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'role_id'    => $user['role_id'],
            'role_nama'  => $role ? $role['nama_role'] : 'Tanpa Role',
            'wilayah_id' => $user['wilayah_id'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Login berhasil, selamat datang ' . $user['username'] . '.');
    }

    /**
     * Halaman Dashboard
     */
    public function dashboard()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $roleNama = session()->get('role_nama');
        $username = session()->get('username'); // Untuk Penduduk, ini berisi NIK

        $identitasModel = new \App\Models\IdentitasDesaModel();
        $identitas = $identitasModel->getIdentitas();
        $namaDesa = !empty($identitas['nama_desa']) ? $identitas['nama_desa'] : 'Desa';

        $data = ['title' => 'Dashboard ' . $namaDesa];

        if ($roleNama === 'Penduduk') {
            // ==========================================
            // DATA KHUSUS PENDUDUK
            // ==========================================
            // 1. Ambil data penduduk berdasarkan NIK
            $penduduk = $db->table('penduduk')->where('nik', $username)->get()->getRowArray();
            $pendudukId = $penduduk ? $penduduk['id'] : 0;

            // 2. Statistik Surat Pribadi
            $data['totalSuratSaya'] = $db->table('log_surat')->where('penduduk_id', $pendudukId)->countAllResults();
            $data['suratBulanIniSaya'] = $db->table('log_surat')
                ->where('penduduk_id', $pendudukId)
                ->where("DATE_FORMAT(tanggal_cetak, '%Y-%m')", date('Y-m'))
                ->countAllResults();
            
            // 3. Riwayat surat milik pribadi (5 terbaru)
            $data['riwayatSuratSaya'] = $db->table('log_surat ls')
                ->select('ls.nomor_surat, ls.tanggal_cetak, js.nama_surat')
                ->join('jenis_surat js', 'js.id = ls.jenis_surat_id', 'left')
                ->where('ls.penduduk_id', $pendudukId)
                ->orderBy('ls.id', 'DESC')
                ->limit(5)
                ->get()->getResultArray();
                
            $data['penduduk'] = $penduduk;

        } else {
            // ==========================================
            // DATA ADMIN / PERANGKAT DESA (Statistik Desa)
            // ==========================================
            $data['totalPenduduk'] = $db->table('penduduk')->countAllResults();
            $data['totalKK']       = $db->table('kartu_keluarga')->countAllResults();
            $data['totalArtikel']  = $db->table('artikel')->where('status', 'published')->countAllResults();
            $data['laki']          = $db->table('penduduk')->where('jenis_kelamin', 'Laki-laki')->countAllResults();
            $data['perempuan']     = $db->table('penduduk')->where('jenis_kelamin', 'Perempuan')->countAllResults();

            $data['suratBulanIni'] = $db->table('log_surat')
                ->where("DATE_FORMAT(tanggal_cetak, '%Y-%m')", date('Y-m'))
                ->countAllResults();

            $data['logSurat'] = $db->table('log_surat ls')
                ->select('ls.nomor_surat, ls.tanggal_cetak, p.nama_lengkap, js.nama_surat')
                ->join('penduduk p', 'p.id = ls.penduduk_id', 'left')
                ->join('jenis_surat js', 'js.id = ls.jenis_surat_id', 'left')
                ->orderBy('ls.id', 'DESC')
                ->limit(5)
                ->get()->getResultArray();
        }

        return view('dashboard', $data);
    }

    /**
     * Logout: hancurkan session.
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }

    /**
     * Menampilkan form registrasi untuk penduduk.
     */
    public function register()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register');
    }

    /**
     * Proses registrasi penduduk berdasarkan NIK.
     */
    public function processRegister()
    {
        $rules = [
            'nik'              => 'required|exact_length[16]|numeric',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $nik = $this->request->getPost('nik');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 1. Cek apakah NIK terdaftar di data kependudukan (tabel penduduk)
        $pendudukModel = new \App\Models\PendudukModel();
        $penduduk = $pendudukModel->where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal! NIK Anda tidak terdaftar di data penduduk desa. Silakan hubungi perangkat desa.');
        }

        // 2. Cek apakah NIK sudah didaftarkan sebagai akun sebelumnya (di tabel users)
        $existingUser = $this->userModel->where('username', $nik)->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'NIK ini sudah didaftarkan sebelumnya. Silakan langsung login.');
        }

        // 3. Cari Role ID untuk 'Penduduk'. Jika belum ada, buat otomatis.
        $roleModel = new \App\Models\RoleModel();
        $rolePenduduk = $roleModel->where('nama_role', 'Penduduk')->first();
        if (!$rolePenduduk) {
            $roleModel->insert(['nama_role' => 'Penduduk']);
            $roleId = $roleModel->getInsertID();
        } else {
            $roleId = $rolePenduduk['id'];
        }

        // 4. Daftarkan akun
        // Catatan: password tidak di-hash di sini karena UserModel memiliki fungsi hashPasswordOnInsert otomatis
        $this->userModel->insert([
            'username'  => $nik,
            'email'     => $email,
            'password'  => $password,
            'role_id'   => $roleId,
            'is_active' => 1
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login menggunakan NIK dan Password yang baru dibuat.');
    }

    /**
     * Halaman 403 - Akses Ditolak.
     */
    public function forbidden()
    {
        return view('errors/403');
    }
}