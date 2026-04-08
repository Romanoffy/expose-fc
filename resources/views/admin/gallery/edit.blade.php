@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Edit Galeri</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Ubah data galeri yang sudah ada</p>
            </div>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card"
            style="background: var(--dark-card); border:1px solid var(--glass-border); border-radius:16px; backdrop-filter:blur(20px);">
            <div class="card-body p-4">
                <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Judul</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $gallery->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $gallery->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*"
                            onchange="previewImage(event)">
                        <div class="mt-3">
                            @if ($gallery->thumbnail)
                                <img src="{{ asset('storage/' . $gallery->thumbnail) }}" id="preview"
                                    class="rounded mb-2" style="height:120px; border:1px solid var(--glass-border);">
                            @else
                                <img id="preview" class="rounded" style="height:120px; display:none; border:1px solid var(--glass-border);">
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" style="color: var(--text-primary); font-weight:600;">Status</label>
                        <select name="status" class="form-select">
                            <option value="Aktif" {{ $gallery->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ $gallery->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Perbarui
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
