<?php
include 'db.php';

// Fetch student details
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM student WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die('Student not found');
}

// Fetch classes for dropdown
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];
    $current_image = $_POST['current_image'];

    if (empty($name)) {
        die('Name is required');
    }

    // Image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($image && ($imageFileType != "jpg" && $imageFileType != "png")) {
        die('Only JPG and PNG files are allowed');
    }

    // Handle file upload if new image is provided
    if ($image) {
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die('Error uploading file');
        }
        // Delete old image
        if ($current_image && file_exists($target_dir . $current_image)) {
            unlink($target_dir . $current_image);
        }
    } else {
        $image = $current_image; // Keep current image if no new image is uploaded
    }

    $sql = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $address, $class_id, $image, $id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Student</h1>
        <form action="edit.php?id=<?php echo $student['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="address"><?php echo htmlspecialchars($student['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Class</label>
                <select class="form-control" name="class_id">
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['class_id']; ?>" <?php if ($student['class_id'] == $class['class_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($class['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image">
                <?php if ($student['image']): ?>
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($student['image']); ?>">
                    <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="100" />
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
