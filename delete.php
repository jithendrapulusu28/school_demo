<?php
include 'db.php';

$id = $_GET['id'];

// Fetch student details
$stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete image from server
    $image = $student['image'];
    if ($image && file_exists("uploads/" . $image)) {
        unlink("uploads/" . $image);
    }

    // Delete student from database
    $stmt = $pdo->prepare("DELETE FROM student WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Delete Student</h1>
        <p>Are you sure you want to delete the student <?php echo htmlspecialchars($student['name']); ?>?</p>
        <form action="delete.php?id=<?php echo $student['id']; ?>" method="post">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
