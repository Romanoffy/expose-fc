<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller
{

    public function __construct()
    {
        // $this->middleware('isadmin');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        return view('admin.blogs.index', [
            'blog_array' => Blogs::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    public function blogsite(Request $request)
    {
        $limit = $request->limit ?? 10;
        $search = $request->search ?? null;

        return view('client.blog', [
            'blog_array' => Blogs::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $blogs = new Blogs;
        $blogs->title = $request->input('title');
        $blogs->date = $request->input('date');
        $blogs->mini_description = $request->input('mini_description');
        $blogs->full_description = $request->input('full_description');
        $blogs->writer = $request->input('writer');
        $blogs->slug = $this->slugify($request->input('title'));


        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('picture')) {
            $blogs->picture = $request->file('picture')->store('blog', 'public');
        }

        try {
            $blogs->save();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/blogs')
                ->with('success', 'Blog berhasil dibuat!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/blogs/create')
                ->with('error', 'Berita belum berhasil dibuat!')->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function blogsite_detail($param)
    {
        $str = explode("-", $param);
        $id = $str[0];
        return view('client.detail-blog', compact('id'), [
            'blogs' => Blogs::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.blogs.edit', [
            'blog_array' => Blogs::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd(1);
        $currentUser = Auth::user();

        $blogs = Blogs::find($id);
        $blogs->title = $request->input('title');
        $blogs->date = $request->input('date');
        $blogs->mini_description = $request->input('mini_description');
        $blogs->full_description = $request->input('full_description');
        $blogs->writer = $request->input('writer');


        $request->validate([
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Adjust validation rules as needed
        ]);

        if ($request->hasFile('picture')) {
            $blogs->picture = $request->file('picture')->store('blog', 'public');
        }

        try {
            $blogs->save();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/blogs')
                ->with('success', 'Blog berhasil diedit!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/blogs/{{$id}}/edit')
                ->with('error', 'Berita belum berhasil diedit!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $currentUser = Auth::user();

        $blogs = Blogs::find($id);

        try {
            $blogs->delete();
            // $formFields = $request->validate([
            //     'title' => 'required',
            //     'date' => 'required',
            //     'mini_description' => 'required',
            //     'full_description' => 'required',
            //     'writer' => 'required'
            // ]);

            // // if ($request->hasFile('images')){
            // //     $formFields['images'] = $request->file('images')->store('picture', 'public');
            // // }

            // Blogs::create($formFields);

            return redirect('admin/blogs')
                ->with('success', 'Blog berhasil dihapus!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('admin/blogs')
                ->with('error', 'Berita belum berhasil dihapus!')->withInput();
        }
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
    public function uploadImage(Request $request)
{
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/blog_images', $filename);

        // HARUS mengembalikan key 'url'
        return response()->json([
            'url' => asset('storage/blog_images/' . $filename)
        ]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
}

}
