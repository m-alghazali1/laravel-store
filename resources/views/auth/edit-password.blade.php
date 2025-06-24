@extends('cms.parent')

@section('title', 'create')

@section('name-page', 'Create')
@section('breadcrumb-main', 'Form')
@section('breadcrumb-sub', 'All')


@section('content')

<section class="content">
  <div class="container-fluid">
      <div class="row">
          <!-- left column -->
          <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                  <div class="card-header">
                      <h3 class="card-title">Edit Password</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form id="edit-password-form">
                      @csrf
                      <div class="card-body">
                          <div class="form-group">
                              <label for="old-password-input">Old Password</label>
                              <input type="password" class="form-control" placeholder="Old Password"
                                  id="old-password-input">
                          </div>
                          <div class="form-group">
                              <label for="new-password-input">New Password</label>
                              <input type="password" class="form-control" placeholder="New Password"
                                  id="new-password-input">
                          </div>
                          <div class="form-group">
                              <label for="new-password_confirmation-input">New Password Confirmation</label>
                              <input type="password" class="form-control" placeholder="New Password Confirmation"
                                  id="new-password_confirmation-input">
                          </div>

                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                          <button type="button" onclick="updatePassword()" class="btn btn-primary">Submit</button>
                      </div>
                  </form>
              </div>
              <!-- /.card -->

          </div><!-- /.container-fluid -->
</section>
@endsection
@section('script')
  <script>
    function updatePassword() {
      axios.put('{{ route('auth.update-password') }}', {
        'old-password': document.getElementById('old-password-input').value,
        'new-password': document.getElementById('new-password-input').value,
        'new-password_confirmation': document.getElementById('new-password_confirmation-input').value,
      })
      .then(function(response) {
        //
        toastr.success(response.data.message);
        document.getElementById('edit-password-form').reset();
      })
      .catch(function(error) {
        //
        toastr.error(error.response.data.message)
      });
    }
  </script>
@endsection