<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <title>Student Grader</title>
        
    </head>
    <body>

        <header class="bg-success">
                <nav class="px-5">
                    <div class="row">
                        <div class="col-6">
                            <a href="/" class="navbar-brand">
                                <h1 class="text-white text-uppercase font-weight-bold">Student Grader</h1>
                            </a>
                        </div>

                        <div class="col-6 d-flex align-items-center justify-content-end">


<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>

<a href="reset-password.php" class="btn btn-warning mr-2">Reset Your Password</a>
<a href="logout.php" class="btn btn-danger">Sign Out <?php echo $_SESSION['username']; ?></a>

<?php  }  ?>



                        </div>
                    </div>
                </nav>
        </header>