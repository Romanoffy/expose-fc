<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        $driver = Socialite::driver('google');
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        return $driver
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    /**
     * Handle Google Callback
     */
    public function callback()
    {
        try {
            /** @var SocialiteUser $googleUser */
            $googleUser = Socialite::driver('google')->user();

            // Flag untuk tracking user baru
            $isNewUser = false;

            // Cek berdasarkan google_id terlebih dahulu
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                Auth::login($user);
                // Kirim notifikasi login
                $this->sendLoginNotification($user, false);
                return $this->redirectAfterLogin($user);
            }

            // Cek jika email sudah dipakai akun manual
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                if (empty($existingUser->google_id)) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken ?? null,
                    ]);
                }
                Auth::login($existingUser);
                // Kirim notifikasi login (akun existing yang baru link dengan Google)
                $this->sendLoginNotification($existingUser, false);
                return $this->redirectAfterLogin($existingUser);
            }

            // Buat user baru
            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => Str::lower($googleUser->getEmail()),
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
                'is_active' => false,
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken ?? null,
            ]);

            $isNewUser = true;
            Auth::login($newUser);

            // Kirim notifikasi login untuk user baru
            $this->sendLoginNotification($newUser, $isNewUser);

            return $this->redirectAfterLogin($newUser);
        } catch (\Exception $e) {
            return redirect('/login')
                ->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    /**
     * Send login notification email
     */
    private function sendLoginNotification($user, $isNewUser = false)
    {
        try {
            // Get request details
            $loginTime = now()->timezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB';
            $ipAddress = request()->ip();
            $userAgent = $this->parseUserAgent(request()->userAgent());

            Mail::send('emails.google-login-notification', [
                'user' => $user,
                'isNewUser' => $isNewUser,
                'loginTime' => $loginTime,
                'ipAddress' => $ipAddress,
                'userAgent' => $userAgent,
            ], function ($message) use ($user, $isNewUser) {
                $message->to($user->email);
                $subject = $isNewUser ? 'Selamat Datang di Expose FC!' : 'Notifikasi Login - Expose FC';
                $message->subject($subject);
            });
        } catch (\Exception $e) {
            // Log error tapi tidak menghentikan proses login
            \Log::error('Failed to send login notification: ' . $e->getMessage());
        }
    }

    /**
     * Parse user agent untuk mendapatkan info browser dan OS
     */
    private function parseUserAgent($userAgent)
    {
        if (empty($userAgent)) {
            return 'Unknown Device';
        }

        // Deteksi Browser
        $browser = 'Unknown Browser';
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Apple Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Microsoft Edge';
        }

        // Deteksi OS
        $os = 'Unknown OS';
        if (preg_match('/Windows/i', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $os = 'Mac OS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $os = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $os = 'iOS';
        }

        return $browser . ' on ' . $os;
    }

    /**
     * Redirect after successful login
     */
    private function redirectAfterLogin($user)
    {
        if ($user->is_active) {
            session(['privilege' => 'Administrator']);
            return redirect('/admin/blogs')
                ->with('success', 'Log In Berhasil. Selamat Datang Admin!');
        } else {
            session(['privilege' => 'Regular']);
            return redirect('/')
                ->with('info', 'Log In Berhasil dengan Google. Selamat datang ' . e($user->name) . '!');
        }
    }
}