@extends('layouts.dashboard')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Edit Positions Form</h6>
                <form action="/admin/news_categories/{{$news_categories_array->id}}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="mb-3">
                        <label for="news_categories" class="form-label">Name</label>
                        <input type="text" name="name" value="{{$news_categories_array->name}}" class="form-control"
                            id="news_categories">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href='/admin/positions'>
                        <button type="button" class="btn btn-primary m-2">Cancel</button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection