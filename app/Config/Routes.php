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
$routes->get('berita', 'Home::berita');
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
$routes->group('surat', static function ($routes) {
    // ---- Cetak & Preview: diakses oleh Admin DAN Penduduk (filter auth saja) ----
    // Keamanan konten dijaga di dalam controller (cetak hanya untuk status 'Disetujui')
    $routes->get('cetak/(:num)',   'SuratController::cetak/$1',   ['filter' => 'auth']);
    $routes->get('preview/(:num)', 'SuratController::preview/$1', ['filter' => 'auth']);

    // ---- Penduduk: Pengajuan Surat ----
    $routes->group('', ['filter' => 'permission:kelola_surat_penduduk'], static function ($routes) {
        // 1. Pilih jenis surat
        $routes->get('pilih', 'SuratController::pilih');
        // 2. Form dinamis berdasarkan ID jenis surat
        $routes->get('form/(:num)', 'SuratController::formPengajuan/$1');
        // 3. Submit pengajuan surat
        $routes->post('submit/(:num)', 'SuratController::submitPengajuan/$1');
        // 4. Riwayat surat milik penduduk yang login
        $routes->get('riwayat', 'SuratController::riwayat');
    });

    // ---- Admin/Kades: Kelola Surat ----
    $routes->group('', ['filter' => 'permission:kelola_surat_admin'], static function ($routes) {
        // 5. Daftar pengajuan menunggu persetujuan
        $routes->get('persetujuan', 'SuratController::persetujuan');
        // 6. Setujui pengajuan
        $routes->post('setujui/(:num)', 'SuratController::setujui/$1');
        // 7. Tolak pengajuan
        $routes->post('tolak/(:num)', 'SuratController::tolak/$1');
        // 8. Semua riwayat surat (admin)
        $routes->get('semua', 'SuratController::semua');

        // ---- Manajemen Jenis Surat ----
        // 9. Daftar jenis surat
        $routes->get('jenis', 'SuratController::jenis');
        // 10. Form tambah jenis surat
        $routes->get('jenis/create', 'SuratController::jenisCreate');
        // 11. Simpan jenis surat
        $routes->post('jenis/store', 'SuratController::jenisStore');
        // 12. Form edit jenis surat
        $routes->get('jenis/edit/(:num)', 'SuratController::jenisEdit/$1');
        // 13. Update jenis surat
        $routes->post('jenis/update/(:num)', 'SuratController::jenisUpdate/$1');
        // 14. Hapus jenis surat
        $routes->delete('jenis/delete/(:num)', 'SuratController::jenisDelete/$1');
    });
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
$routes->group('sejarah', ['filter' => 'permission:kelola_artikel'], static function ($routes) {
    $routes->get('/', 'SejarahKepemimpinanController::index');
    $routes->get('create', 'SejarahKepemimpinanController::create');
    $routes->post('/', 'SejarahKepemimpinanController::store');
    $routes->get('(:num)', 'SejarahKepemimpinanController::show/$1');
    $routes->get('(:num)/edit', 'SejarahKepemimpinanController::edit/$1');
    $routes->post('(:num)', 'SejarahKepemimpinanController::update/$1');
    $routes->post('(:num)/delete', 'SejarahKepemimpinanController::delete/$1');
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
    $routes->get('export-page', 'PendudukController::exportPage');
    $routes->get('export', 'PendudukController::export');
    $routes->get('verifikasi/(:num)', 'PendudukController::verifikasi/$1');
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

// Rute Profil Mandiri Penduduk
$routes->group('profil', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'ProfilPendudukController::index');
    $routes->post('link-akun', 'ProfilPendudukController::linkAkun');
    $routes->post('simpan', 'ProfilPendudukController::simpan');
});