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
    <link rel=”stylesheet” href=”CSS/bootstrap-responsive.css”>

    <title>Mind - Setter</title>
</head>
<body>

<!--<h1>Home</h1>-->

<?php //if (isset($_SESSION["user_id"])):?>

<?php if (isset($user)): ?>

    <?php include "studentprofile.html";?>


<?php else: ?>

<!--    <p><a href="login.php">Log in</a> or <a href="singup.html">sign up</a></p>-->


<?php include "component/navigazion.php";?> 
<?php include "component/howWork.php"; ?> 
<?php include "component/grades.php"; ?> 


<div class="carousel-inner py-5" style="    background: #343333;">
  <div class="cardhead px-4">
    <h3  style="font-size: 4.5vw;">Grades we teach</h3><br></div>
  <!-- Single item -->
  <div class="carousel-item active">
    
    <div class="container" style="color: black;">
      <div class="row">
        <div class="col-lg-3">
          <div class="card">
          <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/181.webp" class="card-img-top" alt="Waterfall"/>
            <div class="card-body">
              <h5 class="card-title" style="text-align: center;">Lara De Mel</h5>
              <p class="card-text" style="text-align: center;">
                Some quick example text to build on the card title and make up the bulk
                of the card's content.
              </p>
              
            </div>
          </div>
          
        </div>
        <div class="col-lg-3">
          <div class="card">
            <img
              src="https://mdbcdn.b-cdn.net/img/new/standard/nature/181.webp"
              class="card-img-top"
              alt="Waterfall"
            />
            <div class="card-body">
              <h5 class="card-title" style="text-align: center;">Card title</h5>
              <p class="card-text" style="text-align: center;">
                Some quick example text to build on the card title and make up the bulk
                of the card's content.
              </p>
              
            </div>
          </div>
          
        </div>
        <div class="col-lg-3">
          <div class="card">
            <img
              src="https://mdbcdn.b-cdn.net/img/new/standard/nature/181.webp"
              class="card-img-top"
              alt="Waterfall"
            />
            <div class="card-body">
              <h5 class="card-title" style="text-align: center;">Card title</h5>
              <p class="card-text" style="text-align: center;">
                Some quick example text to build on the card title and make up the bulk
                of the card's content.
              </p>
              
            </div>
          </div>
          
        </div>
        <div class="col-lg-3">
          <div class="card">
            <img
              src="https://mdbcdn.b-cdn.net/img/new/standard/nature/181.webp"
              class="card-img-top"
              alt="Waterfall"
            />
            <div class="card-body">
              <h5 class="card-title" style="text-align: center;">Card title</h5>
              <p class="card-text" style="text-align: center;">
                Some quick example text to build on the card title and make up the bulk
                of the card's content.
              </p>
              
            </div>
          </div>
          
        </div>
        

        
        
        
        
      </div>
    </div>
  </div>

 
<!-- Inner -->
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

