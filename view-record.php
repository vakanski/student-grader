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
                <h2 class="mb-3">View Record</h2>
            </div>
            <div class="py-4">
                <div>
                    <p class="font-weight-bold">Name</p>
                    <p>John Doe</p>
                </div>
                <div>
                    <p class="font-weight-bold">Course</p>
                    <p>PHP</p>
                </div>
                <div>
                    <p class="font-weight-bold">Grade</p>
                    <p>4</p>
                </div>
                <a href="index.php" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>