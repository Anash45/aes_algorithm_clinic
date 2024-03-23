<?php
require_once './defines/functions.php'; // Include the file containing functions
if(!isLoggedIn()){
    header('location: login.php');
    die();
}elseif (!isAdmin()) {
    header('location: index.php');
    die();
}
$info = ""; // Initialize the info variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset ($_POST['D_Name']) && isset ($_POST['D_Number']) && isset ($_POST['D_Email']) && isset ($_POST['D_Password'])) {
        // Extract form data
        $data = array(
            'D_Name' => sanitize($_POST['D_Name']),
            'D_Number' => sanitize($_POST['D_Number']),
            'D_Email' => sanitize($_POST['D_Email']),
            'D_Password' => password_hash($_POST['D_Password'], PASSWORD_DEFAULT), // Hash the password
            // 'adminID' => 1
        );

        // Call the createDoctor function and store the response in the $info variable
        $result = createDoctor($pdo, $data);
        if ($result['success']) {
            $info = '<p class="alert alert-success">' . $result['data'] . '</p>';
        } else {
            $info = '<p class="alert alert-danger">' . $result['data'] . '</p>';
        }
    } else {
        $info = '<p class="alert alert-danger">All fields are required.</p>';
    }
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
        <?php include ('navbar.php'); ?>
        <main>
            <div class="title text-center">
                <h2>Add Doctor</h2>
            </div>
            <div class="box box-sml">
                <form action="" method="post" class="w-full" enctype="multipart/form-data">
                    <?php echo $info; ?>
                    <div class="field">
                        <label class="f-label">Doctor's Name:</label>
                        <input type="text" required name="D_Name" class="f-inp" placeholder="Doctor's Name">
                    </div>
                    <div class="field">
                        <label class="f-label">Doctor's Number:</label>
                        <input type="text" required name="D_Number" class="f-inp" placeholder="Doctor's Number">
                    </div>
                    <div class="field">
                        <label class="f-label">Doctor's Email:</label>
                        <input type="text" required name="D_Email" class="f-inp" placeholder="Doctor's Email">
                    </div>
                    <div class="field">
                        <label class="f-label">Doctor's Password:</label>
                        <input type="password" required name="D_Password" class="f-inp" placeholder="Doctor's Password">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn">Submit</button>
                    </div>
                </form>
            </div>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>