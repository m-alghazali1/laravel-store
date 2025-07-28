@extends('admin.parent')

@section('title', 'User-Permissions}')

@section('main-title', 'User Permissions')
@section('breadcrumb-main', 'User Permissions')
@section('braedcrumb-sub', 'User Permissions')

@section('style')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $user->name }} Permissions</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>User Type</th>
                                        <th style="width: 40px">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $data)
                                        <tr>
                                            {{-- <td> {{ $data->id }} </td> --}}
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td> {{ $data->name }} </td>
                                            <td> {{ $data->guard_name }} </td>
                                            <td>
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="permission_{{ $data->id }}"
                                                        onchange="updateRolePermissions({{ $data->id }})"
                                                        @checked($data->assigned)>
                                                    <label for="permission_{{ $data->id }}">
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('script')
    <!-- SweetAlert2 -->
    {{--
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        function updateRolePermissions(permissionId) {
            console.log('loaded');
            axios.put('{{ route('admin.user.update-permissions', $user->id) }}', {
                permission_id: permissionId,
                user_id: '{{ $user->id }}'
            })
                .then(function (response) {
                    toastr.success(response.data.message);
                    // showMessage(response.data.message, 'success');
                })
                .catch(function (error) {
                    showMessage(error.response.data.message, 'error');
                })
        }

        function showMessage(title, icon) {
            Swal.fire({
                position: 'center',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
