<?php
require_once './defines/functions.php'; // Include the file containing functions
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
$info = '';
if (isset ($_GET['delete'])) {
    $id = sanitize($_GET['delete']);
    $delete = deletePatientByID($pdo, $id);
    if ($delete['success']) {
        $info = '<p class="alert alert-success">' . $delete['data'] . '</p>';
    } else {
        $info = '<p class="alert alert-danger">' . $delete['data'] . '</p>';
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
                <h2>Patients</h2>
            </div>
            <div class="box">
                <?php echo $info; ?>
                <input type="text" placeholder="Search..." class="f-inp s-inp" id="search">
                <table id="result-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Patient Number</th>
                            <th>Assigned Doctor</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all patients
                        $result = getAllPatients($pdo);

                        // Check if any patients are found
                        if ($result['success']) {
                            $patients = $result['data'];

                            // Loop through each doctor and display in row format
                            foreach ($patients as $patient) {
                                echo '<tr>';
                                echo '<td>' . $patient['patientID'] . '</td>';
                                echo '<td>' . $patient['P_Name'] . '</td>';
                                echo '<td>' . $patient['P_Number'] . '</td>';
                                echo '<td>' . $patient['P_Age'] . '</td>';
                                echo '<td><a href="edit_patient.php?id=' . $patient['patientID'] . '" class="btn">Edit</a></td>';
                                echo '<td><a href="?delete=' . $patient['patientID'] . '" class="btn delete-btn" onclick="return confirm(\'Are you sure to delete this?\');">Delete</a></td>';
                                echo '</tr>';
                            }
                        } else {
                            // If no patients found, display a message
                            echo '<tr><td colspan="6">No patients found</td></tr>';
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