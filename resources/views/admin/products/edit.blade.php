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
                        <form id="edit-from" enctype="multipart/form-data">
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
                                        name="name" value="{{ old('name', $product->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" rows="3" placeholder="Enter product description"
                                        name="description">{{ old('description', $product->description) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="oldPrice">Old Price</label>
                                    <input type="" class="form-control" id="oldPrice" placeholder="Enter Old Price"
                                        name="oldPrice" value="{{ old('old_price', $product->old_price) }}">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="" class="form-control" id="price" placeholder="Enter Price"
                                        name="price" value="{{ old('price', $product->price) }}">
                                </div>
                                @if ($product->images && count($product->images) > 0)
                                    <div class="mb-3">
                                        <label>Current Images:</label>
                                        <div class="row">
                                            @foreach ($product->images as $image)
                                                <div class="col-md-3 text-center position-relative"
                                                    id="image-{{ $image->id }}">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}"
                                                        class="img-fluid rounded mb-2" style="height: 120px;">

                                                    <button type="button"
                                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                                        style="border-radius: 50%;"
                                                        onclick="deleteOldImage(event,{{ $image->id }})">
                                                        &times;
                                                    </button>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="image-input">File image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image-input" name="images[]"
                                                multiple>
                                            <label class="custom-file-label" for="image-input">Choose image</label>
                                        </div>
                                    </div>
                                    <!-- حاوية عرض الصور المختارة -->
                                    <div class="mt-3">
                                        <h5>Selected Images Preview:</h5>
                                        <div id="preview-images" class="row g-3"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity"
                                        name="quantity" min="1" value="{{ old('quantity', $product->quantity) }}">
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

            selectedFiles.forEach(file=>{
                formData.append('images[]', file);
            })

            formData.append('_method', 'PUT');
            axios.post('/admin/products/{{ $product->id }}', formData)
                .then(function(response) {
                    toastr.success(response.data.message)
                    document.getElementById('edit-from').reset()
                    // window.location.href = '/admin/products';
                    setTimeout(() => {
                        window.location.href = '/admin/products';
                    }, 500);

                })
                .catch(function(error) {
                    toastr.error(error.response.data.message)
                })
        }

        function deleteOldImage(event, imageId) {
            axios.delete(`/admin/products/delete-image/${imageId}`)
                .then(response => {
                    if (response.data.status) {
                        document.getElementById(`image-${imageId}`).remove();
                        toastr.success(response.data.message);
                    } else {
                        toastr.error(response.data.message);
                    }
                })
                .catch(error => {
                    toastr.error('Something went wrong!');
                    console.error(error);
                });
        }
        let selectedFiles = [];

        document.getElementById('image-input').addEventListener('change', function(event) {

            for (let file of event.target.files) {
                selectedFiles.push(file);
            }
            renderPreviews();
            this.value = '';
        });

        function renderPreviews() {
            let container = document.getElementById('preview-images');
            container.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let div = document.createElement('div');
                    div.style.position = 'relative';
                    div.style.display = 'inline-block';
                    div.style.margin = '10px';

                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '120px';
                    img.style.height = '120px';
                    img.style.borderRadius = '8px';

                    let btn = document.createElement('button');
                    btn.innerText = '×';
                    btn.style.position = 'absolute';
                    btn.style.top = '2px';
                    btn.style.right = '2px';
                    btn.style.background = 'red';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    btn.style.borderRadius = '50%';
                    btn.style.cursor = 'pointer';
                    btn.style.width = '20px';
                    btn.style.height = '20px';
                    btn.onclick = function() {
                        selectedFiles.splice(index, 1);
                        renderPreviews();
                    };

                    div.appendChild(img);
                    div.appendChild(btn);
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    </script>

@endsection
