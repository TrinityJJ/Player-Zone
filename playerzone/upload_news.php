<?php
include 'db_connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category'];
    $author = $_POST['author'];

    // Handle file upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO news (title, content, category_id, image_path, author) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $content, $category_id, $target_file, $author]);
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded and news added.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Fetch categories for dropdown
$categorias = $conn->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload News</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Upload News</h1>
    <form action="upload_news.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br><br>
        
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br><br>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>
        
        <input type="submit" value="Upload News" name="submit">
    </form>
    <a href="noticias.php">Back to News</a>
</body>
</html>
