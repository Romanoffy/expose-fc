@extends('layouts.dashboard')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h6 class="mb-4">News Categories Table</h6>
            <div class="card-header">
             <a href="/admin/news_categories/create"><button type="button" class="btn btn-success">Tambah</button> </a> 
              </div>
            </a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">News Category</th>
                        <th scope="col" colspan="2" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news_categories_array as $newscategory)
                    <tr>
                        <th scope="row">{{$loop-> index+1}}</th>
                        <td>{{ $newscategory->name }}</td>
                        <div>
                            <td class="text-center">
                                <button class="border-0 bg-transparent">
                                    <a href="/admin/news_categories/{{ $newscategory->id }}/edit">
                                        <i class="fas fa-edit text-primary"></i>
                                    </a>
                                </button>
                            </td>
                            <td class="text-center">
                                <form action="/admin/news_categories/{{ $newscategory->id }}" method="DELETE">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Remove"
                                        onclick="return confirm('Are you sure want to delete ?')"><em
                                            class="fa fa-times fa fa-white"></em></button>
                                </form>
                            </td>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
<!-- Table End -->

@endsection