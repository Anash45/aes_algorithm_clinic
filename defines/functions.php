<?php
require_once 'db_conn.php'; // Include your database connection file here

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
    $query = "SELECT COUNT(*) AS count FROM doctor WHERE D_Email = :email";
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
// Function to create a patient
function createPatient($pdo, $data)
{
    // Prepare INSERT query
    $fields = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
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

// Function to update a file
function updateFile($pdo, $id, $data)
{
    // Prepare UPDATE query
    $fields = '';
    foreach ($data as $key => $value) {
        $fields .= "$key = :$key, ";
    }
    $fields = rtrim($fields, ', ');

    $query = "UPDATE file SET $fields WHERE FileID = :id";

    // Execute UPDATE query
    $stmt = $pdo->prepare($query);
    $data['id'] = $id;
    $success = $stmt->execute($data);

    if ($success) {
        return array("success" => true, "data" => "File updated successfully");
    } else {
        return array("success" => false, "data" => "Failed to update file");
    }
}

// Function to get file by ID
function getFileById($pdo, $id)
{
    // Prepare SELECT query
    $query = "SELECT * FROM file WHERE FileID = :id";

    // Execute SELECT query
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        return array("success" => true, "data" => $file);
    } else {
        return array("success" => false, "data" => "File not found");
    }
}

// Function to get all files
function getAllFiles($pdo)
{
    // Prepare SELECT query
    $query = "SELECT * FROM file";

    // Execute SELECT query
    $stmt = $pdo->query($query);
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($files) {
        return array("success" => true, "data" => $files);
    } else {
        return array("success" => false, "data" => "No files found");
    }
}