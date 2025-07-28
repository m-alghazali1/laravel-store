@extends('admin.parent')

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
          <form id="create-form">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label>Select</label>
                <select class="form-control" id="guard">
                  @foreach ($guards as $guard)
                    <option value="{{ $guard['value'] }}">{{ $guard['name'] }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> <!-- Add this line for toastr -->

<script>
  function save() {
    axios.post('{{ route('admin.roles.store') }}', {
      name: document.getElementById('name').value,
      guard: document.getElementById('guard').value
    }).then(function() {
      toastr.success('Success'); // Use toastr here
      document.getElementById('create-form').reset();
    })
    .catch(function() {
      toastr.error('Error'); // Use toastr here
    });
  }
</script>
@endsection
