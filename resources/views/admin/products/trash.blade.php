@extends('admin.parent')


@section('style')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row pt-0 pb-0">
            <div class="col-lg-12">
                <h1>Product</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row gy-5">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-5 mt-md-5">
                    <div class="card position-relative">

                        <a href="{{ route('admin.products.show', $product->id) }}" class="text-decoration-none">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                    class="card-img-top" width="822px" height="290px" alt="Product Image">
                            @else
                                <img src="" class="card-img-top" width="822px" height="290px" alt="No Image">
                            @endif

                            @if ($product->old_price)
                                <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                            @endif
                        </a>

                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $product->name }}</h5>
                            <p class="card-text text-dark">
                                @if ($product->old_price)
                                    <del>${{ $product->old_price }}</del>&nbsp;&nbsp;
                                @endif
                                ${{ $product->price }}
                            </p>

                            <!-- زر الاستعادة -->
                            <button onclick="restoreProduct({{ $product->id }}, this)" class="btn btn-success btn-sm me-2">
                                <i class="fas fa-undo"></i> Restore
                            </button>

                            <!-- زر الحذف النهائي -->
                            <button onclick="forceDelete({{ $product->id }}, this)" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Force Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('script')
    <script>
        function restoreProduct(id, reference) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            axios.post(`/admin/products/restore/${id}`)
                .then(function(response) {
                    Toast.fire({
                        icon: response.data.icon,
                        title: response.data.message
                    })
                    reference.closest('.col-lg-3').remove();
                })
                .catch(function(error) {
                    Toast.fire({
                        icon: error.response.data.icon,
                        title: error.response.data.message
                    })

                })
        }

        function forceDelete(id, reference) {

            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete the product permanently!",
                icon: 'warning',
                showCancelButton: true, // يظهر زر الإلغاء
                confirmButtonColor: '#d33', // لون زر التأكيد (أحمر)
                cancelButtonColor: '#3085d6', // لون زر الإلغاء (أزرق)
                confirmButtonText: 'Yes, delete it!', // نص زر التأكيد
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    axios.delete(`/admin/products/force-delete/${id}`)
                        .then(function(response) {
                            Toast.fire({
                                icon: response.data.icon,
                                title: response.data.message
                            })
                            reference.closest('.col-lg-3').remove();
                        })
                        .catch(function(error) {
                            Toast.fire({
                                icon: error.response.data.icon,
                                title: error.response.data.message
                            });

                        });
                }
            });
        }


    </script>
@endsection
