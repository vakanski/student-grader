<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }
?>

<?php require_once 'site/header.php'; ?>

    <div class="row mb-5 mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="border-bottom mb-4">
                <h2 class="mb-3">Delete Record</h2>
            </div>
            <div class="alert alert-danger py-4" role="alert">
                <p>Are you sure you want to delete this record?</p>
                <a href="index.php" class="btn btn-danger">Yes</a>
                <a href="index.php" class="btn btn-light">No</a>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>