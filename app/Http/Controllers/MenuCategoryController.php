<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuCategoryController extends Controller
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
        $category = $request->input('category');

        $query = MenuCategory::query();

        // Apply filters
        if ($search) {
            $query->search($search);
        }

        if ($category) {
            $query->byCategory($category);
        }

        // Get menu categories with pagination
        $menuCategories = $query->ordered()->paginate($limit);

        return view('admin.menu-categories.index', [
            'menuCategories' => $menuCategories,
            'limit' => $limit,
            'search' => $search,
            'selectedCategory' => $category,
            'categoryLabels' => MenuCategory::$categoryLabels,
            'categories' => ['internal' => 'Internal', 'external' => 'External', 'friendly' => 'Friendly']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menu-categories.create', [
            'categoryLabels' => MenuCategory::$categoryLabels,
            'categories' => ['internal' => 'Internal', 'external' => 'External', 'friendly' => 'Friendly']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:internal,external,friendly',
            'event_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_categories')->where(function ($query) use ($request) {
                    return $query->where('category', $request->category);
                }),
            ],
            'description' => 'nullable|string',
        ], [
            'category.required' => 'Kategori wajib dipilih.',
            'category.in' => 'Kategori harus internal, external, atau friendly.',
            'event_name.required' => 'Nama event wajib diisi.',
            'event_name.unique' => 'Nama event sudah ada untuk kategori ini.',
            'event_name.max' => 'Nama event maksimal 255 karakter.',
        ]);

        try {
            MenuCategory::create($validated);

            return redirect('admin/menu-categories')
                ->with('success', 'Event berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect('admin/menu-categories/create')
                ->with('error', 'Event gagal ditambahkan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menuCategory = MenuCategory::findOrFail($id);

        return view('admin.menu-categories.show', [
            'menuCategory' => $menuCategory,
            'categoryColor' => $this->getCategoryColor($menuCategory->category),
            'categoryLabel' => $this->getCategoryLabel($menuCategory->category),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menuCategory = MenuCategory::findOrFail($id);

        return view('admin.menu-categories.edit', [
            'menuCategory' => $menuCategory,
            'categoryLabels' => MenuCategory::$categoryLabels,
            'categories' => ['internal' => 'Internal', 'external' => 'External', 'friendly' => 'Friendly']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menuCategory = MenuCategory::findOrFail($id);

        $validated = $request->validate([
            'category' => 'required|in:internal,external,friendly',
            'event_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu_categories')->where(function ($query) use ($request) {
                    return $query->where('category', $request->category);
                })->ignore($id),
            ],
            'description' => 'nullable|string',
        ], [
            'category.required' => 'Kategori wajib dipilih.',
            'category.in' => 'Kategori harus internal, external, atau friendly.',
            'event_name.required' => 'Nama event wajib diisi.',
            'event_name.unique' => 'Nama event sudah ada untuk kategori ini.',
            'event_name.max' => 'Nama event maksimal 255 karakter.',
        ]);

        try {
            $menuCategory->update($validated);

            return redirect('admin/menu-categories')
                ->with('success', 'Event berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect('admin/menu-categories/' . $id . '/edit')
                ->with('error', 'Event gagal diupdate: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $menuCategory = MenuCategory::findOrFail($id);
            $eventName = $menuCategory->event_name;

            $menuCategory->delete();

            return redirect('admin/menu-categories')
                ->with('success', "Event '{$eventName}' berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect('admin/menu-categories')
                ->with('error', 'Event gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Get events by category (AJAX)
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

        // Validate category
        if (!in_array($category, ['internal', 'external', 'friendly'])) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid'
            ], 400);
        }

        $events = MenuCategory::where('category', $category)
            ->ordered()
            ->pluck('event_name')
            ->toArray();

        return response()->json([
            'success' => true,
            'events' => $events
        ]);
    }

    /**
     * Get category color
     */
    private function getCategoryColor($category)
    {
        return match ($category) {
            'internal' => '#007bff',
            'external' => '#f59e0b',
            'friendly' => '#10b981',
            default => '#6b7280'
        };
    }

    /**
     * Get category label
     */
    private function getCategoryLabel($category)
    {
        return match ($category) {
            'internal' => 'Internal',
            'external' => 'External',
            'friendly' => 'Friendly Match',
            default => 'Unknown'
        };
    }

    /**
     * Get all categories with colors and labels (for API/AJAX)
     */
    public function getAllCategoriesWithColors()
    {
        $categories = [
            'internal' => [
                'label' => 'Internal',
                'color' => '#007bff',
                'description' => 'Internal Club Matches'
            ],
            'external' => [
                'label' => 'External',
                'color' => '#f59e0b',
                'description' => 'External/League Matches'
            ],
            'friendly' => [
                'label' => 'Friendly Match',
                'color' => '#10b981',
                'description' => 'Friendly/Practice Matches'
            ]
        ];

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Bulk export events by category (CSV/JSON)
     */
    public function exportByCategory(Request $request)
    {
        $category = $request->input('category');
        $format = $request->input('format', 'json');

        if (!$category || !in_array($category, ['internal', 'external', 'friendly'])) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid'
            ], 400);
        }

        $events = MenuCategory::where('category', $category)
            ->ordered()
            ->get();

        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="events_' . $category . '.csv"',
            ];

            $callback = function () use ($events, $category) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Category', 'Event Name', 'Description', 'Created At']);

                foreach ($events as $event) {
                    fputcsv($file, [
                        $event->id,
                        $event->category,
                        $event->event_name,
                        $event->description,
                        $event->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // JSON format (default)
        return response()->json([
            'success' => true,
            'category' => $category,
            'count' => $events->count(),
            'events' => $events
        ]);
    }

    /**
     * Get summary/statistics of all categories
     */
    public function getCategorySummary()
    {
        $summary = [
            'internal' => MenuCategory::where('category', 'internal')->count(),
            'external' => MenuCategory::where('category', 'external')->count(),
            'friendly' => MenuCategory::where('category', 'friendly')->count(),
        ];

        $total = array_sum($summary);

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'total' => $total
        ]);
    }
}