<?php
session_start();
require_once 'db_conn.php'; // Include  database connection file here

// Function to create an admin
function createAdmin($pdo, $data)
{
    // Check if email already exists
    $email = $data['A_Email'];
    $query = "SELECT COUNT(*) AS count FROM admin WHERE A_Email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        return array("success" => false, "data" => "Email already exists");
    }

    // Prepare INSERT query
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $query = "INSERT INTO admin ($fields) VALUES ($placeholders)";

    // Execute INSERT query
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Admin created successfully");
    } else {
        return array("success" => false, "data" => "Failed to create admin");
    }
}

// Function to update an admin
function updateAdmin($pdo, $id, $data)
{
    // Prepare UPDATE query
    $fields = '';
    foreach ($data as $key => $value) {
        $fields .= "$key = :$key, ";
    }
    $fields = rtrim($fields, ', ');

    $query = "UPDATE admin SET $fields WHERE adminID = :id";

    // Execute UPDATE query
    $stmt = $pdo->prepare($query);
    $data['id'] = $id;
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Admin updated successfully");
    } else {
        return array("success" => false, "data" => "Failed to update admin");
    }
}

// Function to get admin by ID
function getAdminById($pdo, $id)
{
    // Prepare SELECT query
    $query = "SELECT * FROM admin WHERE adminID = :id";

    // Execute SELECT query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        return array("success" => true, "data" => $admin);
    } else {
        return array("success" => false, "data" => "Admin not found");
    }
}

// Function to get all admins
function getAllAdmins($pdo)
{
    // Prepare SELECT query
    $query = "SELECT * FROM admin";

    // Execute SELECT query
    $stmt = $pdo->query($query);
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($admins) {
        return array("success" => true, "data" => $admins);
    } else {
        return array("success" => false, "data" => "No admins found");
    }
}

// Function to create a doctor
function createDoctor($pdo, $data)
{
    // Check if email already exists
    $email = $data['D_Email'];
    $number = $data['D_Number'];
    $query = "SELECT COUNT(*) AS count FROM doctor WHERE D_Email = :email OR D_Number = :number";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':number', $number);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        return array("success" => false, "data" => "Email or Doctor Number already exists");
    }

    // Prepare INSERT query
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $query = "INSERT INTO doctor ($fields) VALUES ($placeholders)";

    // Execute INSERT query
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Doctor created successfully");
    } else {
        return array("success" => false, "data" => "Failed to create doctor");
    }
}

// Function to update a doctor
function updateDoctor($pdo, $id, $data)
{
    // Prepare UPDATE query
    $fields = '';
    foreach ($data as $key => $value) {
        $fields .= "$key = :$key, ";
    }
    $fields = rtrim($fields, ', ');

    $email = $data['D_Email'];
    $number = $data['D_Number'];
    $query1 = "SELECT COUNT(*) AS count FROM doctor WHERE (D_Email = :email OR D_Number = :number ) AND DoctorID != :id";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(':id', $id);
    $stmt1->bindParam(':number', $number);
    $stmt1->bindParam(':email', $email);

    $stmt1->execute();
    $result = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        return array("success" => false, "data" => "Email already exists");
    }

    $query = "UPDATE doctor SET $fields WHERE DoctorID = :id";

    // Execute UPDATE query
    $stmt = $pdo->prepare($query);
    $data['id'] = $id;
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Doctor updated successfully");
    } else {
        return array("success" => false, "data" => "Failed to update doctor");
    }
}

// Function to get doctor by ID
function getDoctorById($pdo, $id)
{
    // Prepare SELECT query
    $query = "SELECT * FROM doctor WHERE DoctorID = :id";

    // Execute SELECT query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($doctor) {
        return array("success" => true, "data" => $doctor);
    } else {
        return array("success" => false, "data" => "Doctor not found");
    }
}

// Function to get all doctors
function getAllDoctors($pdo)
{
    // Prepare SELECT query
    $query = "SELECT * FROM doctor";

    // Execute SELECT query
    $stmt = $pdo->query($query);
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($doctors) {
        return array("success" => true, "data" => $doctors);
    } else {
        return array("success" => false, "data" => "No doctors found");
    }
}
// Function to delete doctor by ID
function deleteDoctorByID($pdo, $id)
{
    // Prepare DELETE query
    $query = "DELETE FROM doctor WHERE DoctorID = :id";

    // Execute DELETE query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $success = $stmt->execute();

    if ($success) {
        return array("success" => true, "data" => "Doctor deleted successfully");
    } else {
        return array("success" => false, "data" => "Failed to delete doctor");
    }
}
// Function to create a patient
function createPatient($pdo, $data)
{
    // Prepare INSERT query
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $number = $data['P_Number'];
    $query = "SELECT COUNT(*) AS count FROM patient WHERE P_Number = :number";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':number', $number);

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        return array("success" => false, "data" => "Patient Number already exists");
    }
    $query = "INSERT INTO patient ($fields) VALUES ($placeholders)";

    // Execute INSERT query
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Patient created successfully");
    } else {
        return array("success" => false, "data" => "Failed to create patient");
    }
}

