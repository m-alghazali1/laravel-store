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
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                        name="email">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="phone" class="form-control" id="phone" placeholder="Enter Phone"
                                        name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Enter Address"
                                        name="address">
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" multiple class="form-control" id="logo" placeholder="Enter Logo"
                                        name="logo">
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
        // axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        function saveWithImage() {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('password', document.getElementById('password').value);
            formData.append('password_confirmation', document.getElementById('password_confirmation').value);
            formData.append('logo', document.getElementById('logo').files[0]);

            axios.post('{{ route('admin.vendors.store') }}', formData,)
                .then(function (response) {
                    toastr.success(response.data.message)
                    document.getElementById('create-from').reset()
                    window.location.href = '{{ route('admin.vendors.index') }}';

                }).catch(function (error) {
                    toastr.error(error.response.data.error)
                })
        }

    </script>

@endsection
