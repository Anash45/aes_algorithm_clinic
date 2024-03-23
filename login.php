<?php
// Include database connection file
require_once './defines/db_conn.php';
require_once './defines/functions.php';
$info = '';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = sanitize($_POST["Email"]);
    $password = sanitize($_POST["Password"]);
    $role = sanitize($_POST["role"]); // Assuming the select element's name is 'doctorID'
    
    // Prepare and execute the query to fetch user data
    if ($role == 'Admin') {
        $query = "SELECT * FROM admin WHERE A_Email = :email";
        $idField = 'adminID'; // Set the ID field for the admin table
        $passwordField = 'A_Password'; // Set the password field for the admin table
        $nameField = 'A_Name'; // Set the name field for the admin table
    } else {
        $query = "SELECT * FROM doctor WHERE D_Email = :email";
        $idField = 'DoctorID'; // Set the ID field for the doctor table
        $passwordField = 'D_Password'; // Set the password field for the doctor table
        $nameField = 'D_Name'; // Set the name field for the doctor table
    }

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user credentials
    if ($user && password_verify($password, $user[$passwordField])) { // Compare password using the appropriate field
        // Set session variables
        $_SESSION['ID'] = $user[$idField];
        $_SESSION['Name'] = $user[$nameField]; // Set name using the appropriate field
        $_SESSION['Role'] = $role;

        // Redirect to index.php
        header("Location: index.php");
        exit();
    } else {
        // Authentication failed, redirect back to login page with error message
        $info = '<p class="alert alert-danger">Incorrect Email or Password.</p>';
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

    <body class="only-main">
        <main>
            <div class="title text-center">
                <h2>Login</h2>
            </div>
            <div class="box box-sml">
                <?php echo $info; ?>
                <form action="" method="POST" class="w-full" enctype="multipart/form-data">
                    <div class="field">
                        <label class="f-label">Email:</label>
                        <input type="email" required name="Email" class="f-inp" placeholder="Your e-mail address">
                    </div>
                    <div class="field">
                        <label class="f-label">Password:</label>
                        <input type="password" required name="Password" class="f-inp" placeholder="Your password">
                    </div>
                    <div class="field">
                        <label class="f-label">Logging in as:</label>
                        <select required name="role" class="f-inp">
                            <option value="" selected disabled>Select a role</option>
                            <option value="Admin">Admin</option>
                            <option value="Doctor">Doctor</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
            </div>
        </main>
    </body>
    <script src="./assets/js/script.js"></script>

</html>