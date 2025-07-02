@extends('parents.home')
@section('content')
    <div class="container p-0">
        <div class="row mt-5">
            <div class="col-7">
                <div>
                    {{-- {{ dd($product->images->first()?->image_url)}} --}}
                    @if ($product->images->first()?->image_url)
                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" width="100%">
                    @endif
                </div>
            </div>

            <div class="col-5">
                <div>
                    <h1>{{ $product->name }}</h1>
                    <p>{{ $product->description }}</p>
                    <p class="card-text text-dark">
                        <del>{{ $product->old_price }}</del>&nbsp; &nbsp;
                        {{ $product->price }} USD
                    </p>
                </div>
                <p class="mt-3">Quantity</p>
                <div style="margin-top: -13px; ">
                    <div
                        style="max-width: 120px; height: 50px; border: 2px solid black; display: flex; align-items: center; justify-content: center;">
                        <a href="#" id="increaseQty"
                            style="text-decoration:none; font-size: 24px; padding: 0 10px;"><i
                                class="fa-solid fa-plus"></i></a>
                        <span id="quantity" style="font-size: 18px; margin: 0 10px;">1</span>
                        <input type="hidden" id="quantityInput" value="1">

                        <a href="#" id="decreaseQty"
                            style="text-decoration:none; font-size: 24px; padding: 0 10px;"><i
                                class="fa-solid fa-minus"></i></a>
                    </div>
                    <div>
                        <button id="addToCartBtn" class="btn btn-light mt-5 w-75" style="border: 1px solid black">
                            Add to cart
                        </button>

                    </div>
                    <div>
                        <button class="btn btn-info mt-2 w-75">Bay it now</button>
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
    <div class="container p-0 mt-5">
        <div class="row pt-5 pb-5">
            <div class="col-lg-12">
                <h1>More products</h1>
            </div>
        </div>
    </div>
    <div class="container p-0 mt-2">

        <div class="row gy-5">
            @foreach ($moreProduct as $product_item)
                <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-5 mt-md-5">
                    <a href="{{ route('products.show', $product_item->id) }}" class="text-decoration-none mt-5">
                        <div class="card">
                            @if ($product_item->images->first())
                                <img src="{{ asset('storage/' . $product_item->images->first()->image_url) }}"
                                    class="card-img-top" width="822px" height="290px" alt="product image">
                            @endif

                            @if ($product_item->old_price)
                                <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                            @endif
                            <div class="card-body">

                                <h5 class="card-title text-dark">{{ $product_item->name }}</h5>
                                <p class="card-text text-dark">
                                    @if ($product_item->old_price)
                                        <del>{{ $product_item->old_price }} USD</del>
                                    @endif

                                    &nbsp; &nbsp;
                                    {{ $product_item->price }} $
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('script')
    <script>
        const increaseBtn = document.getElementById('increaseQty');
        const decreaseBtn = document.getElementById('decreaseQty');
        const quantitySpan = document.getElementById('quantity');
        const quantityInput = document.getElementById('quantityInput');

        increaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentQty = parseInt(quantitySpan.textContent);
            currentQty++;
            quantitySpan.textContent = currentQty;
            quantityInput.value = currentQty;
        });

        decreaseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let currentQty = parseInt(quantitySpan.textContent);
            if (currentQty > 1) {
                currentQty--;
                quantitySpan.textContent = currentQty;
                quantityInput.value = currentQty;
            }
        });

        document.getElementById('addToCartBtn').addEventListener('click', function(e) {
            e.preventDefault();

            let productId = {{ $product->id }};
            let quantity = document.getElementById('quantityInput').value;

            axios.post('/cart/add/' + productId, {
                    product_id: productId,
                    quantity: quantity
                })
                .then(response => {
                    toastr.success(response.data.message || 'Product added to cart');
                    window.location.href = '/cart'; // إعادة التوجيه إلى صفحة السلة
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        sessionStorage.setItem('intended', window.location.href);
                        window.location.href = '/app/user/login';
                    } else {
                        toastr.error(error.response.data.message || 'Failed to add to cart');
                    }
                });
        });
    </script>
@endsection
