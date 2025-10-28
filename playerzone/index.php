<?php
// Exemplo simples de conexão ao banco (ajuste para suas credenciais)
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'playerzone';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Buscar notícias cadastradas
$sql = "SELECT * FROM noticias ORDER BY data_publicacao DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" type="image/png" href="imagens/logo-player-zone.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Zone - Notícias de Games</title>
    <meta name="description" content="Player Zone - O melhor portal de notícias de games. Cobertura completa de todos os gêneros de jogos, análises, guias e comunidade.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>Player Zone</h1>
                    <span>Notícias de Games</span>
                </div>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="#home" class="active">Home</a></li>
                        <li><a href="#news">Notícias</a></li>
                        <li><a href="#reviews">Análises</a></li>
                        <li><a href="#guides">Guias</a></li>
                        <li><a href="#videos">Vídeos</a></li>
                        <li><a href="#community">Comunidade</a></li>
                        <li><a href="#about">Sobre</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                    <div id="user-profile" class="user-profile hidden">
                        <div class="profile-dropdown">
                            <button class="profile-btn" onclick="toggleProfileDropdown()">
                                <img id="profile-avatar" src="https://via.placeholder.com/40x40/FF6B35/FFFFFF?text=U" alt="Perfil" class="profile-avatar">
                                <span id="profile-name">Usuário</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div id="profile-dropdown-content" class="profile-dropdown-content hidden">
                                <div class="profile-info">
                                    <img id="profile-avatar-large" src="https://via.placeholder.com/80x80/FF6B35/FFFFFF?text=U" alt="Perfil" class="profile-avatar-large">
                                    <h3 id="profile-full-name">Nome Completo</h3>
                                    <p id="profile-email">email@exemplo.com</p>
                                </div>
                                <div class="profile-actions">
                                    <button onclick="goToProfile()">Meu Perfil</button>
                                    <button onclick="logout()">Sair</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
                    <div class="mode-toggle">
                        <button id="dark-mode-toggle" title="Alternar modo escuro" class="dark-mode-btn">
                            <span class="dark-mode-icon"><i class="fas fa-moon"></i></span>
                        </button>
                    </div>
                    <div class="auth-buttons" id="auth-buttons">
                        <button class="login-btn" id="openLoginModal">Login</button>
                        <button class="register-btn" onclick="window.location.href='cadastro player zone/index.html'">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="hero-content">
                <h2>As últimas notícias do mundo dos games</h2>
                <p>Cobertura completa de todos os gêneros, análises profundas e comunidade vibrante</p>
            </div>
        </div>
    </section>

    <!-- Latest News (Dinamizada) -->
    <section id="news" class="latest-news">
        <div class="container">
            <div class="section-header">
                <h2>Últimas Notícias</h2>
                <div class="filter-tabs">
                    <button class="filter-btn active" data-filter="all">Todas</button>
                    <button class="filter-btn" data-filter="acao">Ação</button>
                    <button class="filter-btn" data-filter="rpg">RPG</button>
                    <button class="filter-btn" data-filter="esports">eSports</button>
                    <button class="filter-btn" data-filter="tecnologia">Tecnologia</button>
                </div>
            </div>
            <div class="news-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <article class="news-card" data-category="<?php echo strtolower($row['categoria']); ?>">
                            <img src="uploads/<?php echo htmlspecialchars($row['imagem']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>">
                            <div class="card-content">
                                <span class="category"><?php echo htmlspecialchars($row['categoria']); ?></span>
                                <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars($row['resumo']); ?></p>
                                <div class="card-meta">
                                    <span><i class="far fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($row['data_publicacao'])); ?></span>
                                    <span><i class="far fa-comment"></i> 0 comentários</span>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma notícia publicada ainda.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- (As demais seções — Reviews, Guias, Vídeos, Comunidade, Sobre e Footer — continuam exatamente iguais ao HTML original) -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h1>Player Zone</h1>
                    <span>Notícias de Games</span>
                </div>
                <nav class="footer-menu">
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#news">Notícias</a></li>
                        <li><a href="#reviews">Análises</a></li>
                        <li><a href="#guides">Guias</a></li>
                        <li><a href="#videos">Vídeos</a></li>
                        <li><a href="#community">Comunidade</a></li>
                        <li><a href="#about">Sobre</a></li>
                    </ul>
                </nav>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts originais -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="/javascript/script.js"></script>
    <script>
        // Alternar modo escuro
        const toggle = document.getElementById('dark-mode-toggle');
        toggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', document.body.classList.contains('dark-mode') ? 'on' : 'off');
        });
        if (localStorage.getItem('dark-mode') === 'on') {
            document.body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
