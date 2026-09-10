<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

/**
 * ForgotPasswordController
 *
 * Mengelola alur reset password via OTP yang dikirim ke email:
 *   1. GET  /forgot-password     → form input email
 *   2. POST /forgot-password     → kirim OTP ke email
 *   3. GET  /verify-otp          → form input kode OTP
 *   4. POST /verify-otp          → validasi kode OTP
 *   5. GET  /reset-password      → form password baru
 *   6. POST /reset-password      → simpan password baru
 *
 * Session yang digunakan:
 *   otp_user_id   → ID user yang sedang dalam proses reset
 *   otp_verified  → flag boolean setelah OTP berhasil diverifikasi
 */
class ForgotPasswordController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ------------------------------------------------------------------
    // STEP 1 — Tampilkan form input email
    // ------------------------------------------------------------------

    public function index()
    {
        // Jika sudah login, tidak perlu reset password
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/forgot_password');
    }

    // ------------------------------------------------------------------
    // STEP 2 — Proses kirim OTP ke email
    // ------------------------------------------------------------------

    public function sendOtp()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Masukkan alamat email yang valid.');
        }

        $email = $this->request->getPost('email');
        $user  = $this->userModel->findByEmail($email);

        // Selalu tampilkan pesan sukses meski email tidak ditemukan
        // (mencegah enumerasi akun / user enumeration attack)
        if (! $user) {
            return redirect()->to('/forgot-password')
                ->with('success', 'Jika email terdaftar, kode OTP telah dikirim. Silakan cek inbox Anda.');
        }

        // Buat kode OTP 6 digit acak
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke database (berlaku 15 menit)
        $this->userModel->setOtp($user['id'], $otp);

        // Kirim email berisi OTP
        $emailSent = $this->kirimEmailOtp($user['email'], $otp);

        if (! $emailSent) {
            log_message('error', '[ForgotPassword] Gagal mengirim email OTP ke: ' . $user['email']);
            return redirect()->to('/forgot-password')
                ->with('error', 'Gagal mengirim email. Pastikan konfigurasi SMTP sudah benar.');
        }

        // Simpan user_id ke session untuk tahap berikutnya
        session()->set('otp_user_id', $user['id']);

        return redirect()->to('/verify-otp')
            ->with('success', 'Kode OTP telah dikirim ke ' . $email . '. Berlaku selama 15 menit.');
    }

    // ------------------------------------------------------------------
    // STEP 3 — Tampilkan form verifikasi OTP
    // ------------------------------------------------------------------

    public function verifyOtpForm()
    {
        if (! session()->get('otp_user_id')) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses dari awal.');
        }

        return view('auth/verify_otp');
    }

    // ------------------------------------------------------------------
    // STEP 4 — Proses validasi kode OTP yang dimasukkan user
    // ------------------------------------------------------------------

    public function verifyOtp()
    {
        $userId = session()->get('otp_user_id');

        if (! $userId) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses dari awal.');
        }

        $rules = ['otp' => 'required|exact_length[6]|numeric'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Kode OTP harus 6 digit angka.');
        }

        $inputOtp = $this->request->getPost('otp');
        $user     = $this->userModel->find($userId);

        if (! $user || $user['otp_code'] === null) {
            return redirect()->to('/forgot-password')
                ->with('error', 'OTP tidak valid atau sudah kedaluwarsa.');
        }

        // Cek kedaluwarsa
        if (strtotime($user['otp_expires_at']) < time()) {
            $this->userModel->clearOtp($userId);
            session()->remove('otp_user_id');
            return redirect()->to('/forgot-password')
                ->with('error', 'Kode OTP sudah kedaluwarsa. Silakan minta kode baru.');
        }

        // Cek kecocokan kode
        if ($user['otp_code'] !== $inputOtp) {
            return redirect()->back()
                ->with('error', 'Kode OTP salah. Silakan coba lagi.');
        }

        // OTP valid → tandai sesi sebagai terverifikasi
        session()->set('otp_verified', true);

        return redirect()->to('/reset-password');
    }

    // ------------------------------------------------------------------
    // STEP 5 — Tampilkan form password baru
    // ------------------------------------------------------------------

    public function resetPasswordForm()
    {
        if (! session()->get('otp_user_id') || ! session()->get('otp_verified')) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses dari awal.');
        }

        return view('auth/reset_password');
    }

    // ------------------------------------------------------------------
    // STEP 6 — Proses simpan password baru
    // ------------------------------------------------------------------

    public function resetPassword()
    {
        $userId = session()->get('otp_user_id');

        if (! $userId || ! session()->get('otp_verified')) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses dari awal.');
        }

        $rules = [
            'password'     => 'required|min_length[8]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Password minimal 8 karakter dan konfirmasi harus sama.');
        }

        // Simpan password baru (akan di-hash otomatis oleh callback UserModel)
        $this->userModel->update($userId, [
            'password' => $this->request->getPost('password'),
        ]);

        // Bersihkan OTP & session reset password
        $this->userModel->clearOtp($userId);
        session()->remove('otp_user_id');
        session()->remove('otp_verified');

        return redirect()->to('/login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }

    // ------------------------------------------------------------------
    // Private Helper — Kirim email OTP via SMTP
    // ------------------------------------------------------------------

    private function kirimEmailOtp(string $toEmail, string $otp): bool
    {
        try {
            $identitasModel = new \App\Models\IdentitasDesaModel();
            $identitas = $identitasModel->getIdentitas();
            $namaDesa = !empty($identitas['nama_desa']) ? $identitas['nama_desa'] : 'Desa';

            $emailService = \Config\Services::email();
            $emailService->setFrom(
                env('email.fromEmail', 'no-reply@' . url_title($namaDesa, '-', true) . '.local'),
                env('email.fromName', $namaDesa)
            );
            $emailService->setTo($toEmail);
            $emailService->setSubject('Kode OTP Reset Password — ' . $namaDesa);
            $emailService->setMessage(
                "Halo,\n\n" .
                "Kode OTP untuk reset password akun " . $namaDesa . " Anda adalah:\n\n" .
                "  {$otp}\n\n" .
                "Kode ini berlaku selama 15 menit.\n" .
                "Jika Anda tidak meminta reset password, abaikan email ini.\n\n" .
                "— Tim " . $namaDesa
            );

            return $emailService->send(false);
        } catch (\Throwable $e) {
            log_message('error', '[ForgotPassword::kirimEmailOtp] ' . $e->getMessage());
            return false;
        }
    }
}
