<?php 
// Include config file
include 'config.php';

// Defining variables and initializing them with empty values

$name = $lastname = $email = $username = $password = $confirm_password = '';

$name_err = $lastname_err = $email_err = $username_err = $password_err = $confirm_password_err = '';

// Data procesing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Name validation
    if (empty(trim($_POST['name']))) {
        $name_err = 'Please enter name';
    } else {
        $name = trim($_POST['name']);
    }

    // Lastname validation
    if (empty(trim($_POST['lastname']))) {
        $lastname_err = 'Please enter lastname';
    } else {
        $lastname = trim($_POST['lastname']);
    }

    // Email validation
    if (empty(trim($_POST['email']))) {
        $email_err = 'Please enter email';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {  
        $email_err = 'Your email addres is not valid';
    } else {
        $email = trim($_POST['email']);
    }

    // Username validation
    if (empty(trim($_POST['username']))) {
        $username_err = 'Please enter username';
    } else {

        // Prepare select
        $sql = 'SELECT id FROM users WHERE username = :username';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':username', $param_username);

            // Parameter setting
            $param_username = trim($_POST['username']);

            // Executing prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = 'This username is taken';
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something is wrong";
            }
            unset($stmt);
        }
    }

    // Password validation
    if (empty(trim($_POST['password']))) {
        $password_err = 'Please enter password';
    } elseif (strlen(trim($_POST['password'])) < 6 ) {
        $password_err = 'Password must have atleast 6 characters';
    } else {
        $password = trim($_POST['password']);
    }

    // Confirm password validation
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);

        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }   
    }

    // Check input errors

    if (empty($name_err) && empty($lastname_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Preparing insert statements
        $sql = "INSERT INTO users (name, lastname, email, username, password) VALUES (:name, :lastname, :email, :username, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind on the variable
            $stmt->bindParam('name', $param_name);
            $stmt->bindParam('lastname', $param_lastname);
            $stmt->bindParam('email', $param_email);
            $stmt->bindParam('username', $param_username);
            $stmt->bindParam('password', $param_password);

            // Parametar setting
            $param_name = $name;
            $param_lastname = $lastname;
            $param_email = filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Executing binding
            if ($stmt->execute()) {
                // Redirect to login page
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
<?php require_once 'site/header.php'; ?>


<!-- Register Form -->
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                <label>Lastname</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $lastname_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
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
<?php require_once 'site/footer.php'; ?>