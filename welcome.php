<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
echo "welcome to logged in page ";
echo $_SESSION['username'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    
    <title>Document</title>
</head>
<body>

<div class="page-header">
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']) ?></b> Welcome to Student Grader App</h1>
</div>
<div>
    <a href="reset-password.php" class="btn btn-warning">Reset your password</a>
    <a href="logout.php" class="btn btn-danger">Sign out of your account</a>
</div>

</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>