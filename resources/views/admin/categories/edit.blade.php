@extends('admin.parent')

@section('title', 'ُEdit Category')
@section('name-page', 'ُEdit Category')
@section('breadcrumb-main', 'Categories')
@section('breadcrumb-sub', 'ُEdit')

@section('content')
    <div class="row">
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">Edit Category</div>
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert {{ session('status') ? 'alert-success' : 'alert-danger' }}">
                            {{ session('message') }}
                        </div>
                    @endif


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
                        <input id="name" type="text" name="name" class="form-control mb-3" placeholder="Enter category name"
                            value="{{ old('name') ?? $data->name }}">

                        <label for="description">Description</label>
                        <input id="description" type="text" name="description" class="form-control mb-3"
                            placeholder="Enter category description" value="{{ old('description') ?? $data->description }}">

                    </div>
                    <button type="submit" class="btn btn-primary" onclick="update({{ $data->id }})">Update</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        function update(id) {
            name = document.getElementById('name').value;
            description = document.getElementById('description').value;

            axios.put(`/admin/categories/${id}`, {
                name: name,
                description: description
            })

                .then(function (response) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.message
                    })
                    window.location.href = "{{ route('admin.categories.index') }}";

                })
                .catch(function (error) {
                    Toast.fire({
                        icon: error.response.data.icon,
                        title: error.response.data.message
                    })

                })
        }

    </script>

@endsection
