@extends('layouts.main')

@section('content')
    <!-- Hero Section -->
    <div
        class="hero overlay"
        style="background-image: url('{{ asset('assets/client/images/bg_5.jpg') }}'); min-height: 400px; display: flex; align-items: center;"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1
                        class="mb-4 text-white"
                        style="font-size: 3.5rem; font-weight: 800; letter-spacing: 1px;"
                    >My Profile
                    </h1>
                    <p
                        class="text-white"
                        style="font-size: 1.2rem; font-weight: 300; letter-spacing: 0.5px;"
                    >Manage your
                        personal information and account settings</p>
                </div>
            </div>
        </div>
    </div>

    <div
        class="profile-page"
        style="background: rgb(10, 14, 24);"
    >
        <div class="container py-5">
            <!-- Multiple Notifications Container -->
            <div
                id="notifications-container"
                style="position: fixed; top: 100px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px;"
            ></div>

            <!-- Success Notification -->
            @if (session('success'))
                <div
                    class="notification-toast"
                    data-type="success"
                    data-message="{{ session('success') }}"
                ></div>
            @endif

            <!-- Error Notification -->
            @if (session('error'))
                <div
                    class="notification-toast"
                    data-type="error"
                    data-message="{{ session('error') }}"
                ></div>
            @endif

            <!-- Info Notification -->
            @if (session('info'))
                <div
                    class="notification-toast"
                    data-type="info"
                    data-message="{{ session('info') }}"
                ></div>
            @endif

            <!-- Multiple Notifications -->
            @if (session('notifications'))
                @foreach (session('notifications') as $notification)
                    <div
                        class="notification-toast"
                        data-type="{{ $notification['type'] }}"
                        data-message="{{ $notification['message'] }}"
                    ></div>
                @endforeach
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="profile-card">
                        <!-- Profile Info Section -->
                        <div class="profile-info-section">
                            <div class="profile-avatar-wrapper">
                                <div class="profile-avatar">
                                    <img
                                        src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/client/images/default-profile.png') }}"
                                        alt="Profile"
                                        id="profile-preview"
                                    >
                                    <div class="avatar-overlay">
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"
                                            >
                                            </path>
                                            <circle
                                                cx="12"
                                                cy="13"
                                                r="4"
                                            ></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-details">
                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
                                    <div>
                                        <h3 class="profile-name mb-2 whitespace-normal break-words">
                                            {{ Auth::user()->name }}
                                        </h3>
                                        <p class="profile-email mb-0">{{ Auth::user()->email }}</p>
                                        <span
                                            class="profile-badge {{ Auth::user()->is_active ? 'badge-admin' : 'badge-user' }} mt-3"
                                        >
                                            <svg
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                            >
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle
                                                    cx="12"
                                                    cy="7"
                                                    r="4"
                                                ></circle>
                                            </svg>
                                            {{ Auth::user()->is_active ? 'Administrator' : 'User' }}
                                        </span>
                                    </div>
                                    <button
                                        type="button"
                                        class="btn-edit-profile mt-2"
                                        onclick="toggleEditForm()"
                                    >
                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                            </path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                            </path>
                                        </svg>
                                        <span class="edit-text">Edit Profile</span>
                                        <span
                                            class="cancel-text"
                                            style="display: none;"
                                        >Cancel</span>
                                    </button>
                                </div>

                            </div>
                        </div>

                        <hr class="profile-divider">
                        <hr class="profile-divider">

                        <!-- Profile Form Section -->
                        <div
                            class="profile-form-section"
                            id="edit-form-section"
                            style="display: none; max-height: 0; overflow: hidden; opacity: 0;"
                        >
                            <h4 class="section-title">Edit Profile</h4>

                            <form
                                action="{{ route('profile.update') }}"
                                method="POST"
                                enctype="multipart/form-data"
                                id="profile-form"
                            >
                                @csrf

                                <div class="form-group">
                                    <label class="form-label">
                                        <svg
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <rect
                                                x="3"
                                                y="3"
                                                width="18"
                                                height="18"
                                                rx="2"
                                                ry="2"
                                            >
                                            </rect>
                                            <circle
                                                cx="8.5"
                                                cy="8.5"
                                                r="1.5"
                                            ></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        Profile Photo
                                    </label>
                                    <div class="custom-file-upload">
                                        <input
                                            type="file"
                                            name="photo"
                                            id="photo-input"
                                            accept="image/*"
                                            onchange="previewImage(event)"
                                        >
                                        <div class="dropdown-wrapper">
                                            <label
                                                for="photo-input"
                                                id="choose-option"
                                                class="file-label"
                                                onclick="toggleDropdown(event)"
                                            >
                                                <svg
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line
                                                        x1="12"
                                                        y1="3"
                                                        x2="12"
                                                        y2="15"
                                                    >
                                                    </line>
                                                </svg>
                                                <span>Pilih / Ambil Foto</span>
                                            </label>

                                            <!-- Dropdown -->
                                            <div
                                                id="dropdown-options"
                                                class="dropdown-options"
                                            >
                                                <button
                                                    type="button"
                                                    onclick="chooseFile()"
                                                >📁 Pilih dari File</button>
                                                <button
                                                    type="button"
                                                    onclick="startCamera()"
                                                >📸 Ambil dari
                                                    Kamera</button>
                                            </div>
                                        </div>

                                        <span
                                            class="file-name"
                                            id="file-name"
                                        >No file chosen</span>
                                    </div>

                                    <!-- Kamera Section (Hidden) -->
                                    <div
                                        id="camera-container"
                                        style="display:none;flex-direction:column;align-items:center;gap:10px;margin-top:10px;"
                                    >
                                        <video
                                            id="camera"
                                            autoplay
                                            style="border-radius:10px;width:250px;height:200px;background:black;"
                                        ></video>
                                        <button
                                            type="button"
                                            id="take-photo"
                                            style="background:#000efe;color:white;border:none;padding:8px 16px;border-radius:8px;cursor:pointer;"
                                        >📸
                                            Ambil Foto</button>
                                    </div>

                                    <img
                                        id="preview"
                                        src="#"
                                        alt="Preview Foto"
                                        style="display:none;margin-top:10px;max-width:250px;border-radius:8px;border:2px solid #444;"
                                    >

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <svg
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2">
                                                    </path>
                                                    <circle
                                                        cx="12"
                                                        cy="7"
                                                        r="4"
                                                    ></circle>
                                                </svg>
                                                Full Name
                                            </label>
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control"
                                                required
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <svg
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                                    >
                                                    </path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg>
                                                Email Address
                                            </label>
                                            <input
                                                type="email"
                                                name="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control"
                                                required
                                            >
                                            <small
                                                class="email-notice"
                                                style="color: #fbbf24; margin-top: 0.5rem; display: block;"
                                            >
                                                <svg
                                                    width="14"
                                                    height="14"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    style="display: inline; margin-right: 0.25rem;"
                                                >
                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="10"
                                                    ></circle>
                                                    <line
                                                        x1="12"
                                                        y1="8"
                                                        x2="12"
                                                        y2="12"
                                                    >
                                                    </line>
                                                    <line
                                                        x1="12"
                                                        y1="16"
                                                        x2="12.01"
                                                        y2="16"
                                                    >
                                                    </line>
                                                </svg>
                                                Jika mengubah email, verifikasi akan dikirim ke email baru
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="password-section">
                                    <h5 class="subsection-title">Change Password</h5>
                                    <p class="subsection-description">Biarkan kosong jika Anda tidak ingin mengubah
                                        password
                                    </p>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <svg
                                                        width="16"
                                                        height="16"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <rect
                                                            x="3"
                                                            y="11"
                                                            width="18"
                                                            height="11"
                                                            rx="2"
                                                            ry="2"
                                                        ></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg>
                                                    Current Password
                                                </label>
                                                <input
                                                    type="password"
                                                    name="current_password"
                                                    class="form-control"
                                                    placeholder="Enter current password"
                                                    id="current-password-input"
                                                >
                                                <small
                                                    class="password-notice"
                                                    style="color: #fbbf24; margin-top: 0.5rem; display: block;"
                                                >
                                                    <svg
                                                        width="14"
                                                        height="14"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        style="display: inline; margin-right: 0.25rem;"
                                                    >
                                                        <circle
                                                            cx="12"
                                                            cy="12"
                                                            r="10"
                                                        ></circle>
                                                        <line
                                                            x1="12"
                                                            y1="8"
                                                            x2="12"
                                                            y2="12"
                                                        >
                                                        </line>
                                                        <line
                                                            x1="12"
                                                            y1="16"
                                                            x2="12.01"
                                                            y2="16"
                                                        >
                                                        </line>
                                                    </svg>
                                                    Wajib diisi jika ingin mengganti password
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <svg
                                                        width="16"
                                                        height="16"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <rect
                                                            x="3"
                                                            y="11"
                                                            width="18"
                                                            height="11"
                                                            rx="2"
                                                            ry="2"
                                                        ></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg>
                                                    New Password
                                                </label>
                                                <input
                                                    type="password"
                                                    name="password"
                                                    class="form-control"
                                                    placeholder="Enter new password"
                                                    id="password-input"
                                                    onchange="validatePasswordMatch()"
                                                >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <svg
                                                        width="16"
                                                        height="16"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                    >
                                                        <rect
                                                            x="3"
                                                            y="11"
                                                            width="18"
                                                            height="11"
                                                            rx="2"
                                                            ry="2"
                                                        ></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg>
                                                    Confirm Password
                                                </label>
                                                <input
                                                    type="password"
                                                    name="password_confirmation"
                                                    class="form-control"
                                                    placeholder="Confirm new password"
                                                    id="password-confirm-input"
                                                    onchange="validatePasswordMatch()"
                                                >
                                                <small
                                                    class="password-match-error"
                                                    style="color: #ef4444; margin-top: 0.5rem; display: none;"
                                                >
                                                    Password tidak cocok
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button
                                        type="submit"
                                        class="btn-update"
                                        id="submit-btn"
                                    >
                                        <svg
                                            width="18"
                                            height="18"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                            </path>
                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                            <polyline points="7 3 7 8 15 8"></polyline>
                                        </svg>
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-page {
            padding-top: 0;
            padding-bottom: 50px;
            min-height: 100vh;
            background: #1a1a1a;
            position: relative;
        }

        <style>.profile-page {
            padding-top: 0;
            padding-bottom: 50px;
            min-height: 100vh;
            background: #1a1a1a;
            position: relative;
        }

        .hero.overlay {
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .hero.overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero.overlay {
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .hero.overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .profile-card {
            background: #232931;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .profile-card {
            background: #232931;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .profile-info-section {
            padding: 3rem;
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            color: white;
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-info-section {
            padding: 3rem;
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            color: white;
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-info-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .profile-info-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .profile-avatar-wrapper {
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .profile-avatar-wrapper {
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-avatar:hover .avatar-overlay {
            opacity: 1;
        }

        .profile-avatar:hover .avatar-overlay {
            opacity: 1;
        }

        .profile-details {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .profile-details {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
        }

        .profile-email {
            font-size: 1rem;
            opacity: 0.9;
        }

        .profile-email {
            font-size: 1rem;
            opacity: 0.9;
        }

        .btn-edit-profile {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            backdrop-filter: blur(10px);
        }

        .btn-edit-profile {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            backdrop-filter: blur(10px);
        }

        .btn-edit-profile:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .btn-edit-profile:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .btn-edit-profile.active {
            background: rgba(255, 59, 48, 0.2);
            border-color: rgba(255, 59, 48, 0.5);
        }

        .btn-edit-profile.active {
            background: rgba(255, 59, 48, 0.2);
            border-color: rgba(255, 59, 48, 0.5);
        }

        .btn-edit-profile.active:hover {
            background: rgba(255, 59, 48, 0.3);
        }

        .btn-edit-profile.active:hover {
            background: rgba(255, 59, 48, 0.3);
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .profile-divider {
            margin: 0;
            border: none;
            height: 1px;
            background: rgba(255, 255, 255, 0.05);
        }

        .profile-divider {
            margin: 0;
            border: none;
            height: 1px;
            background: rgba(255, 255, 255, 0.05);
        }

        .profile-form-section {
            padding: 3rem;
            background: #232931;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-form-section {
            padding: 3rem;
            background: #232931;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-form-section.show {
            display: block !important;
            max-height: 2000px !important;
            opacity: 1 !important;
            animation: slideDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-form-section.show {
            display: block !important;
            max-height: 2000px !important;
            opacity: 1 !important;
            animation: slideDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideDown {
            from {
                max-height: 0;
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                max-height: 2000px;
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                max-height: 0;
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                max-height: 2000px;
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #b8b8b8;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #b8b8b8;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label svg {
            color: #000efe;
        }

        .form-label svg {
            color: #000efe;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
        }

        .form-control:focus {
            outline: none;
            border-color: #000efe;
            box-shadow: 0 0 0 3px rgba(0, 14, 254, 0.1);
            background: rgba(255, 255, 255, 0.08);
        }

        .form-control:focus {
            outline: none;
            border-color: #000efe;
            box-shadow: 0 0 0 3px rgba(0, 14, 254, 0.1);
            background: rgba(255, 255, 255, 0.08);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .custom-file-upload {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .custom-file-upload {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .file-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #000efe;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0;
        }

        .file-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: #000efe;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0;
        }

        .file-label:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 14, 254, 0.4);
        }

        .file-label:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 14, 254, 0.4);
        }

        .file-name {
            color: #b8b8b8;
            font-size: 0.9rem;
        }

        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }

        .dropdown-options {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 110%;
            left: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            z-index: 10;
            min-width: 180px;
        }

        .dropdown-options button {
            background: none;
            border: none;
            padding: 10px 15px;
            text-align: left;
            width: 100%;
            cursor: pointer;
            font-weight: 500;
        }

        .dropdown-options button:hover {
            background: #f3f3f3;
        }

        .dropdown-options.show {
            display: flex;
        }

        .password-section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px dashed rgba(255, 255, 255, 0.1);
        }

        .password-section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px dashed rgba(255, 255, 255, 0.1);
        }

        .subsection-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .subsection-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-family: 'Montserrat', sans-serif;
        }

        .subsection-description {
            color: #b8b8b8;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .subsection-description {
            color: #b8b8b8;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-actions {
            margin-top: 2.5rem;
            text-align: center;
        }

        .form-actions {
            margin-top: 2.5rem;
            text-align: center;
        }

        .btn-update {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2.5rem;
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 14, 254, 0.4);
            font-family: 'Montserrat', sans-serif;
        }

        .btn-update {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2.5rem;
            background: linear-gradient(135deg, #000efe 0%, #0056b3 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 14, 254, 0.4);
            font-family: 'Montserrat', sans-serif;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 14, 254, 0.5);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 14, 254, 0.5);
        }

        .btn-update:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Notification Styles */
        #notifications-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 400px;
        }

        .notification-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: #232931;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            min-width: 320px;
            transform: translateX(450px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .notification-item.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification-item.hiding {
            transform: translateX(450px);
            opacity: 0;
        }

        .notification-item.success {
            border-left: 4px solid #10b981;
        }

        .notification-item.error {
            border-left: 4px solid #ef4444;
        }

        .notification-item.info {
            border-left: 4px solid #3b82f6;
        }

        .notification-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .notification-item.success .notification-icon {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .notification-item.error .notification-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .notification-item.info .notification-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .notification-text {
            flex: 1;
        }

        .notification-text {
            flex: 1;
        }

        .notification-text strong {
            display: block;
            font-size: 1rem;
            color: #ffffff;
            margin-bottom: 0.25rem;
            font-family: 'Montserrat', sans-serif;
        }

        .notification-text strong {
            display: block;
            font-size: 1rem;
            color: #ffffff;
            margin-bottom: 0.25rem;
            font-family: 'Montserrat', sans-serif;
        }

        .notification-text p {
            margin: 0;
            font-size: 0.9rem;
            color: #b8b8b8;
        }

        .notification-text p {
            margin: 0;
            font-size: 0.9rem;
            color: #b8b8b8;
        }

        .notification-close {
            flex-shrink: 0;
            background: transparent;
            border: none;
            color: #b8b8b8;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s ease;
        }

        .notification-close {
            flex-shrink: 0;
            background: transparent;
            border: none;
            color: #b8b8b8;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s ease;
        }

        .notification-close:hover {
            color: #ffffff;
        }

        .notification-close:hover {
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem !important;
            }

            .hero p {
                font-size: 1rem !important;
            }

            .profile-info-section {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
            }

            .profile-details {
                width: 100%;
            }

            .profile-details .d-flex {
                flex-direction: column;
                align-items: center !important;
                text-align: center;
            }

            .btn-edit-profile {
                width: 100%;
                justify-content: center;
            }

            .profile-form-section {
                padding: 2rem;
            }

            #notifications-container {
                right: 10px;
                left: 10px;
                top: 80px;
            }

            .notification-item {
                min-width: auto;
            }

            .custom-file-upload {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <script>
        // Notification System
        document.addEventListener('DOMContentLoaded', function() {
            const notificationToasts = document.querySelectorAll('.notification-toast');

            if (notificationToasts.length > 0) {
                const container = document.getElementById('notifications-container');
                let delay = 0;

                notificationToasts.forEach((toast, index) => {
                    const type = toast.dataset.type;
                    const message = toast.dataset.message;

                    setTimeout(() => {
                        showNotification(type, message, container);
                    }, delay);

                    delay += 150; // Stagger animations
                });
            }
        });

        function showNotification(type, message, container) {
            const notificationItem = document.createElement('div');
            notificationItem.className = `notification-item ${type}`;

            let iconSVG = '';
            let title = '';

            if (type === 'success') {
                title = 'Success!';
                iconSVG = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>`;
            } else if (type === 'error') {
                title = 'Error!';
                iconSVG = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>`;
            } else if (type === 'info') {
                title = 'Info!';
                iconSVG = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>`;
            }

            notificationItem.innerHTML = `
                <div class="notification-icon">${iconSVG}</div>
                <div class="notification-text">
                    <strong>${title}</strong>
                    <p>${message}</p>
                </div>
                <button class="notification-close" onclick="closeNotification(this)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            `;

            container.appendChild(notificationItem);

            // Show notification
            setTimeout(() => {
                notificationItem.classList.add('show');
            }, 10);

            // Auto hide after 5 seconds
            setTimeout(() => {
                closeNotification(notificationItem.querySelector('.notification-close'));
            }, 5000);
        }

        function closeNotification(button) {
            const notification = button.parentElement;
            notification.classList.remove('show');
            notification.classList.add('hiding');

            setTimeout(() => {
                notification.remove();
            }, 400);
        }

        // Camera and file upload functions
        const fileInput = document.getElementById('photo-input');
        const dropdown = document.getElementById('dropdown-options');
        const preview = document.getElementById('preview');
        const fileName = document.getElementById('file-name');
        const cameraContainer = document.getElementById('camera-container');
        const camera = document.getElementById('camera');
        const takePhotoBtn = document.getElementById('take-photo');
        let cameraStream;

        function toggleDropdown(e) {
            e.preventDefault();
            dropdown.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            const wrapper = document.querySelector('.dropdown-wrapper');
            if (!wrapper.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        function chooseFile() {
            dropdown.classList.remove('show');
            fileInput.click();
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const profilePreview = document.getElementById('profile-preview');

            if (file) {
                fileName.textContent = file.name;
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    profilePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'No file chosen';
                preview.style.display = 'none';
            }
        }

        async function startCamera() {
            dropdown.classList.remove('show');
            cameraContainer.style.display = 'flex';
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                camera.srcObject = cameraStream;
            } catch (error) {
                alert('Tidak dapat mengakses kamera: ' + error.message);
                cameraContainer.style.display = 'none';
            }
        }

        takePhotoBtn.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = camera.videoWidth;
            canvas.height = camera.videoHeight;
            canvas.getContext('2d').drawImage(camera, 0, 0);
            canvas.toBlob(blob => {
                const file = new File([blob], 'photo.jpg', {
                    type: 'image/jpeg'
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                preview.src = URL.createObjectURL(blob);
                preview.style.display = 'block';
                document.getElementById('profile-preview').src = URL.createObjectURL(blob);
                fileName.textContent = 'photo.jpg';
                stopCamera();
            });
        });

        function stopCamera() {
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }
            cameraContainer.style.display = 'none';
        }

        function toggleEditForm() {
            const editSection = document.getElementById('edit-form-section');
            const button = document.querySelector('.btn-edit-profile');
            const editText = button.querySelector('.edit-text');
            const cancelText = button.querySelector('.cancel-text');

            if (editSection.classList.contains('show')) {
                editSection.classList.remove('show');
                button.classList.remove('active');
                editText.style.display = 'inline';
                cancelText.style.display = 'none';

                setTimeout(() => {
                    document.querySelector('.profile-card').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
            } else {
                editSection.classList.add('show');
                button.classList.add('active');
                editText.style.display = 'none';
                cancelText.style.display = 'inline';

                setTimeout(() => {
                    editSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }, 300);
            }
        }

        function validatePasswordMatch() {
            const passwordInput = document.getElementById('password-input');
            const confirmInput = document.getElementById('password-confirm-input');
            const errorMsg = document.querySelector('.password-match-error');

            if (!passwordInput.value && !confirmInput.value) {
                errorMsg.style.display = 'none';
                return;
            }

            if ((passwordInput.value && !confirmInput.value) || (!passwordInput.value && confirmInput.value)) {
                errorMsg.style.display = 'block';
                errorMsg.textContent = passwordInput.value ? 'Konfirmasi password harus diisi' :
                'Password baru harus diisi';
                return;
            }

            if (passwordInput.value && confirmInput.value) {
                if (passwordInput.value !== confirmInput.value) {
                    errorMsg.style.display = 'block';
                    errorMsg.textContent = 'Password tidak cocok';
                } else {
                    errorMsg.style.display = 'none';
                }
            }
        }

        document.getElementById('profile-form').addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('current-password-input');
            const passwordInput = document.getElementById('password-input');
            const confirmInput = document.getElementById('password-confirm-input');

            // Check if any password field is filled
            const isChangingPassword = currentPassword.value || passwordInput.value || confirmInput.value;

            if (isChangingPassword) {
                if (!currentPassword.value) {
                    e.preventDefault();
                    alert('Current password harus diisi untuk mengganti password!');
                    return false;
                }

                if (!passwordInput.value) {
                    e.preventDefault();
                    alert('Password baru harus diisi!');
                    return false;
                }

                if (!confirmInput.value) {
                    e.preventDefault();
                    alert('Konfirmasi password harus diisi!');
                    return false;
                }

                if (passwordInput.value !== confirmInput.value) {
                    e.preventDefault();
                    alert('Password baru dan Konfirmasi Password tidak cocok!');
                    return false;
                }
            }
        });
    </script>
@endsection
