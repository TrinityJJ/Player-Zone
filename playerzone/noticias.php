<?php
include 'db_connect.php';

// Get selected category and sort from URL parameters
$selected_category = isset($_GET['categoria']) ? $_GET['categoria'] : 'all';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'recent';

// Fetch categories for sidebar
$categories_stmt = $conn->prepare("SELECT * FROM categories");
$categories_stmt->execute();
$categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);

// Build query based on selected category and sort
$order_clause = '';
switch ($sort_by) {
    case 'popular':
        $order_clause = 'ORDER BY n.created_at DESC'; // For now, we'll use date as popularity indicator
        break;
    case 'comments':
        $order_clause = 'ORDER BY n.created_at DESC'; // Placeholder - would need comments table
        break;
    default: // recent
        $order_clause = 'ORDER BY n.created_at DESC';
}

if ($selected_category === 'all') {
    $stmt = $conn->prepare("SELECT n.*, c.name as category_name FROM news n JOIN categories c ON n.category_id = c.id $order_clause");
    $stmt->execute();
} else {
    $stmt = $conn->prepare("SELECT n.*, c.name as category_name FROM news n JOIN categories c ON n.category_id = c.id WHERE c.name = ? $order_clause");
    $stmt->execute([$selected_category]);
}
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias - DOGS</title>
    <meta name="description" content="Todas as notícias de games em um só lugar. Filtre por categoria e fique por dentro do mundo dos games.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/noticias.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>DOGS</h1>
                    <span>Notícias de Games</span>
                </div>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="noticias.php" class="active">Notícias</a></li>
                        <li><a href="analises.html">Análises</a></li>
                        <li><a href="guias.html">Guias</a></li>
                        <li><a href="videos.html">Vídeos</a></li>
                        <li><a href="comunidade.html">Comunidade</a></li>
                        <li><a href="sobre.html">Sobre</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><?php echo $selected_category === 'all' ? 'Todas as Notícias' : 'Notícias de ' . ucfirst($selected_category); ?></h1>
            <p>Fique por dentro das últimas novidades do mundo dos games</p>
            <a href="upload_news.php" class="btn btn-primary">Adicionar Notícia</a>
        </div>
    </section>

    <!-- News Content -->
    <section class="news-content">
        <div class="container">
            <div class="news-layout">
                <!-- Sidebar -->
                <aside class="news-sidebar">
                    <div class="sidebar-section">
                        <h3>Categorias</h3>
                        <ul class="category-list">
                            <li><a href="noticias.php" data-category="all" class="<?php echo $selected_category === 'all' ? 'active' : ''; ?>">Todas</a></li>
                            <?php foreach ($categories as $category): ?>
                                <li><a href="noticias.php?categoria=<?php echo urlencode($category['name']); ?>" data-category="<?php echo strtolower($category['name']); ?>" class="<?php echo $selected_category === $category['name'] ? 'active' : ''; ?>"><?php echo $category['name']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="sidebar-section">
                        <h3>Mais Lidas</h3>
                        <div class="trending-news">
                            <article class="trending-item">
                                <img src="https://via.placeholder.com/80x60/FF6B35/FFFFFF?text=1" alt="Trending">
                                <div>
                                    <h4>GTA VI tem data oficial revelada</h4>
                                    <span>125k visualizações</span>
                                </div>
                            </article>
                            <article class="trending-item">
                                <img src="https://via.placeholder.com/80x60/4A90E2/FFFFFF?text=2" alt="Trending">
                                <div>
                                    <h4>Nintendo Switch 2 confirmada</h4>
                                    <span>98k visualizações</span>
                                </div>
                            </article>
                            <article class="trending-item">
                                <img src="https://via.placeholder.com/80x60/50C878/FFFFFF?text=3" alt="Trending">
                                <div>
                                    <h4>Counter-Strike 2 tem novo mapa</h4>
                                    <span>87k visualizações</span>
                                </div>
                            </article>
                        </div>
                    </div>
                    
                    <div class="sidebar-section">
                        <h3>Newsletter</h3>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Seu email" required>
                            <button type="submit">Inscrever</button>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="news-main">
                    <div class="news-header">
                        <h2>Últimas Notícias</h2>
                        <div class="news-controls">
                            <select class="sort-select" onchange="changeSort(this.value)">
                                <option value="recent" <?php echo $sort_by === 'recent' ? 'selected' : ''; ?>>Mais Recentes</option>
                                <option value="popular" <?php echo $sort_by === 'popular' ? 'selected' : ''; ?>>Mais Populares</option>
                                <option value="comments" <?php echo $sort_by === 'comments' ? 'selected' : ''; ?>>Mais Comentados</option>
                            </select>
                        </div>
                    </div>

                    <div class="news-list">
                        <?php if (count($news) > 0): ?>
                            <?php foreach ($news as $article): ?>
                                <article class="news-item" data-category="<?php echo strtolower($article['category_name']); ?>">
                                    <?php if ($article['image_path']): ?>
                                        <img src="<?php echo $article['image_path']; ?>" alt="<?php echo $article['title']; ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/300x200/CCCCCC/FFFFFF?text=No+Image" alt="No Image">
                                    <?php endif; ?>
                                    <div class="news-item-content">
                                        <span class="category"><?php echo $article['category_name']; ?></span>
                                        <h3><?php echo $article['title']; ?></h3>
                                        <p><?php echo substr($article['content'], 0, 150) . '...'; ?></p>
                                        <div class="news-meta">
                                            <span><i class="far fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($article['created_at'])); ?></span>
                                            <span><i class="far fa-user"></i> <?php echo $article['author']; ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhuma notícia encontrada. <a href="upload_news.php">Adicione a primeira notícia!</a></p>
                        <?php endif; ?>
                    </div>

                    <div class="pagination">
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn">4</button>
                        <button class="pagination-btn">5</button>
                        <button class="pagination-btn next">Próximo <i class="fas fa-chevron-right"></i></button>
                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>DOGS</h3>
                    <p>O melhor portal de notícias de games. Cobertura completa de todos os gêneros de jogos, análises profundas e comunidade vibrante.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Categorias</h3>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li><a href="noticias.php?categoria=<?php echo urlencode($category['name']); ?>"><?php echo $category['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Links Rápidos</h3>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="noticias.php">Notícias</a></li>
                        <li><a href="analises.html">Análises</a></li>
                        <li><a href="guias.html">Guias</a></li>
                        <li><a href="videos.html">Vídeos</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Newsletter</h3>
                    <p>Receba as últimas notícias diretamente no seu email</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Seu email" required>
                        <button type="submit">Inscrever</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 DOGS. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/noticias.js" defer></script>
    <script>
        function changeSort(sortValue) {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort', sortValue);
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
    </script>
</body>
</html>
