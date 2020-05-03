<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

    if (isset($_POST["id"]) && !empty($_POST["id"])) {

        require_once "config.php";

        $sql = "DELETE FROM students WHERE id = :id";

        if($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $param_id);

            $param_id = trim($_POST["id"]);

            if ($stmt->execute()) {
                //uspesno e izbrisano
                header("location: index.php");
            } else {
                echo "Somthing went wrong";
            }

        }
unset($stmt);

unset($pdo);

    } else {
        if(empty(trim($_GET["id"]))) {
            header("location: error.php");
            exit();

        }

    }
?>

<?php require_once 'site/header.php'; ?>

    <div class="row mb-5 mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="border-bottom mb-4">
                <h2 class="mb-3">Delete Record</h2>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger py-4" role="alert">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]) ?>" />
                <p>Are you sure you want to delete this record?</p>
                <input type="submit" value="Yes" class="btn btn-danger"/>
            
                <a href="index.php" class="btn btn-light">No</a>
            </div>
            </form>

        </div>
    </div>

<?php require_once 'site/footer.php'; ?>