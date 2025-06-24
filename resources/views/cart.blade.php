<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css.css">
</head>
<body>
<!--Header-->
<div class="container-fluid" style="background-color: #f3f3f3">
    <div class="row">
        <nav class="navbar navbar-expand-md navbar-light" style="background-color: #f3f3f3"">
        <div class="container justify-content-md-end">
            <a class="navbar-brand" style="margin-left: -15px;">LOGO</a>
            <button class="navbar-toggler" type="button"  data-bs-toggle="collapse" data-bs-target="#minu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="minu">
                <ul class="navbar-nav justify-content-lg-start ">
                    <form class="none_first">
                        <input type="text" placeholder="search" class="form-control">
                    </form>
                    <li class="nav-item"><a class="nav-link" href="Hom.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="Air_pods.html">Air pods</a></li>
                    <li class="nav-item"><a class="nav-link" href="smart.html">Smart Watch</a></li>
                    <li class="nav-item"><a class="nav-link none_first none col-lg-0.5" href="cart.html">cart<i class="ms-1 fa-solid fa-bag-shopping"></i></a></li>
                </ul>
            </div>

            <a data-bs-toggle="modal" data-bs-target="#myModal" class="none  text-dark" href="#input"><i class="fa-solid fa-magnifying-glass me-5"></i></a>
            <a class="none active" href="#"><i class="fa-solid fa-bag-shopping"></i></a>
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
                    <button type="button" class="btn btn-info model"  data-bs-dismiss="modal">search</button>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 mt-5">
            <h1 class="text-center">Your cart is empty</h1>
        </div>
    </div>

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
        <div class="col-lg-3 col-md-6 col-sm-12 mt-lg-5 mt-md-5">
            <a href="#" class="text-decoration-none mt-5">
                <div class="card">
                    <img src="photo/S5614e1fbe7e24e44aa0612710c2b7fc24.webp" class="card-img-top" width="822px" height="290px">
                    <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                    <div class="card-body">

                        <h5 class="card-title text-dark">Digital Watch</h5>
                        <p class="card-text text-dark"><del>$24.99 USD</del>&nbsp; &nbsp; $14.99 USD</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-5">
            <a href="#" class="text-decoration-none">
                <div class="card">
                    <img src="photo/Se0749721f8ed41e1bc2e323f4ffc7d4dR.webp" class="card-img-top" width="822px" height="290px">
                    <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                    <div class="card-body">
                        <h5 class="card-title text-dark">Elegance watch</h5>
                        <p class="card-text text-dark"><del>$105.99 USD</del>&nbsp; &nbsp; $63.99 USD</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-sm-5">
            <a href="#" class="text-decoration-none">
                <div class="card">
                    <img src="photo/daniel-korpai-hbTKIbuMmBI-unsplash.jpg" class="card-img-top" width="822px" height="290px">
                    <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                    <div class="card-body">
                        <h5 class="card-title text-dark">CanMix 2023</h5>
                        <p class="card-text text-dark"><del>$89.99 USD</del>&nbsp; &nbsp; $53.99 USD</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mt-sm-5">
            <a href="#" class="text-decoration-none">
                <div class="card">
                    <img src="photo/daniel-korpai-QhF3YGsDrYk-unsplash.jpg" class="card-img-top" width="822px" height="290px">
                    <span class="badge bg-danger w-25 card-img-overlay" style="height: 25px">Sale</span>
                    <div class="card-body">
                        <h5 class="card-title text-dark">Clock Men Fashion</h5>
                        <p class="card-text text-dark">$14.99 USD</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-5 text-center">
            <a href="Hom.html">
                <button class="btn btn-info" type="submit">
                   view all
                </button>
            </a>
        </div>
    </div>
</div>


<div class="container-fluid my-5">
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
                    div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <h3>Titel titel</h3>
                        <p>
                            The Cupertino-based company is reportedly launching an online store in the world’s second-
                            largest smartphone market later this month The Cupertino-based company is reportedly
                            launching an online store in the world’s second-largest smartphone market later this month.
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <h3>Titel titel</h3>
                        <p>
                            The Cupertino-based company is reportedly launching an online store in the world’s second-
                            largest smartphone market later this month The Cupertino-based company is reportedly
                            launching an online store in the world’s second-largest smartphone market later this month.
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
            © 2023 Copyright:<a class="text-dark" href="#">Electronic Jony</a>
        </div>

    </footer>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.js"></script>
</body>
</html>