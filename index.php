<?php

session_start();
//print_r($_SESSION);

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
          crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400&family=Marvel:wght@700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="CSS/newstyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300&family=Marvel:wght@700&display=swap"
          rel="stylesheet">
    <link rel=”stylesheet” href=”css/bootstrap-responsive.css”>

    <title>Mind - Setter</title>
</head>
<body>

<!--<h1>Home</h1>-->

<?php //if (isset($_SESSION["user_id"])):?>

<?php if (isset($user)): ?>

    <p>Hello <?= htmlspecialchars($user["name"]) ?></p>

    <p>You are logged in.</p>

    <p><a href="logout.php">Log out</a></p>


<?php else: ?>

<!--    <p><a href="login.php">Log in</a> or <a href="singup.html">sign up</a></p>-->

<div class="row">
    <nav class="navbar navbar-expand-lg bg-light shadow">

        <img src="Assets/Logo.png" alt="brand image" width="7%" style="position: relative;left: 15px;">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

            <ul class="navbar-nav ms-auto p-3 ">
                <li class="nav-item">
                    <a href="index.html" class="nav-link m-3 " style="color:#0ABE9E"> Home </a>
                </li>

                <li class="nav-item">
                    <a href="#About US" class="nav-link m-3" style="color:#0ABE9E"> About Us </a>
                </li>

                <li class="nav-item">
                    <a href="#FAQ" class="nav-link m-3" style="color:#0ABE9E"> FAQ </a>
                </li>

                <li class="nav-item">
                    <button class="btn btn-outline-success m-3" style="font-size: 24px;" type="submit"
                            onclick="location.href='login.php'">Login
                    </button>
                </li>

                <li class="nav-item">
                    <button class="btn btn-outline-success m-3" style="font-size: 24px;" type="submit"
                            onclick="location.href='singup.html'">Sign Up
                    </button>
                </li>

            </ul>

        </div>
    </nav>
</div>
<div class="row">

    <div class="container-xxl">
        <div class="text1 p-5" style="font-size:4vw;">
            How our website works
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner" style="text-align: center; padding: 30px;">
                <div class="carousel-item active">
                    <img src="Assets/SliderImage1.png" class="testimonial-image" alt="Slider image 1" height="ms-auto"
                         width="60%">
                </div>

                <div class="carousel-item">
                    <img src="Assets/SliderImage2.png" class="testimonial-image" alt="Slider Image 2" height="ms-auto"
                         width="60%">
                </div>

                <div class="carousel-item">
                    <img src="Assets/SliderImage3.png" class="testimonial-image" alt="Slider Image 3" height="ms-auto"
                         width="60%">
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    </div>
</div>

<div class="row">
    <div class="container-xl p-5 ">
        <div class="textH" style="font-size:4vw;">Grades we teach<br><br></div>


        <div class="d-grid gap-1" style="position: relative;left: 130px;">
            <div class="button1 ">
                <button class="btn1 btn-primary btn-lg m-2  " type="button">Grade - 10</button>
                <button class="btn1 btn-primary btn-lg  " type="button">Grade - 11</button>
            </div>
            <div class="button1">
                <button class="btn1 btn-primary btn-lg m-2 " type="button">Grade - 12</button>
                <button class="btn1 btn-primary btn-lg " type="button">Grade - 13</button>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="container-xlll p-5 ">
        <div class="textH" style="font-size:4vw;">Our Teachers<br><br></div>
        <div class="row row-cols-1 row-cols-md-4 g-5">
            <div class="col">
                <div class="card h-100">
                    <img src="Assets/Teacher1.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="Assets/Teacher2.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a short card.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="Assets/Teacher1.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="Assets/Teacher2.png" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>



    <?php endif; ?>



<?php //if (isset($user)): ?>
<!---->
<!--    <p>Hello --><?php //= htmlspecialchars($user["name"]) ?><!--</p>-->
<!---->
<!--    <p><a href="logout.php">Log out</a></p>-->
<!---->
<?php //else: ?>
<!---->
<!--    <p><a href="login.php">Log in</a> or <a href="singup.html">sign up</a></p>-->
<!---->
<?php //endif; ?>

</body>
</html>
