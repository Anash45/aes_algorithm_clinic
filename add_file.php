<?php
require_once './defines/db_conn.php'; 
require_once './defines/functions.php'; 
if(!isLoggedIn()){
    header('location: login.php');
    die();
}
// Function to encrypt data using AES encryption algorithm
function encryptAES($data, $key)
{
    $method = 'aes-256-cbc';
    $ivLength = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encryptedData = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedData);
}

function uploadEncryptAndStoreFile($pdo, $file, $patientID)
{
    // Check file size
    $maxFileSize = 1000 * 1024; // 1000 KB (in bytes)
    if ($file['size'] > $maxFileSize) {
        return array(
            "success" => false,
            "data" => "File size exceeds the maximum limit of 500 KB."
        );
    }

    // Check allowed file types
    $allowedFileTypes = array("image/png", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "image/jpeg", "image/jpg");
    if (!in_array($file['type'], $allowedFileTypes)) {
        return array(
            "success" => false,
            "data" => "Only PNG, DOCX, PDF, JPEG, and JPG file types are allowed."
        );
    }

    // Check if a file with the same name, type, and patientID already exists
    $fileName = $file['name'];
    $fileType = $file['type'];
    $query = "SELECT COUNT(*) AS count FROM file WHERE F_Name = :name AND F_Type = :type AND patientID = :patientID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $fileName);
    $stmt->bindParam(':type', $fileType);
    $stmt->bindParam(':patientID', $patientID);
    $stmt->execute();
    $existingFileCount = $stmt->fetchColumn();

    if ($existingFileCount > 0) {
        // File with the same name, type, and patientID already exists
        return array(
            "success" => false,
            "data" => "A file with the same name, type, and patientID already exists."
        );
    }

    // Continue with file upload if no errors found

    // Read file contents
    $fileContent = file_get_contents($file['tmp_name']);

    $encryptionKey = sanitize($_POST['F_EncKey']);

    // Encrypt file contents
    $encryptedContent = encryptAES($fileContent, $encryptionKey);

    // Prepare INSERT query to store file metadata and content in the database
    $query = "INSERT INTO file (F_Name, F_Type, F_EncKey, F_Content, patientID) VALUES (:name, :type, :encKey, :content, :patientID)";

    // Execute INSERT query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':name', $fileName);
    $stmt->bindParam(':type', $fileType);
    $stmt->bindParam(':encKey', $encryptionKey);
    $stmt->bindParam(':content', $encryptedContent);
    $stmt->bindParam(':patientID', $patientID);
    $stmt->execute();

    // Return success message
    return array(
        "success" => true,
        "data" => array(
            "fileName" => $fileName,
            "fileType" => $fileType,
            "encryptionKey" => $encryptionKey,
            "patientID" => $patientID
        )
    );
}



$info = '';
// Check if form submitted with file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_FILES["uploaded_file"])) {
    // Example patientID
    $patientID = sanitize($_POST['patientID']);

    // Upload, encrypt, and store the file
    $result = uploadEncryptAndStoreFile($pdo, $_FILES["uploaded_file"], $patientID);
    if ($result['success']) {
        $info = '<p class="alert alert-success">File encrypted and stored successfully.</p>';
    } else {
        $info = '<p class="alert alert-danger">'.$result['data'].'</p>';
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
                <h2>Add File</h2>
            </div>
            <div class="box box-sml">
                <form action="" method="POST" class="w-full" enctype="multipart/form-data">
                    <?php echo $info; ?>
                    <div class="field">
                        <label class="f-label">Upload File:</label>
                        <input type="file" required name="uploaded_file" class="f-inp" accept=".png,.pdf,.jpg,.jpeg,.docx">
                        <p class="form-note">Only (.png, .pdf, .jpg, .jpeg, .docx) files accepted and should be less than 1 MB!</p>
                    </div>
                    <div class="field">
                        <label class="f-label">File Encryption Key:</label>
                        <input type="password" required name="F_EncKey" class="f-inp" placeholder="File's Encryption Key">
                    </div>
                    <div class="field">
                        <label class="f-label">Assign Patient:</label>
                        <select required name="patientID" class="f-inp">
                            <option value="" disabled selected>Select a patient</option>
                            <?php
                            $patients = getAllPatients($pdo);
                            if($patients['success']){
                                foreach ($patients['data'] as $patient) {
                                    echo '<option value="'.$patient['patientID'].'">'.$patient['P_Name'].'</option>';
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