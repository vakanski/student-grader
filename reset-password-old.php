<?php 
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

    require_once "config.php";
    $password = $confirm_password = '';
    $password_err = $confirm_password_err = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty(trim($_POST['password']))) {
            $password_err = 'Please enter password';
        } elseif (strlen(trim($_POST['password'])) < 6 ) {
            $password_err = 'Password must have atleast 6 characters';
        } else {
            $password = trim($_POST['password']);
        }

        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
    
            if(empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }   
        }

        if (empty($password_err) && empty($confirm_password_err)) {
            
            $sql = "UPDATE users SET password = :password WHERE id = :id";

            if ($stmt = $pdo->prepare($sql)) {
                // Bind on the variable
                $stmt->bindParam('password', $param_password);
                $stmt->bindParam('id', $param_id);
            

                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_id = $_SESSION['id'];

                if ($stmt->execute()) {
                    // Redirect to login page
                    $_SESSION = array();
                    session_destroy();
                    header('Location: login.php');
                    
                } else {
                    echo "Something went wrong";
                }

                unset($stmt);
            }

        }

        unset($pdo);
    }
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

<!-- Reset password Form -->
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>New password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>