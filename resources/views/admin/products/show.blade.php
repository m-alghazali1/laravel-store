@extends('admin.parent')

@section('content')
    <div class="row">
        <div class="container p-0">
            <div class="row mt-5">
                <div class="col-7">
                    <div>
                        @if ($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                    class="card-img-top" width="822px" height="290px" alt="product image">
                            @endif
                    </div>
                </div>

                <div class="col-5">
                    <div>
                        <h1>{{ $product->name }}</h1>
                        <p>{{ $product->description }}</p>
                        <p class="card-text text-dark"><del>{{ $product->old_price }}</del>&nbsp; &nbsp;
                            {{ $product->price }} USD</p>
                    </div>
                    <p class="mt-3 fw-bold">Available Quantity:
                        <span class="badge bg-secondary">{{ $product->quantity }}</span>
                    </p>
                    <div style="margin-top: -13px; ">
                        <div>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info mt-5 w-75">
                                <i class="fas fa-edit"></i>Update Product
                            </a>
                        </div>
                        <div>
                            <button onclick="confirmDelete({{ $product->id }},this)"
                                class="btn btn-danger mt-2 w-75">Delete
                                Product
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    @foreach ($product->images->skip(1) as $image)
                        <div class="p-2" style="width: 150px; height: 150px;">
                            <img src="{{ asset('storage/' . $image->image_url) }}"
                                style="width: 100%; height: 100%; object-fit: cover;" class="rounded border">
                        </div>
                    @endforeach
                </div>
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
