<?php
$db_server = "127.0.0.1"; // Database server
$db_username = "root";    // Database username
$db_password = "";         // Database password
$db_name = "interndb";     // Database name

try {
    // Attempt to establish a connection
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

    // Check if the connection encountered any errors
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // If successful, you can notify or perform further actions

} catch (Exception $e) {
    // Handle the exception and display the error message
    echo "Error: " . $e->getMessage();
}
