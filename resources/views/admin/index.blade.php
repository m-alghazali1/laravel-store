@extends('admin.parent')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Admin Data</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{$admin->id}}</td>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection


