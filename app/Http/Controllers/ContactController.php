<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Auth;

class ContactController extends Controller
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
        $limit = $request->limit ?? 8;
        $search = $request->search ?? null;

        return view('admin.contacts.index', [
            'contact_array' => Contacts::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }


    public function contactsite(Request $request)
    {
        $limit = $request->limit ?? 8;
        $search = $request->search ?? null;

        return view('client.contact', [
            'contact_array' => Contacts::index($search)->paginate($limit),
            'limit' => $limit,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $contacts = new Contacts; 
        $contacts->name = $request->input('name');
        $contacts->email = $request->input('email');
        $contacts->no_hp = $request->input('no_hp');
        $contacts->no_telp = $request->input('no_telp');
        $contacts->address = $request->input('address');
        

        try {
            $contacts->save();
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

            return redirect('admin/contacts')
            ->with('success', 'Team berhasil dibuat!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/contacts/create')
            ->with('error', 'Team belum berhasil dibuat!')->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.contacts.edit', [
            'contact_array' => Contacts::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $contacts = Contacts::find($id);
        $contacts->name = $request->input('name');
        $contacts->email = $request->input('email');
        $contacts->no_hp = $request->input('no_hp');
        $contacts->no_telp = $request->input('no_telp');
        $contacts->address = $request->input('address');

        try {
            $contacts->save();
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

            return redirect('admin/contacts')
            ->with('success', 'Team berhasil diedit!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/contacts/{{$id}}/edit')
            ->with('error', 'Team belum berhasil diedit!')->withInput();
        }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($request->all());
        $currentUser = Auth::user();

        $contacts = Contacts::find($id);
        
        try {
            $contacts->delete();
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

            return redirect('admin/contacts')
            ->with('success', 'Team berhasil dihapus!');
        }catch(\Throwable $th) {
            dd($th);
            return redirect('admin/contacts')
            ->with('error', 'Team belum berhasil dihapus!')->withInput();
        }
    }
}