<?php
function check_login($conn)
{
    if (isset($_SESSION["regnumber"])) {
        $regnumber = $_SESSION["regnumber"];

        // Use a prepared statement for security
        $query = "SELECT * FROM users WHERE regnumber = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $regnumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            return $user_data; // Return user data if login is valid
        }
    }

    // Redirect to login if not logged in
    header("Location: login.php");
    exit; // Use exit instead of die for clarity
}
