@extends('admin.parent')

@section('title', 'Create Category')
@section('name-page', 'Create Category')
@section('breadcrumb-main', 'Categories')
@section('breadcrumb-sub', 'Create')

@section('content')
    <div class="row">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">Add New Category</div>
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger' }}">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name">

                            <label for="description">Description</label>
                            <input type="text" name="description" class="form-control"
                                placeholder="Enter category description">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
