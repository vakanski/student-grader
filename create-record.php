<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }

require_once "config.php";

$name = $course = $grade = "";
$name_err = $course_err = $grade_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") { 

$input_name = trim($_POST["name"]);
if (empty($input_name)) {
    $name_err = "Please enter name.";
} elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z ]*$/")))) {
    $name_err = "Please enter valid name.";
} else {
    $name = $input_name;
    
}


if (empty(trim($_POST['course']))) {
    $course_err = 'Please enter course';
} else {
    $course = trim($_POST['course']);
    
}


if (empty(trim($_POST['grade']))) {
    $grade_err = 'Please enter grade';
} elseif  (!ctype_digit($_POST['grade'])) {
    $grade_err = 'Please enter a numeric grade';
} else {
    $grade = trim($_POST['grade']);
   
}

    if(empty($name_err) && empty($course_err) && empty($grade_err)) {
        $sql = "INSERT INTO students (name, course, grade) VALUES (:name, :course, :grade)";

        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":course", $param_course);
            $stmt->bindParam(":grade", $param_grade);

            $param_name = $name;
            $param_course = $course;
            $param_grade = $grade;
        }

        if($stmt->execute()) {

            header("location: index.php");
            exit();
            
        } else {
            echo "Something went wrong ";

        }
       unset($stmt); 
    } // end 2 if
    unset($pdo);
} // end 1 if

?>

<?php require_once 'site/header.php'; ?>

    <div class="row mb-5 mt-5">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="border-bottom mb-4">
                <h2 class="mb-3">Create Record</h2>
            </div>
            <div class="py-4">
                <p>Please fill this form and submit to add student to the database</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($course_err)) ? 'has-error' : ''; ?>">
                <label>Course</label>
                <input type="text" name="course" class="form-control" value="<?php echo $course; ?>">
                <span class="help-block"><?php echo $course_err; ?></span>
                </div>

                <div class="form-group <?php echo (!empty($grade_err)) ? 'has-error' : ''; ?>">
                <label>Grade</label>
                <input type="text" name="grade" class="form-control" value="<?php echo $grade; ?>">
                <span class="help-block"><?php echo $grade_err; ?></span>
                </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="cancel" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>