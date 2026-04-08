@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Galeri Baru</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Isi data untuk menambahkan galeri baru</p>
            </div>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="background: var(--dark-card); border:1px solid var(--glass-border); border-radius:16px; backdrop-filter:blur(20px);">
            <div class="card-body p-4">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Judul</label>
                        <input type="text" name="title" class="form-control"
                            placeholder="Masukkan judul galeri" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Masukkan deskripsi galeri"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*" required
                            onchange="previewImage(event)">
                        <div class="mt-3">
                            <img id="preview" class="rounded" style="height:120px; display:none; border:1px solid var(--glass-border);">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Status</label>
                        <select name="status" class="form-select">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>
@endsection
