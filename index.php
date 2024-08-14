<?php
include 'db.php';

$stmt = $pdo->query("SELECT student.*, classes.name AS class_name FROM student LEFT JOIN classes ON student.class_id = classes.class_id");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Student List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo htmlspecialchars($student['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($student['class_name']); ?></td>
                        <td>
                            <?php if ($student['image']): ?>
                                <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="50" height="50" />
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="view.php?id=<?php echo $student['id']; ?>" class="btn btn-info">View</a>
                            <a href="edit.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary">Add New Student</a>
    </div>
</body>
</html>
