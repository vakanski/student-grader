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
                <h2 class="mb-3">Update Record</h2>
            </div>
            <div class="py-4">
                <p>Please edit the input values and submit to update the record</p>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="course">Course</label>
                        <input type="text" class="form-control" id="course" name="course" placeholder="PHP">
                    </div>
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <input type="text" class="form-control" id="grade" name="grade" placeholder="4">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="cancel" class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'site/footer.php'; ?>