<?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('location: login.php');
        exit;
    }
//include config
require_once "config.php";

//definirame promenlivite od formata igi inicijalizirame so prazna vrednot
$name = $course = $grade = "";
$name_err = $course_err = $grade_err = "";

/*

ako imame POST req  isset POST !empty {

    procesiraj go i updejtuvaj vo baza 
} else {

ako postoi GET["id"] , go zemame toj id od url-to so get i pravime select statment 

SELECT * FROM students WHERE id=:id

name 
course 
grade 

}
 

*/

if (isset($_POST["id"]) && !empty($_POST["id"])) {
// ovde ke se izvrsuva update 
 
$id = $_POST["id"];

//Validacija na name 

$input_name = trim($_POST["name"]);
if (empty($input_name)) {
    $name_err = "Please enter name.";
} elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z ]*$/")))) {
    $name_err = "Please enter valid name.";
} else {
    $name = $input_name;
    
}

// Validacija na course
if (empty(trim($_POST['course']))) {
    $course_err = 'Please enter course';
} else {
    $course = trim($_POST['course']);

}
// Validacija na grade
if (empty(trim($_POST['grade']))) {
    $grade_err = 'Please enter grade';
} elseif  (!ctype_digit($_POST['grade']) ) {
    $grade_err = 'Please enter a numeric grade';
} elseif  (intval($_POST['grade']) > 6 ) {
    $grade_err = 'Please enter a numeric grade from 1 to 5';
}     else {
    $grade = trim($_POST['grade']);
   
}

if(empty($name_err) && empty($grade_err) && empty($course_err)) {

    $sql="UPDATE students SET name=:name, course=:course, grade=:grade WHERE id=:id";

    if($stmt = $pdo->prepare($sql)) {
        // bind na promenlivite 
        $stmt->bindParam(":name", $param_name);
        $stmt->bindParam(":course", $param_course);
        $stmt->bindParam(":grade", $param_grade);
        $stmt->bindParam(":id", $param_id);

        //set na parametrite
        $param_name = $name;
        $param_course = $course; 
        $param_grade = $grade;
        $param_id = $id;

        if($stmt->execute()) {
            header("location: index.php");
            exit();
        } else {
            echo "Smtg went wrong";
        }

    }
    unset($stmt);
}
unset($pdo);

} else {

    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        //ovde go zemame URL parametarot 
        $id = trim($_GET["id"]);

        //SQL stmt
        $sql="SELECT * FROM students WHERE id = :id";

        //Prepare
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":id", $param_id);
        //Set
            $param_id =  $id; 
        //Ececute
            if($stmt->execute()) {
                if($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row["name"];
                    $course = $row["course"];
                    $grade = $row["grade"];
                } else {
                    // nema valident id parametar
                    header("location:error.php");
                    exit();
                }
            } else {
                echo "Smtg went wrong";
            }
        }
        unset($stmt);
        unset($pdo); 
    } else {
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
                <h2 class="mb-3">Update Record</h2>
            </div>
            <div class="py-4">
                <p>Please edit the input values and submit to update the record</p>
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
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="cancel" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>