// Function to update a patient
function updatePatient($pdo, $id, $data)
{
    // Prepare UPDATE query
    $fields = '';
    foreach ($data as $key => $value) {
        $fields .= "$key = :$key, ";
    }
    $fields = rtrim($fields, ', ');

    $number = $data['P_Number'];
    $query1 = "SELECT COUNT(*) AS count FROM patient WHERE P_Number = :number AND patientID != :id";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(':id', $id);
    $stmt1->bindParam(':number', $number);

    $stmt1->execute();
    $result = $stmt1->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        return array("success" => false, "data" => "Patient Number already exists");
    }

    $query = "UPDATE patient SET $fields WHERE patientID = :id";

    // Execute UPDATE query
    $stmt = $pdo->prepare($query);
    $data['id'] = $id;
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "Patient updated successfully");
    } else {
        return array("success" => false, "data" => "Failed to update patient");
    }
}

// Function to get patient by ID
function getPatientById($pdo, $id)
{
    // Prepare SELECT query
    $query = "SELECT * FROM patient WHERE patientID = :id";

    // Execute SELECT query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        return array("success" => true, "data" => $patient);
    } else {
        return array("success" => false, "data" => "Patient not found");
    }
}

// Function to get all patients
function getAllPatients($pdo)
{
    // Prepare SELECT query
    $query = "SELECT * FROM patient";

    // Execute SELECT query
    $stmt = $pdo->query($query);
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($patients) {
        return array("success" => true, "data" => $patients);
    } else {
        return array("success" => false, "data" => "No patients found");
    }
}
// Function to delete patient by ID
function deletePatientByID($pdo, $id)
{
    // Prepare DELETE query
    $query = "DELETE FROM patient WHERE patientID = :id";

    // Execute DELETE query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $success = $stmt->execute();

    if ($success) {
        return array("success" => true, "data" => "Patient deleted successfully");
    } else {
        return array("success" => false, "data" => "Failed to delete patient");
    }
}
// Function to create a file
function createFile($pdo, $data)
{
    // Prepare INSERT query
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    $query = "INSERT INTO file ($fields) VALUES ($placeholders)";

    // Execute INSERT query
    $stmt = $pdo->prepare($query);
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "File created successfully");
    } else {
        return array("success" => false, "data" => "Failed to create file");
    }
}

// Function to delete file by ID
function deleteFileByID($pdo, $id)
{
    // Prepare DELETE query
    $query = "DELETE FROM file WHERE FileID = :id";

    // Execute DELETE query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $success = $stmt->execute();

    if ($success) {
        return array("success" => true, "data" => "File deleted successfully");
    } else {
        return array("success" => false, "data" => "Failed to delete file");
    }
}
function sanitize($input)
{
    // Remove leading and trailing whitespace
    $input = trim($input);

    // Remove backslashes
    $input = stripslashes($input);

    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);

    // You can add more sanitization steps as needed

    return $input;
}

function isLoggedIn()
{
    return isset ($_SESSION['ID']);
}

// Function to check if the logged-in user is an admin
function isAdmin()
{
    return (isset ($_SESSION['Role']) && $_SESSION['Role'] == 'Admin');
}

// Function to check if the logged-in user is a doctor
function isDoctor()
{
    return (isset ($_SESSION['Role']) && $_SESSION['Role'] == 'Doctor');
}
function getCounts($pdo)
{
    // Initialize counts array
    $counts = array();

    // Query to get count of doctors
    $queryDoctor = "SELECT COUNT(*) AS doctorCount FROM doctor";
    $stmtDoctor = $pdo->query($queryDoctor);
    $counts['doctorCount'] = $stmtDoctor->fetchColumn();

    // Query to get count of patients
    $queryPatient = "SELECT COUNT(*) AS patientCount FROM patient";
    $stmtPatient = $pdo->query($queryPatient);
    $counts['patientCount'] = $stmtPatient->fetchColumn();

    // Query to get count of files
    $queryFile = "SELECT COUNT(*) AS fileCount FROM file";
    $stmtFile = $pdo->query($queryFile);
    $counts['fileCount'] = $stmtFile->fetchColumn();

    // Return counts array
    return $counts;
}