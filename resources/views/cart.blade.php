@extends('parents.home')
@section('content')
    <div class="container py-5">
        <h2>Shopping Cart</h2>
        @if ($cart->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        @php $total += $item->product->price * $item->quantity; @endphp
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>${{ $item->product->price }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                                    <button class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>${{ $item->product->price * $item->quantity }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Total: ${{ $total }}</h4>
            <a href="#" class="btn btn-success">Proceed to Checkout</a>
        @else
            <p>Your cart is empty!</p>
        @endif
    </div>


    <div class="container">

        <div class="row">
            <div class="col-12 text-center mt-3 mb-5">
                <a href="#product">
                    <button type="submit" class="btn btn-info">continue shopping</button>
                </a>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-lg-12">
                <h3>The best products</h3>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row gy-5" id="product">
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
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <a href="{{ route('products.index') }}">
                    <button class="btn btn-info" type="submit">
                        view all
                    </button>
                </a>
            </div>
        </div>
    </div>
@endsection
