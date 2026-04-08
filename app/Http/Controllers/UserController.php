<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        return view('admin.users.index', [
            'user_array' => $query->orderBy('created_at', 'desc')->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        return view('client.login');
    }

    /**
     * Halaman Registrasi
     */
    public function registrasi()
    {
        return view('client.registrasi');
    }

    /**
     * Verify Email - Show Password Form
     */
    public function verifyEmail($id)
    {
        $user = User::find($id);

        if (!$user) {
            return view('client.verify-failed');
        }

        // Jika email sudah terverifikasi sebelumnya
        if ($user->email_verified_at) {
            return view('client.verify-done');
        }

        // Tampilkan form input password
        return view('client.verify-password', [
            'userId' => $user->id,
            'email' => $user->email
        ]);
    }

    /**
     * Verify Password Confirmation
     */
    public function verifyPasswordConfirm(Request $request, $id)
    {
        try {
            $request->validate([
                'password' => ['required']
            ]);

            $user = User::find($id);

            if (!$user) {
                return redirect('/login')
                    ->with('error', 'User tidak ditemukan.');
            }

            // Jika sudah terverifikasi sebelumnya
            if ($user->email_verified_at) {
                return redirect('/verify-email-done');
            }

            // Cek password
            if (!Hash::check($request->password, $user->password)) {
                return redirect()->route('verify.email', $user->id)
                    ->with('error', 'Password yang Anda masukkan salah. Silakan coba lagi.');
            }

            // Password benar, verifikasi email
            $user->email_verified_at = now();
            $user->save();

            return redirect('/login')
                ->with('info', 'Verifikasi berhasil! Email Anda telah aktif. Silakan login dengan akun Anda.');
        } catch (\Throwable $th) {
            return redirect()->route('verify.email', $id)
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Verify Done Page
     */
    public function verifyDone()
    {
        return view('client.verify-done');
    }

    /**
     * User Registration
     */
    public function storeRegular(Request $request)
    {
        try {
            $formFields = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8']
            ]);

            $formFields['email'] = Str::lower($formFields['email']);
            $formFields['password'] = Hash::make($formFields['password']);
            $formFields['is_active'] = false;

            $user = User::create($formFields);

            // Kirim email verifikasi
            Mail::send('emails.verify', [
                'user' => $user,
                'url' => route('verify.email', $user->id),
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verifikasi Email - Expose FC');
            });

            return redirect('/login')->with('info', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
        } catch (\Throwable $th) {
            dd($th->getMessage());

            return redirect('/registrasi')
                ->with('error', 'Registrasi gagal! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * User Registration Admin
     */
    public function registrasiAdmin()
    {
        return view('client.registrasi-admin');
    }

    /**
     * Store Admin Registration
     */
    public function storeAdmin(Request $request)
    {
        try {
            $formFields = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8']
            ]);

            $formFields['email'] = Str::lower($formFields['email']);
            $formFields['password'] = Hash::make($formFields['password']);
            $formFields['is_active'] = true;

            $user = User::create($formFields);

            // Kirim email verifikasi untuk admin
            Mail::send('emails.verify', [
                'user' => $user,
                'url' => route('verify.email', $user->id),
            ], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Verifikasi Email - Expose FC');
            });

            return redirect('/login')->with('info', 'Registrasi admin berhasil! Silakan cek email untuk verifikasi.');
        } catch (\Throwable $th) {
            return redirect('/registrasi-admin')
                ->with('error', 'Registrasi gagal! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * User Authentication
     */
    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required']
            ]);

            $user = User::where('email', Str::lower($request->email))->first();

            if (!$user) {
                return redirect('login')
                    ->with('error', 'Log In Gagal. Email atau Password salah!')
                    ->withInput();
            }

            // Cek password
            if (!Hash::check($request->password, $user->password)) {
                return redirect('/login')
                    ->with('error', 'Log In Gagal. Email atau Password salah!')
                    ->withInput();
            }

            // Cek apakah email sudah diverifikasi
            if (is_null($user->email_verified_at)) {
                return redirect('/login')
                    ->with('error', 'Email anda belum diverifikasi. Silakan cek email anda untuk verifikasi terlebih dahulu.')
                    ->withInput();
            }

            // Login tetap diizinkan setelah verifikasi
            auth()->login($user);
            $request->session()->regenerate();

            // Simpan role di session
            if ($user->is_active) {
                session(['privilege' => 'Administrator']);
                return redirect('/admin/blogs')
                    ->with('success', 'Log In Berhasil. Selamat Datang Admin!');
            } else {
                session(['privilege' => 'Regular']);
                return redirect('/')
                    ->with('info', 'Log In Berhasil. Anda masuk sebagai pengguna biasa.');
            }
        } catch (\Throwable $th) {
            return redirect('login')
                ->with('error', 'Log In Gagal. Silahkan coba kembali!')
                ->withInput();
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            // Log out the user
            auth()->logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            return redirect('/login')->with('info', 'Log Out Berhasil. Terima kasih!!');
        } catch (\Throwable $th) {
            return redirect('/')
                ->with('error', 'Log Out Gagal. Silahkan coba kembali!!')
                ->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $formFields = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8'],
                'is_active' => ['required', 'boolean'],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ]);

            $formFields['email'] = Str::lower($formFields['email']);
            $formFields['password'] = Hash::make($formFields['password']);

            if ($request->hasFile('photo')) {
                try {
                    $formFields['photo'] = $request->file('photo')->store('users', 'public');
                } catch (\Exception $e) {
                    return back()->with('error', 'Upload foto gagal: ' . $e->getMessage())->withInput();
                }
            }

            User::create($formFields);

            return redirect('/admin/users')
                ->with('success', 'User berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect('/admin/users/create')
                ->with('error', 'User gagal ditambahkan! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user_array = User::findOrFail($id);
        return view('admin.users.edit', compact('user_array'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email,' . $id],
                'is_active' => ['required', 'boolean']
            ];

            // Only validate password if it's provided
            if ($request->filled('password')) {
                $rules['password'] = ['min:8'];
            }

            $formFields = $request->validate($rules);

            $user->name = $formFields['name'];
            $user->email = Str::lower($formFields['email']);
            $user->is_active = $formFields['is_active'];

            if ($request->hasFile('photo')) {
                $user->photo = $request->file('photo')->store('users', 'public');
            }

            // Only update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($formFields['password']);
            }

            $user->save();

            return redirect('/admin/users')
                ->with('success', 'User berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect('/admin/users/' . $id . '/edit')
                ->with('error', 'User gagal diupdate! ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting currently logged in user
            if (Auth::id() == $id) {
                return redirect('/admin/users')
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
            }

            $user->delete();

            return redirect('/admin/users')
                ->with('success', 'User berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect('/admin/users')
                ->with('error', 'User gagal dihapus! ' . $th->getMessage());
        }
    }
}