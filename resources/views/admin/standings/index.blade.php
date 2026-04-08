@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1" style="color: var(--text-primary); font-weight: 600;">Manajemen Standings</h4>
                <p class="mb-0" style="color: var(--text-secondary);">Kelola data Standings Expose FC</p>
            </div>
            <div class="d-flex gap-2">

                <a href='/admin/standings/download_template' class="btn btn-primary btn-sm">
                    <i class="fas fa-download me-1"></i>Download Template
                </a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-upload me-1"></i>Update
                </button>
            </div>
        </div>
        <div class="row g-4">
            <div class="card h-100 p-4"
                style="background: var(--dark-card); border: 1px solid var(--glass-border); border-radius: 16px; backdrop-filter: blur(20px);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-1 text-white"
                            style="color: var(--text-primary); font-weight: 600;">Standings Table</h5>
                    <div class="d-flex gap-2">
                        <form action="/admin/standings" method="POST" enctype="multipart/form-data"
                            class="d-flex gap-2 mb-0">
                            @csrf
                            <input type="file" name="file" class="custom-file form-control form-control-sm"
                                id="exampleInputEmail1"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                aria-describedby="emailHelp" style="max-width: 200px;">
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="color: var(--text-secondary);">
                        <thead style="background: var(--glass-bg); border-color: var(--glass-border);">
                            <tr>
                                <th class="border-0 px-4 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">
                                    <span>#</span>
                                </th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Team Name</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Play</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Win</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Draw</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Lose</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Goal For</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Goal Against</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Goal Diff</th>
                                <th class="border-0 py-3 text-black"
                                    style="color: var(--text-primary); font-weight: 600; font-size: 13px;">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($standing_array as $standing)
                                <tr class="border-bottom"
                                    style="border-color: rgba(51,65,85,0.3); transition: var(--transition-fast);"
                                    onmouseover="this.style.background='rgba(99,102,241,0.05)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="px-4 py-3">
                                        <span class="badge"
                                            style="background: var(--primary-bg); color: var(--primary-light); font-size: 11px; padding: 4px 8px;">
                                            #{{ str_pad($loop->index + 1, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $standing->name }}</td>
                                    <td class="py-3">{{ $standing->win + $standing->draw + $standing->lose }}</td>
                                    <td class="py-3">{{ $standing->win }}</td>
                                    <td class="py-3">{{ $standing->draw }}</td>
                                    <td class="py-3">{{ $standing->lose }}</td>
                                    <td class="py-3">{{ $standing->goal_for }}</td>
                                    <td class="py-3">{{ $standing->goal_against }}</td>
                                    <td class="py-3">{{ $standing->goal_difference }}</td>
                                    <td class="py-3">{{ $standing->point }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="py-5 text-center" style="color: var(--text-light);">
                                        <i class="fas fa-futbol fa-3x mb-3 opacity-50"></i>
                                        <h6 style="color: var(--text-secondary);">Belum ada data standings</h6>
                                        <p class="mb-3">Silahkan upload file Excel</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
