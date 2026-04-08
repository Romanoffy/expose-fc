<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        return view('client.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Anda belum login.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|min:8',
            'password_confirmation' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Validasi password fields
        $isChangingPassword = $request->filled('current_password') ||
            $request->filled('password') ||
            $request->filled('password_confirmation');

        if ($isChangingPassword) {
            // kalau user bukan login Google (tidak punya google_id)
            if (is_null($user->google_id)) {
                // Validasi current password wajib diisi
                if (!$request->filled('current_password')) {
                    return redirect()->back()
                        ->with('error', 'Current password harus diisi untuk mengganti password!')
                        ->withInput();
                }

                // Cek apakah current password benar
                if (!Hash::check($request->current_password, $user->password)) {
                    return redirect()->back()
                        ->with('error', 'Current password yang Anda masukkan salah!')
                        ->withInput();
                }
            }

            // Validasi new password harus diisi
            if (!$request->filled('password')) {
                return redirect()->back()
                    ->with('error', 'Password baru harus diisi!')
                    ->withInput();
            }

            // Validasi password confirmation harus diisi
            if (!$request->filled('password_confirmation')) {
                return redirect()->back()
                    ->with('error', 'Konfirmasi password harus diisi!')
                    ->withInput();
            }

            // Validasi password dan confirmation harus cocok
            if ($request->password !== $request->password_confirmation) {
                return redirect()->back()
                    ->with('error', 'Password baru dan konfirmasi password tidak cocok!')
                    ->withInput();
            }
        }


        try {
            $notifications = [];

            // Update foto
            if ($request->hasFile('photo')) {
                if ($user->photo && Storage::exists('public/' . $user->photo)) {
                    Storage::delete('public/' . $user->photo);
                }
                $path = $request->file('photo')->store('profiles', 'public');
                $user->photo = $path;
                $notifications[] = ['type' => 'success', 'message' => 'Foto profil berhasil diperbarui!'];
            }

            // Update name
            $nameChanged = $user->name !== $request->name;
            $user->name = $request->name;

            if ($nameChanged) {
                $notifications[] = ['type' => 'success', 'message' => 'Nama berhasil diperbarui!'];
            }

            // Handle email change dengan verification
            $emailChanged = $user->email !== $request->email;
            if ($emailChanged) {
                $newEmail = $request->email;

                // Generate verification token
                $verificationToken = Str::random(64);

                // Simpan token ke session
                session([
                    'pending_email' => $newEmail,
                    'pending_email_token' => $verificationToken
                ]);

                // Kirim email verifikasi ke email baru
                Mail::send('emails.verify-email-change', [
                    'user' => $user,
                    'newEmail' => $newEmail,
                    'verificationToken' => $verificationToken,
                    'url' => route('verify.email.change', ['token' => $verificationToken]),
                ], function ($message) use ($newEmail) {
                    $message->to($newEmail);
                    $message->subject('Verifikasi Email Baru - Expose FC');
                });

                $notifications[] = [
                    'type' => 'info',
                    'message' => 'Email verifikasi telah dikirim ke ' . $newEmail . '. Silakan cek email untuk konfirmasi.'
                ];
            }

            // Update password jika diisi
            if ($isChangingPassword && $request->filled('password')) {
                $user->password = Hash::make($request->password);
                $notifications[] = ['type' => 'success', 'message' => 'Password berhasil diubah!'];

                // Kirim email notifikasi password changed
                try {
                    Mail::send('emails.password-changed', [
                        'user' => $user,
                        'changedAt' => now()->format('d M Y, H:i'),
                        'ipAddress' => $request->ip(),
                        'userAgent' => $request->userAgent(),
                    ], function ($message) use ($user) {
                        $message->to($user->email);
                        $message->subject('Password Anda Telah Diubah - Expose FC');
                    });

                    $notifications[] = ['type' => 'info', 'message' => 'Email konfirmasi perubahan password telah dikirim.'];
                } catch (\Exception $e) {
                    // Log error tapi jangan gagalkan proses update
                    \Log::error('Failed to send password change email: ' . $e->getMessage());
                }
            }

            $user->save();

            // Jika tidak ada notifikasi spesifik, berikan notifikasi umum
            if (empty($notifications)) {
                $notifications[] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui!'];
            }

            // Return dengan multiple notifications
            return redirect()->back()->with('notifications', $notifications);
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Verify email change
     */
    public function verifyEmailChange($token)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validasi token
        if (session('pending_email_token') !== $token) {
            return redirect()->route('profile')
                ->with('error', 'Token verifikasi tidak valid atau sudah expired.');
        }

        $newEmail = session('pending_email');

        // Update email
        $user->email = $newEmail;
        $user->email_verified_at = now();
        $user->save();

        // Hapus session
        session()->forget(['pending_email', 'pending_email_token']);

        // Regenerate session untuk security
        request()->session()->regenerate();

        return redirect()->route('profile')
            ->with('success', 'Email berhasil diubah! Email ' . $newEmail . ' sudah diverifikasi.');
    }
}
