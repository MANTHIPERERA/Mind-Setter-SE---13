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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

<h1>Home</h1>

<?php //if (isset($_SESSION["user_id"])):?>

<?php if (isset($user)): ?>

    <p>Hello <?= htmlspecialchars($user["name"]) ?></p>

    <p>You are logged in.</p>

    <p><a href="logout.php">Log out</a></p>


<?php else: ?>

    <p><a href="login.php">Log in</a> or <a href="singup.html">sign up</a></p>

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
