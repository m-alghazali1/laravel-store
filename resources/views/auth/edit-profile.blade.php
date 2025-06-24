@extends('cms.parent')

@section('title', 'Products')

@section('name-page', 'Products')
@section('breadcrumb-main', 'Form')
@section('breadcrumb-sub', 'All')


@section('content')

<div class="row">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Quick Example</h3>
      </div>
      {{-- <form method="POST" action="{{route('products.store')}}"> --}}
      <form id="create-from">
        @csrf
        <div class="card-body">

          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"  value="{{$user->name}}">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email" value="{{$user->email}}">
          </div>
        </div>
        <!-- /.card-body -->
      
        <div class="card-footer">
          <button type="button" onclick="editUser()" class="btn btn-primary ">Submit</button>
        </div>
      </form>
    </div>
  </div>
    </div>
  </div>
  
</div>

@endsection

@section('script')
<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
  <script>
    $(function () {
      bsCustomFileInput.init();
    });
  </script>
  <script>
    function editUser() {
      axios.put('{{route('auth.update-user')}}',{
        name: document.getElementById('name').value,
        email: document.getElementById('email').value
      })
      .then(function(response) {
        toastr.success(response.data.message)
        document.getElementById('create-from').reset()
      })
      .catch(function(error) {
        toastr.error(error.response.data.message)
      })
    }

    // function save() {
    //   axios.post('/cms/admin/products', {
    //     category_id: document.getElementById('category').value,
    //     name: document.getElementById('name').value,
    //     price: document.getElementById('price').value,
    //   }).then(function() {
    //     toastr.success('success');
    //   })
    //   .catch(function() {
    //     toastr.error('error');
    //   })
    // }
    // function save() {
    //     axios.post('/cms/admin/products', {
    //     category_id: document.getElementById('category_id').value,
    //     name: document.getElementById('name').value,
    //     price: document.getElementById('price').value,
    //     }).then(function(response) {
    //     toastr.success(response.data.message);
    //     document.getElementById('create-from').reset();
    //     window.location.href = '/cms/admin/products';
    //     })
    //     .catch(function(error) {
    //         toastr.error(error.response.data.message);
    //     });
    //   }

  </script>

@endsection