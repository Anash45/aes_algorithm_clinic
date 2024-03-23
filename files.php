<?php
require_once './defines/db_conn.php'; // Include  database connection file here
require_once './defines/functions.php';
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
// Function to decrypt data using AES encryption algorithm
$info = '';
if(isset($_GET['delete'])){
    $id = sanitize($_GET['delete']);
    $delete = deleteFileByID($pdo, $id);
    if($delete['success']){
        $info = '<p class="alert alert-success">'.$delete['data'].'</p>';
    }else{
        $info = '<p class="alert alert-danger">'.$delete['data'].'</p>';
    }
}

// Fetch all files from the database
$query = "SELECT file.FileID, file.F_Name, file.F_Type, patient.P_Name 
          FROM file
          INNER JOIN patient ON file.patientID = patient.patientID";
$stmt = $pdo->query($query);
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <h2>Files</h2>
            </div>
            <div class="box">
                <?php echo $info; ?>
                <table>
                    <thead>
                        <tr>
                            <th>File ID</th>
                            <th>Patient</th>
                            <th>File Name</th>
                            <th>File Type</th>
                            <th>Download</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td>
                                    <?php echo $file['FileID']; ?>
                                </td>
                                <td>
                                    <?php echo $file['P_Name']; ?>
                                </td>
                                <td>
                                    <?php echo $file['F_Name']; ?>
                                </td>
                                <td>
                                    <?php echo $file['F_Type']; ?>
                                </td>
                                <td>
                                    <form action="downloadFile.php" method="post">
                                        <input type="hidden" name="fileID" value="<?php echo $file['FileID']; ?>">
                                        <input type="password" name="encryptionKey" class="f-inp" placeholder="Enter Encryption Key">
                                        <button type="submit" class="btn btn-submit btn-dnld">Download</button>
                                    </form>
                                </td>
                                <td>
                                    <a class="btn delete-btn" href="?delete=<?php echo $file['FileID'] ?>" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include ('footer.php'); ?>
    </body>
    <script src="./assets/js/script.js"></script>

</html>