@extends('admin.parent')

@section('content')
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <input type="text" placeholder="search" class="form-control" id="input">
                    <button type="button" class="btn btn-info model" data-bs-dismiss="modal">search</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="container p-0">
        <div class="row mt-5">
            <div class="col-7">
                <div>
                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" width="100%">
                </div>
            </div>

            <div class="col-5">
                <div>
                    <h1>{{ $product->name }}</h1>
                    <p>{{ $product->description }}</p>
                    <p class="card-text text-dark"><del>{{ $product->old_price }}</del>&nbsp; &nbsp;
                        {{ $product->price }} USD</p>
                </div>
                <p class="mt-3">Quantity</p>
                <div style="margin-top: -13px; ">
                    <div style="max-width: 120px; height: 50px; border: 2px solid black" class="">
                        <a href="#"><i class="fa-solid fa-plus text-start text-start mt-3 ms-2 me-4"></i></a>
                        1
                        <a href="#"><i class="fa-solid fa-minus text-end text-end ms-4"></i></a>
                    </div>
                    <div>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info mt-5 w-75">
                            <i class="fas fa-edit"></i>Update Product
                        </a>
                    </div>
                    <div>
                        <button onclick="confirmDelete({{ $product->id }},this)" class="btn btn-danger mt-2 w-75">Delete
                            Product
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                @foreach ($product->images as $image)
                    <div class="p-2" style="width: 150px; height: 150px;">
                        <img src="{{ asset('storage/' . $image->image_url) }}"
                            style="width: 100%; height: 100%; object-fit: cover;" class="rounded border">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(id, reference) {

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            axios.delete(`/admin/products/${id}`)
                .then(function(response) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.message
                    })
                    reference.closest('.container').remove();
                    window.location.href = '/admin/products';
                    // setTimeout(() => {
                    //     window.location.href = '/admin/products';
                    // }, 1000);
                })
                .catch(function(error) {
                    Toast.fire({
                        icon: error.response.data.icon,
                        title: error.response.data.message
                    })

                })
        }
    </script>
@endsection
