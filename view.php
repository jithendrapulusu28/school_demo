<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT student.*, classes.name AS class_name FROM student LEFT JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">View Student</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
        <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($student['created_at']); ?></p>
        <?php if ($student['image']): ?>
            <p><strong>Image:</strong> <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="200" /></p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary">Back to List</a>
    </div>
</body>
</html>
