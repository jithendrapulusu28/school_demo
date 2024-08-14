<?php
include 'db.php';

// Fetch classes for dropdown
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image']['name'];

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

    if ($image && !move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        die('Error uploading file');
    }

    $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $address, $class_id, $image]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Create Student</h1>
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="address"></textarea>
            </div>
            <div class="form-group">
                <label>Class</label>
                <select class="form-control" name="class_id">
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['class_id']; ?>"><?php echo htmlspecialchars($class['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
