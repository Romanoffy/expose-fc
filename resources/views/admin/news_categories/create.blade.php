@extends('layouts.dashboard')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">News Categories Form</h6>
                <form action="/admin/news_categories" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="news_categories" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="news_categories">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href='/admin/news_categories'>
                        <button type="button" class="btn btn-primary m-2">Cancel</button>
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection