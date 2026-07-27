<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class PermissionFilter implements FilterInterface
{
    /**
     * Dijalankan sebelum Controller diakses.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments  Parameter permission yang dikirim dari Routes.php
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Pastikan user sudah login
        $userId = session()->get('user_id');

        if (! $userId) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Pastikan filter dipanggil dengan parameter permission yang jelas
        if (empty($arguments)) {
            // Tidak ada permission yang di-set di route -> anggap misconfiguration, tolak demi keamanan
            return redirect()->to('/403')->with('error', 'Akses Ditolak: permission tidak terdefinisi.');
        }

        // Ambil nama permission dari argument pertama, contoh: filter('permission:kelola_surat')
        $requiredPermission = $arguments[0];

        // 3. Cek hak akses lewat UserModel::hasPermission()
        $userModel = new UserModel();

        if (! $userModel->hasPermission($userId, $requiredPermission)) {
            return redirect()->to('/403')->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Lolos -> lanjutkan request seperti biasa (tidak perlu return apapun)
    }

    /**
     * Dijalankan setelah Controller selesai diproses.
     * Tidak dibutuhkan untuk kasus ini, dibiarkan kosong.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah response, biarkan kosong
    }
}