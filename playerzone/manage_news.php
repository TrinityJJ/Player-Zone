<?php
include 'db_connect.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_news.php");
    exit();
}

// Fetch all news
$stmt = $conn->prepare("SELECT n.*, c.name as category_name FROM news n JOIN categories c ON n.category_id = c.id ORDER BY n.created_at DESC");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Manage News</h1>
    <a href="noticias.php">Back to News</a>
    <a href="upload_news.php">Add New News</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $article): ?>
                <tr>
                    <td><?php echo $article['id']; ?></td>
                    <td><?php echo $article['title']; ?></td>
                    <td><?php echo $article['category_name']; ?></td>
                    <td><?php echo $article['author']; ?></td>
                    <td><?php echo $article['created_at']; ?></td>
                    <td>
                        <a href="edit_news.php?id=<?php echo $article['id']; ?>">Edit</a>
                        <a href="manage_news.php?delete=<?php echo $article['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
