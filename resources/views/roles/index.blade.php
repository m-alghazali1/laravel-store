@extends('admin.parent')

@section('style')
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection

@section('title', 'products')



@section('name-page', 'Products')
@section('breadcrumb-main', 'Products')
@section('breadcrumb-sub', 'All')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Products</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th style="width: 10px">id</th>
                  <th>Name</th>
                  <th>Guard</th>
                  <th>Permission</th>
                  <th style="width: 40px">Settings</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $role)
                  <tr>
                    <td>{{$loop->index +1}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->guard_name}}</td>
                    <td>{{$role->permissions_count}}</td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('admin.roles.show', $role->id)}}" class="btn btn-primary">
                          <i class="fas fa-solid fa-user-shield"></i>
                        </a>
                        <a href="{{ route('admin.roles.edit', $role->id)}}" class="btn btn-info">
                          <i class="fas fa-edit"></i>
                        </a>
                        <button type="submit" class="btn btn-danger" onclick="confirmDestroy('{{ route('admin.roles.destroy', $role->id) }}', this )">
                         <i class="fas fa-trash-alt"></i>
                        </button>
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
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    function confirmDestroy(route, reference) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          destroy(route, reference);
        }
      });
    }

    function destroy(route, reference) {
      axios.delete(route)
        .then(function(response) {
          reference.closest('tr').remove();
          showMessage(response.data.message, 'success');
        }).catch(function(error) {
          showMessage(error.response.data.message, 'error');
        });
    }

    function showMessage(title, icon) {
      Swal.fire({
        position: 'center',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 1500
      });
    }

  </script>
@endsection
