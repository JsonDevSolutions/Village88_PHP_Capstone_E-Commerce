<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!--Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;500;900&display=swap" rel="stylesheet">
    <!--Jquery library-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- bootstrap library-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- font awesome library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- main style -->
    <link rel="stylesheet/less" type="text/css" href="../Assets/style/home.less">
    <link rel="stylesheet/less" type="text/css" href="../Assets/style/navigation.less">
    <!-- less library -->
    <script src="https://cdn.jsdelivr.net/npm/less@4" ></script>
    <!-- fortorama library -->
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
    
</head>
<body>
    <!---------------------Navigation-------------------->
    <nav class="container">
        <div class="row w-100 align-items-center p-2 top-nav navbar fixed-top">
            <div class="col col-12 col-md-3 col-lg-2 col-xl-5">
                <a href="" class="slick">Slick<span class="tech glow">TECH</span></a>
            </div>

            <div class="col-12 col-md-9 col-lg-10 col-xl-3">
                <input type="search" class="form-control w-100" placeholder="Search For Product" aria-label="" aria-describedby="button-addon1">
            </div>

            <div class="col-auto col-lg-1 text-center">
                <a href="home.html" class="text-light w-100">HOME</a>
            </div>

            <div class="col-auto col-lg-1 text-center">
                <a href="catalog.html" class="text-light w-100">CATALOG</a>
            </div>

            <div class="col-auto col-lg-1 text-center align-items-center dropdown">
                <a class="dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Michael Choi
                </a>
                <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="../Users/Profile.html"><i class="fas fa-user-alt"></i>Edit Profile</button></a></li>
                <li><a class="dropdown-item" href="../Users/login.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
            
            <div class="col-auto col-lg-1 mt-1 text-center">
                <a href="cart.html" class="text-light w-100 cart"><i class="fas fa-shopping-cart"></i><div class="cart-count ">12</div></a>
            </div>

        </div>
    </nav>
    <!-------------------Carousel------------------->
    <div class="slider">
        <div class="fotorama" data-width="100%" data-autoplay="2000">
            <img src="../Assets/img/slide1.jpg">
            <img src="../Assets/img/slide1.jpg">
            <img src="../Assets/img/slide1.jpg">
            <img src="../Assets/img/slide1.jpg">
        </div>
    </div>
    <!---------------------------------------------->
    <!-------------------Products-------------------------------------------------------------------->
    <h1 class="text-center text-light mt-1">Featured Products</h1>
    
    <div class="container w-100">
        <ul class="row align-items-center">
            <li class="col-6 col-md-3 mt-5">
                <div class="item-card">
                    <div class="img_container">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZHVjdHxlbnwwfHwwfHw%3D&w=1000&q=80" alt="mouse">
                    </div>
                    <a href="<?= base_url('products/show_product/5') ?>" class="d-block text-decoration-none">Keyboard</a>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <p>Price: $1000</p>
                </div>
            </li>
        </ul>
    </div>
    <!------------------------------------------------------------------------------------------------>
    <a href="<?= base_url('products/show_all') ?>" class="show_all">Show all products</a>

</body>
</html>