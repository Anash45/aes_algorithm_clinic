<?php
require_once './defines/functions.php'; // Include the file containing functions
if(!isLoggedIn()){
    header('location: login.php');
    die();
}elseif (!isAdmin()) {
    header('location: index.php');
    die();
}
$info = '';
if(isset($_GET['delete'])){
    $id = sanitize($_GET['delete']);
    $delete = deleteDoctorByID($pdo, $id);
    if($delete['success']){
        $info = '<p class="alert alert-success">'.$delete['data'].'</p>';
    }else{
        $info = '<p class="alert alert-danger">'.$delete['data'].'</p>';
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
                <h2>Doctors</h2>
            </div>
            <div class="box">
                <?php echo $info; ?>
                <table>
                    <thead>
                        <tr>
                            <th>Doctor ID</th>
                            <th>Doctor Name</th>
                            <th>Doctor Number</th>
                            <th>Doctor Email</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all doctors
                        $result = getAllDoctors($pdo);

                        // Check if any doctors are found
                        if ($result['success']) {
                            $doctors = $result['data'];

                            // Loop through each doctor and display in row format
                            foreach ($doctors as $doctor) {
                                echo '<tr>';
                                echo '<td>' . $doctor['DoctorID'] . '</td>';
                                echo '<td>' . $doctor['D_Name'] . '</td>';
                                echo '<td>' . $doctor['D_Number'] . '</td>';
                                echo '<td>' . $doctor['D_Email'] . '</td>';
                                echo '<td><a href="edit_doctor.php?id=' . $doctor['DoctorID'] . '" class="btn">Edit</a></td>';
                                echo '<td><a href="?delete=' . $doctor['DoctorID'] . '" class="btn delete-btn" onclick="return confirm(\'Are you sure to delete this?\');">Delete</a></td>';
                                echo '</tr>';
                            }
                        } else {
                            // If no doctors found, display a message
                            echo '<tr><td colspan="6">No doctors found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>