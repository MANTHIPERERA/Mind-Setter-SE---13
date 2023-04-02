<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
        $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

//    var_dump($user);
//    exit;

    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])) {

//            die("Log sss");

            session_start();

            session_regenerate_id();

          $_SESSION["user_id"] = $user["id"];

//           $sql="select * from userdetail where user_id=1";
//            $result1 = $mysqli->query($sql);
//            $catAllow=false;
//            while($row=mysqli_fetch_array($result1)){
//               $_SESSION['cat_id']=$row['cat_id'];
//               $catAllow=true;
//            }
//
//            if($catAllow){
//                echo 'dashboard';
//             header("Location: index.php");
//
//            }
//            else{
//                echo 'quiz';
//                header("Location: onboardquestions.html");
//            }

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;

}

?>


<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400&family=Marvel:wght@700&display=swap" rel="stylesheet">
    <link rel = "stylesheet" href="CSS/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300&family=Marvel:wght@700&display=swap" rel="stylesheet">
    <link rel=”stylesheet” href=”css/bootstrap-responsive.css”>

    <title>Mind - Setter</title>
</head>
<body>

<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="Assets/login_image.png"
                     class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                <?php if ($is_invalid): ?>
                    <em>Invalid login</em>
                <?php endif; ?>

                <form method="post">
                    <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                        <p class="lead fw-bold mb-0 me-3">Log In</p>

                    </div>

                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-normal mx-3 mb-0">Please fill in your details to access to your account</p>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Email address</label>
                        <input type="email" id="email" name="email" class="form-control form-control-lg"
                               value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"
                               placeholder="Enter a valid email address" />

                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example4">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-lg"
                               placeholder="Enter password" />

                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                                Remember me
                            </label>
                        </div>
                        <a href="ForgotPW1.html" class="text-body">Forgot password?</a>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg"
                                style="padding-left: 6.1rem; padding-right: 6.2rem;">Login</button><br><br>
                        <button type="button" class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Sign in with google</button>

                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="singup.html"
                                                                                          class="link-danger"style=" color:#0FE8C1;">Sign Up</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>
