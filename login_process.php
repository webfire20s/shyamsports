<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    // Replace your old line 7 with this:
    $uid = $conn->real_escape_string($_POST['uid']);
    $password = $_POST['password'];

    // Query to find the athlete
    $sql = "SELECT * FROM athletes WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the hashed password
        if ($password === $user['password']) {
            // Login success! Set session variables
            $_SESSION['athlete_uid'] = $user['uid'];
            $_SESSION['athlete_name'] = $user['full_name'];
            $_SESSION['athlete_sport'] = $user['sport'];

            // Redirect to a dashboard or profile page
            header("Location: dashboard.php");
            exit();
        } else {
            // Password wrong
            header("Location: registration.php?error=invalid_credentials");
            exit();
        }
    } else {
        // UID not found
        header("Location: registration.php?error=user_not_found");
        exit();
    }
} else {
    header("Location: registration.php");
    exit();
}
?>