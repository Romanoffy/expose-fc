<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiteEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Events::with('venue')->orderBy('tanggal_mulai', 'asc');

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('tanggal_mulai', $request->year);
        }

        // Filter tanggal (from - to)
        if ($request->filled('from')) {
            $query->whereDate('tanggal_mulai', '>=', Carbon::parse($request->from));
        }
        if ($request->filled('to')) {
            $query->whereDate('tanggal_selesai', '<=', Carbon::parse($request->to));
        }

        // Filter search nama event
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $events = $query->get();

        // Kelompokkan per tahun
        $groupedEvents = $events->groupBy(function ($event) {
            return Carbon::parse($event->tanggal_mulai)->format('Y');
        });

        // Hitung total event per tahun
        $yearCounts = Events::selectRaw('YEAR(tanggal_mulai) as year, COUNT(*) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return view('client.event', compact('events', 'groupedEvents', 'yearCounts'));
    }
}
