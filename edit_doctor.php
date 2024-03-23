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
    $id = sanitize($_GET['id']);
    // Check if form fields are set and not empty
    if (isset ($_POST['D_Name']) && isset ($_POST['D_Number']) && isset ($_POST['D_Email'])) {
        // Extract form data
        $data = array(
            'D_Name' => sanitize($_POST['D_Name']),
            'D_Number' => sanitize($_POST['D_Number']),
            'D_Email' => sanitize($_POST['D_Email']),
        );

        if (isset ($_POST['D_Password'])) {
            $data['D_Password'] = password_hash($_POST['D_Password'], PASSWORD_DEFAULT);
        }

        // Call the createDoctor function and store the response in the $info variable
        $result = updateDoctor($pdo, $id, $data);
        if ($result['success']) {
            $info = '<p class="alert alert-success">' . $result['data'] . '</p>';
        } else {
            $info = '<p class="alert alert-danger">' . $result['data'] . '</p>';
        }
    } else {
        $info = '<p class="alert alert-danger">Please fill up the required fields.</p>';
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
        <?php include('navbar.php'); ?>
        <main>
            <div class="title text-center">
                <h2>Edit Doctor</h2>
            </div>
            <div class="box box-sml">
                <?php
                if (isset ($_GET['id'])) {
                    $id = $_GET['id'];
                    $result = getDoctorById($pdo, $id);
                    if ($result['success']) {
                        ?>
                        <form action="?id=<?php echo $id; ?>" method="post" class="w-full" enctype="multipart/form-data">
                            <?php echo $info; ?>
                            <div class="field">
                                <label class="f-label">Doctor's Name:</label>
                                <input type="text" required value="<?php echo $result['data']['D_Name']; ?>" name="D_Name" class="f-inp" placeholder="Doctor's Name">
                            </div>
                            <div class="field">
                                <label class="f-label">Doctor's Number:</label>
                                <input type="text" required value="<?php echo $result['data']['D_Number']; ?>" name="D_Number" class="f-inp" placeholder="Doctor's Number">
                            </div>
                            <div class="field">
                                <label class="f-label">Doctor's Email:</label>
                                <input type="text" required value="<?php echo $result['data']['D_Email']; ?>" name="D_Email" class="f-inp" placeholder="Doctor's Email">
                            </div>
                            <div class="field">
                                <label class="f-label">Doctor's Password:</label>
                                <input type="password" name="D_Password" class="f-inp" placeholder="Doctor's Password">
                                <p class="form-note">Leave this field empty if don't want to change the password.</p>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn">Submit</button>
                            </div>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>