<?php

namespace App\Http\Controllers;

use App\Models\Competitions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('isadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search');
        $year = $request->input('year');
        $category = $request->input('category');
        $status = $request->input('status');

        $query = Competitions::query();

        // Apply filters
        if ($search) {
            $query->search($search);
        }

        if ($year) {
            $query->byYear($year);
        }

        if ($category) {
            $query->byCategory($category);
        }

        if ($status) {
            $query->byStatus($status);
        }

        // Get competitions with pagination
        $competitions = $query->latest()->paginate($limit);

        // Get unique years untuk filter
        $years = Competitions::selectRaw('DISTINCT year')
            ->whereNotNull('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.competitions.index', [
            'competitions_array' => $competitions,
            'limit' => $limit,
            'search' => $search,
            'years' => $years,
            'selectedYear' => $year,
            'selectedCategory' => $category,
            'selectedStatus' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.competitions.create', [
            'eventsByCategory' => Competitions::getEventsByCategory()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'category' => 'required|in:internal,external,friendly',
            'event_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \App\Models\MenuCategory::where('category', $request->category)
                        ->where('event_name', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Event type tidak valid untuk kategori yang dipilih.');
                    }
                },
            ],
            'description' => 'required|string|min:10',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'name.required' => 'Nama kompetisi wajib diisi.',
            'year.required' => 'Tahun kegiatan wajib dipilih.',
            'year.min' => 'Tahun kegiatan minimal 2020.',
            'category.required' => 'Kategori wajib dipilih.',
            'event_type.required' => 'Event wajib dipilih.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        try {
            Competitions::create($validated);

            return redirect('admin/competitions')
                ->with('success', 'Kompetisi berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect('admin/competitions/create')
                ->with('error', 'Kompetisi gagal dibuat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $competition = Competitions::findOrFail($id);

    //     return view('admin.competitions.show', [
    //         'competition' => $competition
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $competition = Competitions::findOrFail($id);

        return view('admin.competitions.edit', [
            'competitions_array' => $competition,
            'eventsByCategory' => Competitions::getEventsByCategory()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $competition = Competitions::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'category' => 'required|in:internal,external,friendly',
            'event_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \App\Models\MenuCategory::where('category', $request->category)
                        ->where('event_name', $value)
                        ->exists();

                    if (!$exists) {
                        $fail('Event type tidak valid untuk kategori yang dipilih.');
                    }
                },
            ],
            'description' => 'required|string|min:10',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'name.required' => 'Nama kompetisi wajib diisi.',
            'year.required' => 'Tahun kegiatan wajib dipilih.',
            'year.min' => 'Tahun kegiatan minimal 2020.',
            'category.required' => 'Kategori wajib dipilih.',
            'event_type.required' => 'Event wajib dipilih.',
            'description.required' => 'Deskripsi wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        try {
            $competition->update($validated);

            return redirect('admin/competitions')
                ->with('success', 'Kompetisi berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect('admin/competitions/' . $id . '/edit')
                ->with('error', 'Kompetisi gagal diupdate: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $competition = Competitions::findOrFail($id);
            $name = $competition->name;

            $competition->delete();

            return redirect('admin/competitions')
                ->with('success', "Kompetisi '{$name}' berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect('admin/competitions')
                ->with('error', 'Kompetisi gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Get events by category (for AJAX request)
     */
    public function getEventsByCategory(Request $request)
    {
        $category = $request->input('category');

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid'
            ], 400);
        }

        // Get events from dynamic source
        $allEvents = Competitions::getEventsByCategory();

        if (!isset($allEvents[$category])) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'events' => $allEvents[$category]
        ]);
    }
}