<?php
require_once './defines/functions.php'; // Include the file containing functions
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
$info = ""; // Initialize the info variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = sanitize($_GET['id']);
    // Check if form fields are set and not empty
    if (isset ($_POST['P_Name']) && isset ($_POST['P_Number']) && isset ($_POST['P_Age']) && isset ($_POST['doctorID'])) {
        // Extract form data
        $data = array(
            'P_Name' => sanitize($_POST['P_Name']),
            'P_Number' => sanitize($_POST['P_Number']),
            'P_Age' => sanitize($_POST['P_Age']),
            'doctorID' => sanitize($_POST['doctorID']),
        );

        // Call the updatePatient function and store the response in the $info variable
        $result = updatePatient($pdo, $id, $data);
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
                    $result = getPatientById($pdo, $id);
                    if ($result['success']) {
                        ?>
                        <form action="?id=<?php echo $id; ?>" method="POST" class="w-full" enctype="multipart/form-data">
                            <?php echo $info; ?>
                            <div class="field">
                                <label class="f-label">Patient's Name:</label>
                                <input type="text" required value="<?php echo $result['data']['P_Name'] ?>" name="P_Name"
                                    class="f-inp" placeholder="Patient's Name">
                            </div>
                            <div class="field">
                                <label class="f-label">Patient's Number:</label>
                                <input type="text" required value="<?php echo $result['data']['P_Number'] ?>" name="P_Number"
                                    class="f-inp" placeholder="Patient's Number">
                            </div>
                            <div class="field">
                                <label class="f-label">Patient's Age:</label>
                                <input type="number" required value="<?php echo $result['data']['P_Age'] ?>" name="P_Age"
                                    class="f-inp" placeholder="Patient's Age">
                            </div>
                            <div class="field">
                                <label class="f-label">Assign Doctor:</label>
                                <select required name="doctorID" class="f-inp">
                                    <option value="" disabled selected>Select a doctor</option>
                                    <?php
                                    $doctors = getAllDoctors($pdo);
                                    if ($doctors['success']) {
                                        foreach ($doctors['data'] as $doctor) {
                                            $selected = ($doctor['DoctorID'] === $result['data']['doctorID']) ? 'selected' : '' ;
                                            echo '<option value="' . $doctor['DoctorID'] . '" '.$selected.'>' . $doctor['D_Name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
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