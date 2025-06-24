<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css.css') }}">
</head>

<body>
    <!--Header-->
    <div class="container-fluid" style="background-color: #f3f3f3">
        <div class="row">
            <nav class="navbar navbar-expand-md navbar-light" style="background-color: #f3f3f3">
                <div class="container justify-content-md-end">
                    <a class="navbar-brand" style="margin-left: -15px;">LOGO</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#minu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="minu">
                        <ul class="navbar-nav justify-content-lg-start ">

                            <input type="text" placeholder="search" class="form-control none_first">

                            <li class="nav-item"><a class="nav-link " href="Hom.html">Home</a></li>
                            <li class="nav-item"><a class="nav-link " href="Air_pods.html">Air pods</a></li>
                            <li class="nav-item"><a class="nav-link  active" href="smart.html">Smart Watch</a></li>
                            <li class="nav-item"><a class="nav-link none_first none col-lg-0.5" href="cart.html">cart<i
                                        class="ms-1 fa-solid fa-bag-shopping"></i></a></li>
                        </ul>
                    </div>

                    <a data-bs-toggle="modal" data-bs-target="#myModal" class="none  text-dark" href="#input"><i
                            class="fa-solid fa-magnifying-glass me-5"></i></a>
                    <a class="none text-dark" href="cart.html"><i class="fa-solid fa-bag-shopping"></i></a>
                </div>
            </nav>
        </div>
    </div>

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
                        <button class="btn btn-light mt-5 w-75" style="border: 1px solid black">Add to cart</button>
                    </div>
                    <div>
                        <button class="btn btn-info mt-2 w-75">Bay it now</button>
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
                            <img src="{{ asset('storage/' . $product_item->images->first()->image_url) }}"
                                class="card-img-top" width="822px" height="290px" alt="no product">
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

    <div class="container-fluid my-5 p-0">
        <footer class="text-center text-dark" style="background-color: #f3f3f3">
            <div class="container">
                <section class="mt-5">

                    <div class="row pt-5">

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <p class="text-uppercase">
                                <a href="About_Us.html" class="text-dark text-decoration-none nav-link">About us</a>
                            </p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <p class="text-uppercase">
                                <a href="Contact.html" class="text-dark text-decoration-none nav-link">Contact</a>
                            </p>
                        </div>

                    </div>
                </section>

                <hr class="my-5" />


                <section class="mb-5">
                    <div class="row d-flex justify-content-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-6">
                                <h3>Titel titel</h3>
                                <p>
                                    The Cupertino-based company is reportedly launching an online store in the world’s
                                    second-
                                    largest smartphone market later this month The Cupertino-based company is reportedly
                                    launching an online store in the world’s second-largest smartphone market later this
                                    month.
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <h3>Titel titel</h3>
                                <p>
                                    The Cupertino-based company is reportedly launching an online store in the world’s
                                    second-
                                    largest smartphone market later this month The Cupertino-based company is reportedly
                                    launching an online store in the world’s second-largest smartphone market later this
                                    month.
                                </p>
                            </div>
                        </div>
                </section>

                <section class="text-center mb-5">
                    <a href="" class="text-dark me-4 text-decoration-none">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="" class="text-dark me-4  text-decoration-none">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="" class="text-dark me-4  text-decoration-none">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="" class="text-dark me-4  text-decoration-none">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="" class="text-dark me-4  text-decoration-none">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                </section>
            </div>

            <div class="text-center p-3" style="background-color: rgb(211 198 198 / 20%);">
                © 2023 Copyright:<a class="text-dark" href="Hom.html">Electronic</a>
            </div>

        </footer>
    </div>

</body>

</html>
