<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}
?>

<?php
require_once 'site/header.php';
require_once "config.php";
?>

<div class="row mb-5 mt-5">
    <div class="col-2"></div>
    <div class="col-8">
        <div class="d-flex justify-content-between mb-4 border-bottom">
            <h2>Student Detalis</h2>
            <a href="create-record.php" class="btn btn-success mb-3">Add new Student</a>
        </div>




        <table class="table table-striped">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Grade</th>
                <th scope="col">Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM students";
            if ($result = $pdo->query($sql)) {
                if ($result->rowCount() > 0) {
                    $i=1;
                    while ($row = $result->fetch()) { ?>
                        <tr class="row-<?php echo $i ?>">
                            <th scope="row"><?php echo $i; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['course']; ?></td>
                            <td><?php echo $row['grade']; ?></td>
                            <td>
                                <a href="view-record.php?id=<?php echo $row['id'] ?>"><i class="fas fa-eye mr-3 text-primary"></i></a>
                                <a href="update-record.php?id=<?php echo $row['id'] ?>"><i class="fas fa-pencil-alt mr-3 text-primary"></i></a>
                                <a href="delete-record.php?id=<?php echo $row['id'] ?>"><i class="far fa-trash-alt text-primary"></i></a>
                            </td>
                        </tr>
                    <?php $i=$i+1; } ?>
        </table>
            <?php
                    unset($result);
                } else {
                    echo "nemame recordi vo bazata";
                }
            }
            unset($pdo);
?>
    </div>
</div>

<?php require_once 'site/footer.php'; ?>