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
                        <form id="create-from">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Select Role</label>
                                    <select class="form-control" id="roll_id">
                                        @foreach ($roles as $roll)
                                            <option value="{{$roll->id}}">{{ $roll->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                        name="email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter Password"
                                        name="password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        placeholder="Confirm Password" name="password_confirmation">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="saveWithImage()" class="btn btn-primary ">Save</button>
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
        function saveWithImage() {
            axios.post('{{ route('admin.admins.store') }}', {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                password_confirmation: document.getElementById('password_confirmation').value,
                role_id: document.getElementById('roll_id').value,
            }).then(function (response) {
                toastr.success(response.data.message)
                document.getElementById('create-from').reset()
                window.location.href = '{{ route('admin.admins.index') }}';

            }).catch(function (error) {
                toastr.error(error.response.data.error)
            })
        }

    </script>

@endsection
