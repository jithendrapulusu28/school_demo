<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (empty($name)) {
        die('Class name is required');
    }

    if (isset($_POST['class_id'])) {
        // Update existing class
        $id = $_POST['class_id'];
        $stmt = $pdo->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
        $stmt->execute([$name, $id]);
    } else {
        // Insert new class
        $stmt = $pdo->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->execute([$name]);
    }

    header('Location: classes.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete class
    $stmt = $pdo->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->execute([$id]);

    header('Location: classes.php');
    exit();
}

// Fetch classes
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Manage Classes</h1>

        <!-- Add/Edit Form -->
        <form action="classes.php" method="post">
            <div class="form-group">
                <label>Class Name</label>
                <input type="text" class="form-control" name="name" required>
                <input type="hidden" name="class_id" value="">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <!-- Class List -->
        <h2 class="mt-5">Class List</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($class['name']); ?></td>
                        <td>
                            <a href="classes.php?edit=<?php echo $class['class_id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="classes.php?delete=<?php echo $class['class_id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
