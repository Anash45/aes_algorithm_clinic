<?php
require_once './defines/functions.php';
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AES Algorithm Clinic</title>
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>

    <body>
                <?php include ('header.php'); ?>
        <?php include('navbar.php'); ?>
        <main>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>