<?php
require_once './defines/functions.php'; // Include the file containing functions
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
$info = ""; // Initialize the info variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (isset ($_POST['P_Name']) && isset ($_POST['P_Number']) && isset ($_POST['P_Age']) && isset ($_POST['doctorID'])) {
        // Extract form data
        $data = array(
            'P_Name' => sanitize($_POST['P_Name']),
            'P_Number' => sanitize($_POST['P_Number']),
            'P_Age' => sanitize($_POST['P_Age']),
            'doctorID' => sanitize($_POST['doctorID']),
        );

        // Call the createPatient function and store the response in the $info variable
        $result = createPatient($pdo, $data);
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
        <?php include('navbar.php'); ?>
        <main>
            <div class="title text-center">
                <h2>Add Patient</h2>
            </div>
            <div class="box box-sml">
                <form action="" method="POST" class="w-full" enctype="multipart/form-data">
                    <?php echo $info; ?>
                    <div class="field">
                        <label class="f-label">Patient's Name:</label>
                        <input type="text" required name="P_Name" class="f-inp" placeholder="Patient's Name">
                    </div>
                    <div class="field">
                        <label class="f-label">Patient's Number:</label>
                        <input type="text" required name="P_Number" class="f-inp" placeholder="Patient's Number">
                    </div>
                    <div class="field">
                        <label class="f-label">Patient's Age:</label>
                        <input type="number" required name="P_Age" class="f-inp" placeholder="Patient's Age">
                    </div>
                    <div class="field">
                        <label class="f-label">Assign Doctor:</label>
                        <select required name="doctorID" class="f-inp">
                            <option value="" disabled selected>Select a doctor</option>
                            <?php
                            $doctors = getAllDoctors($pdo);
                            if($doctors['success']){
                                foreach ($doctors['data'] as $doctor) {
                                    echo '<option value="'.$doctor['DoctorID'].'">'.$doctor['D_Name'].'</option>';
                                }
                            }
                            ?>
                        </select>
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