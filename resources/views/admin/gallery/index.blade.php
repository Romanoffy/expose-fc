@extends('layouts.dashboard')
@section('content')
<style>
    td { color: black !important; }

    /* Tabel dan struktur umum */
    .toggle-title { cursor:pointer; font-weight:600; color: var(--primary-dark); transition: all 0.3s ease; }
    .toggle-title:hover { color: var(--primary); text-decoration: underline; }
    .collapsible-content { max-height:0; overflow:hidden; opacity:0; transition: all 0.4s ease; }
    .collapsible-content.show { max-height:2000px; opacity:1; }
    .collapse-row { background: rgba(255,255,255,0.04); }

    /* Foto grid */
    .photo-column {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }

    .photo-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .photo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .photo-thumb {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
        border-radius: 12px 12px 0 0;
    }

    /* Tombol aksi di bawah foto */
    .photo-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 10px;
        background: #f9fafb;
        border-top: 1px solid #eee;
    }

    .photo-actions button {
        border: none;
        background: transparent;
        color: #374151;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .photo-actions button:hover {
        color: #2563eb;
        transform: scale(1.05);
    }

    .photo-actions .btn-danger:hover {
        color: #dc2626;
    }

    /* Popup status */
    .status-popup {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        background: #ffffff;
        border-radius: 10px;
        padding: 16px;
        width: 220px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        z-index: 10;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .status-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    .status-popup form {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .status-popup select {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 6px;
        font-size: 0.9rem;
    }

    .status-popup button {
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 6px;
        transition: background 0.3s ease;
    }

    .status-popup button:hover {
        background: #1e40af;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Manajemen Gallery</h4>
        <a href="{{ route('gallery.create') }}" class="btn btn-primary">Tambah Gallery</a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Thumbnail</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $gallery)
                        <tr>
                            <td>#{{ str_pad($loop->index + 1,3,'0',STR_PAD_LEFT) }}</td>
                            <td><div class="toggle-title" data-gallery="{{ $gallery->id }}">{{ $gallery->title }}</div></td>
                            <td>
                                @if($gallery->thumbnail)
                                <img src="{{ asset('storage/'.$gallery->thumbnail) }}" style="height:60px;width:120px;object-fit:cover;">
                                @else
                                <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($gallery->description,80,'...') }}</td>
                            <td><span class="badge {{ $gallery->status==='Aktif'?'bg-success':'bg-danger' }}">{{ $gallery->status }}</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('gallery.edit',$gallery->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('gallery.destroy',$gallery->id) }}" onsubmit="return confirm('Yakin hapus gallery?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <tr class="collapse-row">
                            <td colspan="6" class="p-0">
                                <div class="collapsible-content" id="galleryPhotos{{ $gallery->id }}">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-between mb-3 align-items-center">
                                            <h6>Foto Gallery: {{ $gallery->title }}</h6>
                                            <form action="{{ route('gallery-photo.store',$gallery->id) }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                                                @csrf
                                                <input type="file" name="photo" class="form-control form-control-sm" required>
                                                <button class="btn btn-success btn-sm">Upload</button>
                                            </form>
                                        </div>

                                        <div class="photo-column">
                                            @forelse($gallery->photos as $photo)
                                            <div class="photo-card">
                                                <img src="{{ asset('storage/'.$photo->photo) }}" class="photo-thumb">

                                                <div class="photo-actions">
                                                    <form method="POST" action="{{ route('gallery-photo.destroy',[$gallery->id,$photo->id]) }}" onsubmit="return confirm('Yakin hapus foto ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete" title="Hapus Foto">
                                                            <i class="fas fa-trash-alt"></i> Hapus
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn-edit toggle-popup" title="Edit Status">
                                                        <i class="fas fa-pen"></i> Edit Status
                                                    </button>

                                                    <div class="status-popup">
                                                        <form method="POST" action="{{ route('gallery-photo.update',[$gallery->id,$photo->id]) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <label class="small mb-1">Status:</label>
                                                            <select name="status" class="form-select form-select-sm" required>
                                                                @foreach(['Aktif','Nonaktif'] as $status)
                                                                    <option value="{{ $status }}" {{ $photo->status===$status?'selected':'' }}>
                                                                        {{ $status }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="mt-2">Simpan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <p class="text-muted">Belum ada foto untuk galeri ini.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada gallery</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.toggle-title').forEach(el=>{
    el.addEventListener('click', ()=>{
        const content = document.getElementById(`galleryPhotos${el.dataset.gallery}`);
        content.classList.toggle('show');
    });
});

// Popup edit status
document.querySelectorAll('.btn-edit').forEach(btn=>{
    btn.addEventListener('click', e=>{
        e.stopPropagation();
        const popup = btn.parentElement.querySelector('.status-popup');
        popup.classList.toggle('show');
    });
});

// Klik di luar popup untuk menutup
window.addEventListener('click', e=>{
    document.querySelectorAll('.status-popup').forEach(p=>{
        if (!p.contains(e.target) && !e.target.classList.contains('btn-edit')) {
            p.classList.remove('show');
        }
    });
});
</script>
@endsection
