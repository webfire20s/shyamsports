<?php
session_start();
include('includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uid = $conn->real_escape_string($_POST['uid']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM athletes WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        /* ================================
           🔴 BLOCK UNAPPROVED USERS
        ================================= */
        if ($user['payment_status'] !== 'approved') {
            header("Location: login.php?error=not_approved");
            exit();
        }

        /* ================================
           🔐 PASSWORD VERIFICATION
        ================================= */

        // Case 1: Hashed password (NEW USERS)
        if (password_verify($password, $user['password'])) {

            $_SESSION['athlete_uid'] = $user['uid'];
            $_SESSION['athlete_name'] = $user['full_name'];
            $_SESSION['athlete_sport'] = $user['sport'];

            header("Location: dashboard.php");
            exit();
        }

        // Case 2: Plain password fallback (OLD USERS)
        else if ($password === $user['password']) {

            // 🔥 Upgrade password to hashed automatically
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("UPDATE athletes SET password='$newHash' WHERE id=".$user['id']);

            $_SESSION['athlete_uid'] = $user['uid'];
            $_SESSION['athlete_name'] = $user['full_name'];
            $_SESSION['athlete_sport'] = $user['sport'];

            header("Location: dashboard.php");
            exit();
        }

        else {
            header("Location: login.php?error=invalid_credentials");
            exit();
        }

    } else {
        header("Location: login.php?error=user_not_found");
        exit();
    }

} else {
    header("Location: login.php");
    exit();
}
?>

<?php if(isset($_GET['error']) && $_GET['error'] == 'not_approved'): ?>
<div class="bg-yellow-500 text-white p-3 font-bold">
    Your account is pending approval. Please wait.
</div>
<?php endif; ?>