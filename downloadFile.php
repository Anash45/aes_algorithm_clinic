<?php
require_once './defines/db_conn.php'; // Include  database connection file here

// Handle form submission to view/download file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset ($_POST["fileID"]) && isset ($_POST["encryptionKey"])) {

    function decryptAES($data, $key)
    {
        $method = 'aes-256-cbc';
        $ivLength = openssl_cipher_iv_length($method);
        $encryptedData = base64_decode($data);
        $iv = substr($encryptedData, 0, $ivLength);
        $decryptedData = openssl_decrypt(substr($encryptedData, $ivLength), $method, $key, OPENSSL_RAW_DATA, $iv);
        return $decryptedData;
    }

    // Function to fetch and decrypt file content from the database
    function fetchAndDecryptFile($pdo, $fileID, $encryptionKey)
    {
        // Prepare SELECT query
        $query = "SELECT F_EncKey, F_Name, F_Type, F_Content FROM file WHERE FileID = :fileID";

        // Execute SELECT query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':fileID', $fileID);
        $stmt->execute();

        $fileData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fileData) {
            // Check if encryption key matches
            if ($fileData['F_EncKey'] == $encryptionKey) {
                // Decrypt file content
                $decryptedContent = decryptAES($fileData['F_Content'], $encryptionKey);
                return array(
                    "success" => true,
                    "data" => array(
                        "fileName" => $fileData['F_Name'],
                        "fileType" => $fileData['F_Type'],
                        "fileContent" => $decryptedContent
                    )
                );
            } else {
                return array("success" => false, "data" => "Invalid encryption key");
            }
        } else {
            return array("success" => false, "data" => "File not found");
        }
    }

    $fileID = $_POST["fileID"];
    $encryptionKey = $_POST["encryptionKey"];
    $result = fetchAndDecryptFile($pdo, $fileID, $encryptionKey);
    if ($result['success']) {
        // Output the decrypted content
        // For example, if it's an image, you can set appropriate headers and display it
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $result['data']['fileName'] . '"');
        echo $result['data']['fileContent'];
        exit; // Terminate the script after outputting the file content
    } else {
        echo "
        <style>
        .alert{
            padding: 12px;
            border: 1px solid #c0c0c0;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .alert-danger{
            background-color: #ffc9c9;
            border-color: #870000;
            color: #870000;
            font-weight: 500;
        }
        </style>";
        echo '<a href="files.php">Go to files</a>';
        // Failed to fetch or decrypt file
        echo '<p class="alert alert-danger">' . $result['data'] . '</p>';
    }
}
?>