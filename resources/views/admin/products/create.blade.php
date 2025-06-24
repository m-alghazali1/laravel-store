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
                        <form id="create-from" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('message'))
                                    <div
                                        class="alert @if (session('status')) alert-success @else  alert-danger @endif alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                        Success alert preview. This alert is dismissable.
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control" id="category_id">
                                        @if ($categories && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @else
                                            <option disabled selected>No categories available</option>
                                        @endif

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name"
                                        name="name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="3" placeholder="Enter product description"
                                        name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="oldPrice">Old Price</label>
                                    <input type="" class="form-control" id="oldPrice" placeholder="Enter Old Price"
                                        name="oldPrice">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="" class="form-control" id="price" placeholder="Enter Price"
                                        name="price">
                                </div>
                                <div class="form-group">
                                    <label for="image-input">File image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image-input" name="images[]"
                                                multiple>
                                            <label class="custom-file-label" for="image-input">Choose image</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity"
                                        name="quantity" min="1">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="saveWithImage()" class="btn btn-primary ">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script>
        function saveWithImage() {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('oldPrice', document.getElementById('oldPrice').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('quantity', document.getElementById('quantity').value);

            let imageFiles = document.getElementById('image-input').files;
            for (let i = 0; i < imageFiles.length; i++) {
                formData.append('images[]', imageFiles[i]);
            }

            axios.post('/admin/products', formData)
                .then(function(response) {
                    toastr.success(response.data.message)
                    document.getElementById('create-from').reset()
                    window.location.href = '/admin/products';

                })
                .catch(function(error) {
                    toastr.error(error.response.data.message)
                })
        }
    </script>

@endsection
