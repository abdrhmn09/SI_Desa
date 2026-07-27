<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
//auth
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::processRegister');
$routes->get('logout', 'AuthController::logout');
$routes->get('403', 'AuthController::forbidden');

// Lupa Password & OTP
$routes->get('forgot-password', 'ForgotPasswordController::index');
$routes->post('forgot-password', 'ForgotPasswordController::sendOtp');
$routes->get('verify-otp', 'ForgotPasswordController::verifyOtpForm');
$routes->post('verify-otp', 'ForgotPasswordController::verifyOtp');
$routes->get('reset-password', 'ForgotPasswordController::resetPasswordForm');
$routes->post('reset-password', 'ForgotPasswordController::resetPassword');

$routes->get('/', 'Home::index');
$routes->get('baca-artikel/(:segment)', 'Home::bacaArtikel/$1');
$routes->get('dashboard', 'AuthController::dashboard', ['filter' => 'auth']);

$routes->group('pengguna', ['filter' => 'permission:manajemen_pengguna'], static function ($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:num)', 'UserController::edit/$1');
    $routes->post('update/(:num)', 'UserController::update/$1');
    $routes->get('toggle-active/(:num)', 'UserController::toggleActive/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
});

$routes->group('role', ['filter' => 'permission:manajemen_pengguna'], static function ($routes) {
    $routes->get('/', 'RoleController::index');
    $routes->get('edit/(:num)', 'RoleController::edit/$1');
    $routes->post('update-permissions/(:num)', 'RoleController::updatePermissions/$1');
});

// Rute Penduduk
$routes->group('pengaturan', ['filter' => 'permission:akses_pengaturan_aplikasi'], static function ($routes) {
    $routes->get('/', 'PengaturanController::index');
    $routes->post('update', 'PengaturanController::update');
});
$routes->group('import', ['filter' => 'permission:kelola_kependudukan'], static function ($routes) {
    $routes->get('/', 'ImportController::index');
    $routes->get('template-penduduk', 'ImportController::templatePenduduk');
    $routes->get('template-kk', 'ImportController::templateKK');
    $routes->post('penduduk', 'ImportController::importPenduduk');
    $routes->post('kk', 'ImportController::importKK');
});
$routes->group('pemerintahan', ['filter' => 'permission:akses_pengaturan_aplikasi'], static function ($routes) {
    $routes->get('/', 'StrukturPemerintahanController::index');
    $routes->get('create', 'StrukturPemerintahanController::create');
    $routes->post('store', 'StrukturPemerintahanController::store');
    $routes->get('edit/(:num)', 'StrukturPemerintahanController::edit/$1');
    $routes->post('update/(:num)', 'StrukturPemerintahanController::update/$1');
    $routes->delete('delete/(:num)', 'StrukturPemerintahanController::delete/$1');
});
$routes->group('surat', ['filter' => 'permission:kelola_surat'], static function ($routes) {
    // 1. Menu pilih jenis surat bagi pemohon/penduduk
    $routes->get('pilih', 'SuratController::pilih');
    
    // 2. Menampilkan form dinamis berdasarkan ID jenis surat
    $routes->get('form/(:num)', 'SuratController::form/$1');
    
    // 3. Memproses pengajuan surat dari form dinamis
    $routes->post('submit/(:num)', 'SuratController::submit/$1');

    // 4. Daftar pengajuan surat yang menunggu persetujuan (Approval Kades)
    $routes->get('persetujuan', 'SuratController::persetujuan');

    // 5. Aksi Kades untuk menyetujui dan men-generate nomor surat secara otomatis
    $routes->post('setujui/(:num)', 'SuratController::setujui/$1');

    // 6. Cetak dokumen surat akhir (diubah menjadi GET/POST aman sesuai kebutuhan cetak)
    $routes->post('cetak', 'SuratController::cetak');
});
$routes->group('artikel', ['filter' => 'permission:kelola_artikel'], static function ($routes) {
    $routes->get('/', 'ArtikelController::index');
    $routes->get('create', 'ArtikelController::create');
    $routes->post('store', 'ArtikelController::store');
    $routes->get('show/(:num)', 'ArtikelController::show/$1');
    $routes->get('edit/(:num)', 'ArtikelController::edit/$1');
    $routes->post('update/(:num)', 'ArtikelController::update/$1');
    $routes->delete('delete/(:num)', 'ArtikelController::delete/$1');
});
$routes->group('galeri', ['filter' => 'permission:kelola_artikel'], static function ($routes) {
    $routes->get('/', 'GaleriController::index');
    $routes->get('create', 'GaleriController::create');
    $routes->post('store', 'GaleriController::store');
    $routes->get('edit/(:num)', 'GaleriController::edit/$1');
    $routes->post('update/(:num)', 'GaleriController::update/$1');
    $routes->delete('delete/(:num)', 'GaleriController::delete/$1');
});
$routes->group('video', ['filter' => 'permission:kelola_artikel'], static function ($routes) {
    $routes->get('/', 'VideoLinkController::index');
    $routes->get('create', 'VideoLinkController::create');
    $routes->post('store', 'VideoLinkController::store');
    $routes->get('edit/(:num)', 'VideoLinkController::edit/$1');
    $routes->post('update/(:num)', 'VideoLinkController::update/$1');
    $routes->delete('delete/(:num)', 'VideoLinkController::delete/$1');
});
$routes->group('penduduk', ['filter' => 'permission:kelola_kependudukan'], static function ($routes) {
    $routes->get('/', 'PendudukController::index');
    $routes->get('create', 'PendudukController::create');
    $routes->post('store', 'PendudukController::store');
    $routes->get('show/(:num)', 'PendudukController::show/$1');
    $routes->get('edit/(:num)', 'PendudukController::edit/$1');
    $routes->post('update/(:num)', 'PendudukController::update/$1');
    $routes->delete('delete/(:num)', 'PendudukController::delete/$1');
});
$routes->group('kartu-keluarga', ['filter' => 'permission:kelola_kependudukan'], static function ($routes) {
    $routes->get('/', 'KartuKeluargaController::index');
    $routes->get('create', 'KartuKeluargaController::create');
    $routes->post('store', 'KartuKeluargaController::store');
    $routes->get('edit/(:num)', 'KartuKeluargaController::edit/$1');
    $routes->post('update/(:num)', 'KartuKeluargaController::update/$1');
    $routes->delete('delete/(:num)', 'KartuKeluargaController::delete/$1');
});