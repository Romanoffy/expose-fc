<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategories;
use Illuminate\Http\Request;
use Auth;

class NewsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('isadmin');
    }

    /**
     * Admin: Display a listing of news
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        return view('admin.news.index', [
            'news_array' => News::index($search, null)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Frontend: Display a listing of news
     */
    public function newssite(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        return view('client.news', [
            'news_array' => News::index($search, 1)->paginate($limit), // hanya publish
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new news
     */
    public function create()
    {
        return view('admin.news.create', [
            'news_categories' => NewsCategories::all()
        ]);
    }

    /**
     * Store a newly created news in storage
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();

        $news = new News;
        $news->title = $request->input('title');
        $news->description = $request->input('description');
        $news->writer = $request->input('writer');
        $news->date = $request->input('date');
        $news->news_category_id = $request->input('news_category_id');
        $news->status = $request->input('status');
        $news->slug = $this->slugify($request->input('title'));

        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('picture')) {
            $news->picture = $request->file('picture')->store('news', 'public');
        }

        try {
            $news->save();
            return redirect('admin/news')->with('success', 'Berita berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/news/create')->with('error', 'Berita belum berhasil dibuat!')->withInput();
        }
    }

    /**
     * Frontend: Display the detail of news
     */
    public function news_detail($param)
    {
        $str = explode("-", $param);
        $id = $str[0];
        return view('client.detail-news', compact('id'), [
            'news' => News::find($id)
        ]);
    }

    /**
     * Show the form for editing a news
     */
    public function edit(string $id)
    {
        return view('admin.news.edit', [
            'news_array' => News::find($id),
            'news_categories' => NewsCategories::all()
        ]);
    }

    /**
     * Update a news in storage
     */
    public function update(Request $request, string $id)
    {
        $currentUser = Auth::user();

        $news = News::find($id);
        $news->title = $request->input('title');
        $news->description = $request->input('description');
        $news->writer = $request->input('writer');
        $news->date = $request->input('date');
        $news->news_category_id = $request->input('news_category_id');
        $news->status = $request->input('status');
        $news->slug = $this->slugify($request->input('title'));

        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('picture')) {
            $news->picture = $request->file('picture')->store('news', 'public');
        }

        try {
            $news->save();
            return redirect('admin/news')->with('success', 'Berita berhasil diedit!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect("admin/news/{$id}/edit")->with('error', 'Berita belum berhasil diedit!')->withInput();
        }
    }

    /**
     * Delete a news
     */
    public function destroy(string $id)
    {
        $news = News::find($id);

        try {
            $news->delete();
            return redirect('admin/news')->with('success', 'Berita berhasil dihapus!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/news')->with('error', 'Berita belum berhasil dihapus!')->withInput();
        }
    }

    /**
     * Upload image for CKEditor / editor
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/news_images', $filename);

            return response()->json([
                'url' => asset('storage/news_images/' . $filename)
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Slug generator
     */
    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);

        return empty($text) ? 'n-a' : $text;
    }
}
