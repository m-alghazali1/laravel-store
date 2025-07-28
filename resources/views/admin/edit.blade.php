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
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($role->id == ($curent_role->id ?? ''))>
                                                {{ $role->name }}
                                            </option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                                        value="{{ $admin->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                        name="email" value="{{ $admin->email }}">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="update('{{ $admin->id }}')"
                                    class="btn btn-primary ">Save</button>
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
        function update(id) {
            axios.put(`/admin/admins/${id}`, {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                role_id: document.getElementById('roll_id').value,
            }).then(function (response) {
                toastr.success(response.data.message)
                document.getElementById('create-from').reset()
                window.location.href = '{{ route('admin.admins.index') }}';

            }).catch(function (error) {
                toastr.error(error.response.data.message)
            })
        }

    </script>

@endsection
