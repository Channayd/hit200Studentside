<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredPasskey = $_POST['passkey'];

    if (isset($_SESSION['passkey']) && isset($_SESSION['passkey_expiry'])) {
        if (time() <= $_SESSION['passkey_expiry'] && $enteredPasskey == $_SESSION['passkey']) {
            echo json_encode(['status' => 'success', 'message' => 'Passkey validated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or expired passkey.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No passkey found.']);
    }
}
?>