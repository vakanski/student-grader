<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        
        require_once "config.php";

        //prepare SQL
        $sql = "SELECT * FROM students WHERE id = :id";

        if($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":id", $param_id);
            $param_id=trim($_GET["id"]);
        

        if ($stmt->execute()) {
            if($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $row["name"];
                $course = $row["course"];
                $grade = $row["grade"];

            } else {
                header("location: error.php");
                exit();
            }
 
        } else {
            echo "Something went wrong";
        }
         
    } //end if 1
    unset($stmt);
  unset($pdo);
    } else {
        // url-to 
        header("location: error.php");
        exit();
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
                    <p><?php echo $row["name"]; ?></p>
                </div>
                <div>
                    <p class="font-weight-bold">Course</p>
                    <p><?php echo $course; ?></p>
                </div>
                <div>
                    <p class="font-weight-bold">Grade</p>
                    <p><?php echo $row["grade"] ?></p>
                </div>
                <a href="index.php" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>