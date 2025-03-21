<?php
include 'connectiondb.php'; // Include your database connection file

// save_profile.php

include 'connectiondb.php'; // Include the database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];
    $profileImage = $_POST['profileImage']; // Save the image URL
    $cvFile = $_POST['cvFile']; // Save the CV file URL
    $webDesign = $_POST['webDesign'];
    $websiteMarkup = $_POST['websiteMarkup'];
    $onePage = $_POST['onePage'];
    $mobileTemplate = $_POST['mobileTemplate'];
    $backendApi = $_POST['backendApi'];

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO profile_creation (fullName, email, phone, address, bio)
    VALUES ('$fullName', '$email', '$phone', '$address', '$bio', $profileImage)";


    // Execute query and check for success
    if ($conn->query($sql) === TRUE) {
        echo "New profile saved successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();


// File upload handling (image and CV) in save_profile.php
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['profileImage']['name']);
    move_uploaded_file($_FILES['profileImage']['tmp_name'], $uploadFile);
    $profileImage = $uploadFile; // Store the file path in the database
}

// Handle CV file upload
if (isset($_FILES['cvFile']) && $_FILES['cvFile']['error'] == 0) {
    $cvUploadDir = 'uploads/cvs/';
    $cvUploadFile = $cvUploadDir . basename($_FILES['cvFile']['name']);
    move_uploaded_file($_FILES['cvFile']['tmp_name'], $cvUploadFile);
    $cvFile = $cvUploadFile; // Store the file path in the database
}

if(isset($_POST['fullName'])) {
    $fullName = $_POST['fullName'];
} else {
    echo "Full name is missing.";
}

?>
