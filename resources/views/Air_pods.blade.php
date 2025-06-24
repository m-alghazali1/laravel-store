@extends('parents.home')
@section('content')
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-lg-12">
                <h1>Air pods</h1>
            </div>
        </div>
    </div>
      <div class="container">
        <div class="row gy-5">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-5 mt-md-5">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none mt-5">
                        <div class="card">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" class="card-img-top"
                                    width="822px" height="290px">
                            @else
                                <img src="" class="card-img-top" width="822px" height="290px">
                            @endif
                            @if ($product->old_price)
                                <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                            @endif
                            <div class="card-body">

                                <h5 class="card-title text-dark">{{ $product->name }}</h5>
                                <p class="card-text text-dark">
                                    @if ($product->old_price)
                                        <del>${{ $product->old_price }}</del>&nbsp; &nbsp;
                                    @endif
                                    ${{ $product->price }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
@endsection
