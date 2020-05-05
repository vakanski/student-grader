<?php 

// session_start();

// if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
//     header('Location: welcome.php');
//     exit;
// }

// // Include config file
// require_once 'config.php';

// // Defining variables and initializing them with empty values

// $username = $password = '';

// $username_err = $password_err = '';

// if($_SERVER['REQUEST_METHOD'] == 'POST') {

//     // Check to see if username field is empty
//     if (empty(trim($_POST['username']))) {
//         $username_err = 'Please enter username';
//     } else {
//         $username = trim($_POST['username']);
//     }

//     // Check to see if password field is empty
//     if (empty(trim($_POST['password']))) {
//         $password_err = 'Please enter your password';
//     } else {
//         $password = trim($_POST['password']);
//     }

//     if(empty($username_err) && empty($password_err)) {

//         $sql = "SELECT id, username, password FROM users WHERE username = :username";

//         if($stmt = $pdo->prepare($sql)) {

//             $stmt->bindParam('username', $param_username);

//             $param_username = trim($_POST['username']);

//             // Check if username exists

//             if($stmt->rowCount() == 1) {
                
//                 if($row = $stmt->fetch()) {
//                     $id = $row['id'];
//                     $username = $row['username'];
//                     $hashed_password = $row['password'];
                    
//                     if(password_verify($password, $hashed_password)) {
//                         session_start();

//                         $_SESSION['loggedin'] = true;
//                         $_SESSION['id'] = $id;
//                         $_SESSION['username'] = $username;
                        
//                         header('Location: welcome.php');
//                     } else {
//                         // error if the passwords dont match
//                         $password_err = 'The password you entered is not correct.';
//                     }
//                 } 
//             } else {
//                 $username_err = 'The username does not exist';
//             }
//         } else {
//             echo 'Something went wrong!';
//         }
//         unset($stmt);
//     } 
//     unset($pdo);
// }

session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}
require_once "config.php";
$username = $password = "";
$username_err = $password_err = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
//dali usrname  e prazen
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
//dali password e prazen
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username , password FROM users WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                //da proverime dali usernameot potoi 
                if($stmt->rowCount() == 1) {
                    if($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            header("location:index.php");
                        }  else { 
                            //greska za password 
                            $password_err="The pass you entered is not correct";
                        }
                    }                 
                } else {
                    $username_err="No user with that username ";
                }
            } else {
                echo "Smtg is wrong";
            }
            unset($stmt);
        }
    }
unset($pdo);
} // end if POST

?>

<?php require_once 'site/header.php'; ?>

<!-- Register Form -->
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Dont have an account? <a href="register.php">Register here</a>.</p>
        </form>
        </div>
        <div class="col-4"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<?php require_once 'site/footer.php'; ?>