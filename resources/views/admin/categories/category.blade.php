@extends('admin.parent')

@section('title', 'Create Category')
@section('name-page', 'Create Category')
@section('breadcrumb-main', 'Categories')
@section('breadcrumb-sub', 'Create')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Simple Tables</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Simple Tables</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bordered Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th style="width: 40px">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->description}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                        class="btn btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <button type="submit" onclick="destroy({{ $category->id }}, this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('script')
    <script>
        function destroy(id, reference) {

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            axios.delete(`/admin/categories/${id}`)
                .then(function (response) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.message
                    })
                    reference.closest('tr').remove();
                })
                .catch(function (error) {
                    Toast.fire({
                        icon: error.response.data.icon,
                        title: error.response.data.message
                    })

                })
        }

        document.addEventListener('DOMContentLoaded', function (event) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            @if(session()->has('status'))
                Toast.fire({
                    icon: '{{ session('icon') }}',
                    title: '{{ session('message') }}'
                });
            @endif

        });
    </script>
@endsection
