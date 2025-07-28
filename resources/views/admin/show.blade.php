@extends('admin.parent')

@section('style')

@endsection

@section('title', 'Admins')



@section('name-page', 'Admins')
@section('breadcrumb-main', 'Admins')
@section('breadcrumb-sub', 'All')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Admins</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th style="width: 40px">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td> 1 </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td> {{ $admin->roles[0]->name ?? "-"}} </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="destroy({{ $admin->id }}, this )">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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

            axios.delete(`/admin/admins/${id}`)
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
