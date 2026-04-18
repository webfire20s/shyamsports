<?php
if(!isset($_GET['status']) || $_GET['status'] != 'pending'){
    header("Location: registration.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Submitted</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen">

<div class="bg-white p-10 text-center max-w-lg shadow-xl">
    
    <h2 class="text-3xl font-black text-yellow-600 mb-4 uppercase">
        Payment Under Review
    </h2>

    <p class="text-gray-600 mb-6">
        Your registration has been submitted successfully.
        <br><br>
        Our team will verify your payment screenshot.
    </p>

    <div class="bg-yellow-100 p-4 text-sm font-bold text-yellow-800 mb-6">
        ⏳ Status: Pending Approval
    </div>

    <a href="registration.php"
       class="bg-orange-600 text-white px-6 py-3 font-bold uppercase">
        Go Back
    </a>

</div>

</body>
</html>