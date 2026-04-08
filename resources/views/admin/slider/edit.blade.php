@extends('layouts.dashboard')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Edit Slider</h2>

    <div class="card shadow-sm p-4">
        <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Gambar Lama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Gambar Saat Ini</label><br>
                @if ($slider->gambar)
                    <img src="{{ asset('storage/' . $slider->gambar) }}" 
                         alt="Slider Image" 
                         class="img-fluid rounded shadow-sm mb-2" 
                         id="currentImage"
                         style="max-width: 300px;">
                @else
                    <p class="text-muted">Belum ada gambar</p>
                @endif
            </div>

            {{-- Preview Gambar Baru --}}
            <div class="mb-3" id="previewContainer" style="display: none;">
                <label class="form-label fw-semibold">Preview Gambar Baru</label><br>
                <img id="previewImage" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
            </div>

            {{-- Upload Gambar Baru --}}
            <div class="mb-3">
                <label for="gambar" class="form-label fw-semibold">Ganti Gambar (Opsional)</label>
                <input type="file" 
                       name="gambar" 
                       id="gambar" 
                       class="form-control @error('gambar') is-invalid @enderror" 
                       accept="image/*">
                @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" 
                        id="status" 
                        class="form-select @error('status') is-invalid @enderror" 
                        required>
                    <option value="Aktif" {{ $slider->status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $slider->status === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.slider.index') }}" class="btn btn-secondary px-4">Kembali</a>
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script untuk preview --}}
<script>
    const gambarInput = document.getElementById('gambar');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
            previewImage.src = '';
        }
    });
</script>
@endsection
