<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.2-dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css.css') }}">
     <!-- toaster style --}}-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    @yield('style')
</head>

<body>
    <!--Header-->
    <div class="container-fluid" style="background-color: #f3f3f3">
        <div class="row">
            <nav class="navbar navbar-expand-md navbar-light" style="background-color: #f3f3f3"">
                <div class="container justify-content-md-end">
                    <a class="navbar-brand" style="margin-left: -15px;">LOGO</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#minu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="minu">
                        <ul class="navbar-nav justify-content-lg-start ">
                            <form class="none_first">
                                <input type="text" placeholder="search" class="form-control">
                            </form>
                            <li class="nav-item"><a class="nav-link active"
                                    href="{{ route('products.index') }}">Home</a></li>
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('products.category', $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="nav-item"><a class="nav-link none_first none col-lg-0.5" href="cart.html">cart<i
                                        class="ms-1 fa-solid fa-bag-shopping"></i></a></li>
                        </ul>
                    </div>

                    <a data-bs-toggle="modal" data-bs-target="#myModal" class="none  text-dark" href="#input">
                        <i class="fa-solid fa-magnifying-glass me-5"></i>
                    </a>
                    <a class="none text-dark" href="{{route('cart.index')}}">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </a>
                    @if(\Illuminate\Support\Facades\Auth::guard('user')->Check())
                        <form method="GET" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline ms-5">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a class="none text-dark ms-5" href="{{ route('auth.login.show', ['guard' => 'user']) }}">
                            <i class="nav-icon fas fa-user-tie "></i>
                        </a>
                    @endif

                </div>
            </nav>
        </div>
    </div>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <form class="input input-m">
                        <input type="text" placeholder="search" class="form-control" id="input"></input>
                        <button type="button" class="btn btn-info model" data-bs-dismiss="modal">search</button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    @yield('content')

    <div class="container-fluid my-5">
        <footer class="text-center text-dark" style="background-color: #f3f3f3">
            <div class="text-center p-3" style="background-color: rgb(211 198 198 / 20%);">
                © 2023 Copyright:<a class="text-dark" href="#">Electronic Jony</a>
            </div>
        </footer>
    </div>
    <script src="{{ asset('assets/bootstrap-5.0.2-dist/js/bootstrap.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @yield('script')
</body>

</html>
