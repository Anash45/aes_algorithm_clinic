<?php
require_once './defines/functions.php';
if (!isLoggedIn()) {
    header('location: login.php');
    die();
}
$counts = getCounts($pdo);
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
        <?php include ('navbar.php'); ?>
        <main>
            <div class="title text-center">
                <h2>Dashboard</h2>
            </div>
            <div class="cards-flex">
                <div class="card-cont">
                    <div class="card card-red">
                        <h2><?php echo $counts['doctorCount']; ?></h2>
                        <h5>Doctors</h5>
                    </div>
                </div>
                <div class="card-cont">
                    <div class="card card-blue">
                        <h2><?php echo $counts['patientCount']; ?></h2>
                        <h5>Patients</h5>
                    </div>
                </div>
                <div class="card-cont">
                    <div class="card card-darkblue">
                        <h2><?php echo $counts['fileCount']; ?></h2>
                        <h5>Files</h5>
                    </div>
                </div>
            </div>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>