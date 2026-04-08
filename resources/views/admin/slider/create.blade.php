@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Tambah Slider</h4>
            <p class="mb-0" style="color: var(--text-secondary);">Unggah slider baru untuk halaman utama</p>
        </div>
        <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card" style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Upload Gambar -->
                <div class="mb-4">
                    <label class="form-label" style="color: var(--text-primary); font-weight: 500;">gambar</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="gambar/*" required>
                    @error('gambar')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Preview -->
                <div class="mb-4">
                    <img id="preview" src="#" alt="Preview" style="display:none; height: 150px; border-radius: 8px; border:1px solid var(--glass-border); object-fit: cover;">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label class="form-label" style="color: var(--text-primary); font-weight: 500;">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preview gambar sebelum upload
    document.querySelector('input[name="gambar"]').addEventListener('change', function(e) {
        const [file] = e.target.files;
        if (file) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>
@endsection
