// DOM Elements
const menuToggle = document.querySelector('.menu-toggle');
const navMenu = document.querySelector('.nav-menu');
const filterBtns = document.querySelectorAll('.filter-btn');
const newsCards = document.querySelectorAll('.news-card');
const loadMoreBtn = document.querySelector('.load-more');
const searchBtn = document.querySelector('.search-btn');
const searchInput = document.createElement('input');

// Mobile Menu Toggle
menuToggle?.addEventListener('click', () => {
    navMenu?.classList.toggle('active');
    menuToggle.innerHTML = navMenu?.classList.contains('active') 
        ? '<i class="fas fa-times"></i>' 
        : '<i class="fas fa-bars"></i>';
});

// Smooth Scrolling for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Update active nav link
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.classList.remove('active');
            });
            this.classList.add('active');
        }
    });
});

// News Filtering
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const filter = btn.getAttribute('data-filter');
        
        // Update active filter button
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Filter news cards
        newsCards.forEach(card => {
            const category = card.getAttribute('data-category');
            if (filter === 'all' || category === filter) {
                card.style.display = 'block';
                card.classList.add('fade-in');
                setTimeout(() => card.classList.add('visible'), 100);
            } else {
                card.style.display = 'none';
                card.classList.remove('visible');
            }
        });
    });
});

// Load More News (Simulated)
let newsPage = 1;
const maxPages = 3;

loadMoreBtn?.addEventListener('click', () => {
    if (newsPage < maxPages) {
        loadMoreBtn.textContent = 'Carregando...';
        
        // Simulate loading delay
        setTimeout(() => {
            const newsGrid = document.querySelector('.news-grid');
            const newNews = generateMockNews();
            newsGrid.appendChild(newNews);
            
            newsPage++;
            if (newsPage >= maxPages) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.textContent = 'Carregar mais notícias';
            }
            
            // Re-apply current filter
            const activeFilter = document.querySelector('.filter-btn.active');
            if (activeFilter) {
                activeFilter.click();
            }
        }, 1000);
    }
});

// Search Functionality
searchBtn?.addEventListener('click', () => {
    const searchContainer = document.createElement('div');
    searchContainer.className = 'search-container';
    searchContainer.innerHTML = `
        <input type="text" placeholder="Buscar notícias..." class="search-input">
        <button class="search-close"><i class="fas fa-times"></i></button>
    `;
    
    document.body.appendChild(searchContainer);
    
    const searchInput = searchContainer.querySelector('.search-input');
    const searchClose = searchContainer.querySelector('.search-close');
    
    searchInput.focus();
    
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        searchNews(query);
    });
    
    searchClose.addEventListener('click', () => {
        searchContainer.remove();
    });
    
    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            searchContainer.remove();
        }
    });
});

// Search News Function
function searchNews(query) {
    const allCards = document.querySelectorAll('.news-card, .review-card, .guide-card');
    
    allCards.forEach(card => {
        const title = card.querySelector('h3, h4').textContent.toLowerCase();
        const content = card.querySelector('p').textContent.toLowerCase();
        
        if (title.includes(query) || content.includes(query)) {
            card.style.display = 'block';
            card.classList.add('highlight');
        } else {
            card.style.display = 'none';
            card.classList.remove('highlight');
        }
    });
}

// Intersection Observer for Animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in', 'visible');
        }
    });
}, observerOptions);

// Observe all cards and sections
document.addEventListener('DOMContentLoaded', () => {
    const elementsToObserve = document.querySelectorAll(
        '.news-card, .review-card, .guide-card, .video-card, .featured-main, .side-item'
    );
    
    elementsToObserve.forEach(el => {
        observer.observe(el);
    });
});

// Community Features
const postItems = document.querySelectorAll('.post-item');
postItems.forEach(post => {
    const likeBtn = post.querySelector('.like-btn');
    const commentBtn = post.querySelector('.comment-btn');
    
    likeBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        const likeCount = likeBtn.querySelector('span');
        let count = parseInt(likeCount.textContent);
        likeCount.textContent = count + 1;
        likeBtn.style.color = '#FF6B35';
    });
});

// Video Lazy Loading
const videoCards = document.querySelectorAll('.video-card');
videoCards.forEach(card => {
    const iframe = card.querySelector('iframe');
    if (iframe) {
        iframe.setAttribute('loading', 'lazy');
    }
});

// Newsletter Subscription
const newsletterForm = document.querySelector('.newsletter-form');
newsletterForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const email = newsletterForm.querySelector('input[type="email"]').value;
    
    if (email) {
        alert('Obrigado por se inscrever! Você receberá nossas novidades.');
        newsletterForm.reset();
    }
});

// Mock Data Generation
function generateMockNews() {
    const categories = ['acao', 'rpg', 'esports', 'tecnologia'];
    const categoryNames = {
        'acao': 'Ação',
        'rpg': 'RPG',
        'esports': 'eSports',
        'tecnologia': 'Tecnologia'
    };
    
    const mockTitles = [
        'Novo trailer de gameplay impressiona fãs',
        'Atualização traz mudanças significativas',
        'Torneio mundial tem recorde de inscrições',
        'Desenvolvedor anuncia DLC gratuito',
        'Comunidade cria mod incrível para o jogo'
    ];
    
    const mockDescriptions = [
        'Os desenvolvedores compartilharam novos detalhes sobre o próximo lançamento...',
        'A comunidade está empolgada com as últimas novidades...',
        'Prepare-se para uma experiência épica com as novas funcionalidades...',
        'Os fãs não podem esperar para experimentar o novo conteúdo...'
    ];
    
    const fragment = document.createDocumentFragment();
    
    for (let i = 0; i < 4; i++) {
        const category = categories[Math.floor(Math.random() * categories.length)];
        const card = document.createElement('article');
        card.className = 'news-card';
        card.setAttribute('data-category', category);
        
        card.innerHTML = `
            <img src="https://via.placeholder.com/400x250/${Math.floor(Math.random()*16777215).toString(16)}/FFFFFF?text=Notícia+${newsPage}${i+1}" alt="Notícia">
            <div class="card-content">
                <span class="category">${categoryNames[category]}</span>
                <h3>${mockTitles[Math.floor(Math.random() * mockTitles.length)]}</h3>
                <p>${mockDescriptions[Math.floor(Math.random() * mockDescriptions.length)]}</p>
                <div class="card-meta">
                    <span><i class="far fa-clock"></i> ${Math.floor(Math.random() * 12) + 1} horas atrás</span>
                    <span><i class="far fa-comment"></i> ${Math.floor(Math.random() * 100) + 10} comentários</span>
                </div>
            </div>
        `;
        
        fragment.appendChild(card);
    }
    
    return fragment;
}

// Performance Optimization
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Apply debounce to search
const debouncedSearch = debounce(searchNews, 300);

// Theme Toggle (Future Feature)
document.getElementById('toggle-theme').onclick = function() {
  document.body.classList.toggle('dark-mode');
  localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
};
window.onload = function() {
  if(localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
  }
};

// Alternar modo escuro
const toggle = document.getElementById('dark-mode-toggle');
toggle.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('dark-mode', 'on');
    } else {
        localStorage.setItem('dark-mode', 'off');
    }
});

// Verificar o estado do modo escuro ao carregar a página
if (localStorage.getItem('dark-mode') === 'on') {
    document.body.classList.add('dark-mode');
}

// Initialize all features
document.addEventListener('DOMContentLoaded', () => {
    // Add loading states
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', () => {
            img.classList.add('loaded');
        });
    });

    // Load recent movies
    loadRecentMovies();

    // Initialize profile functionality
    initializeProfile();
});

// Profile functionality
function initializeProfile() {
    // Check if user is logged in
    const userProfile = JSON.parse(localStorage.getItem('userProfile'));
    const userProfileDiv = document.getElementById('user-profile');
    const authButtons = document.getElementById('auth-buttons');
    
    if (userProfile) {
        // Show profile
        userProfileDiv.classList.remove('hidden');
        authButtons.classList.add('hidden');
        
        // Fill profile data
        document.getElementById('profile-name').textContent = userProfile.name;
        document.getElementById('profile-full-name').textContent = userProfile.name;
        document.getElementById('profile-email').textContent = userProfile.email;
        document.getElementById('profile-avatar').src = userProfile.avatar || 'https://via.placeholder.com/40x40/FF6B35/FFFFFF?text=' + userProfile.name.charAt(0).toUpperCase();
        document.getElementById('profile-avatar-large').src = userProfile.avatar || 'https://via.placeholder.com/80x80/FF6B35/FFFFFF?text=' + userProfile.name.charAt(0).toUpperCase();
    } else {
        // Hide profile
        userProfileDiv.classList.add('hidden');
        authButtons.classList.remove('hidden');
    }
}

// Toggle profile dropdown
function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown-content');
    dropdown.classList.toggle('show');
}

// Logout function
function logout() {
    localStorage.removeItem('userProfile');
    location.reload();
}

// Go to profile page
function goToProfile() {
    alert('Página de perfil ainda não implementada');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const profileDropdown = document.getElementById('profile-dropdown-content');
    const profileBtn = document.querySelector('.profile-btn');
    
    if (!profileDropdown.contains(event.target) && !profileBtn.contains(event.target)) {
        profileDropdown.classList.remove('show');
    }
});

// Update login form to save to localStorage
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Simulate login (replace with your real logic)
        if (email && password) {
            // Create user profile
            const userProfile = {
                name: email.split('@')[0], // Use part before @ as name
                email: email,
                avatar: null // Can be set later
            };

            // Save to localStorage
            localStorage.setItem('userProfile', JSON.stringify(userProfile));
            localStorage.setItem('isLoggedIn', 'true');

            // Close modal and reload page
            closeModal();
            location.reload();
        } else {
            alert('Por favor, preencha todos os campos.');
        }
    });
}

// Function to update profile after login
function updateProfileAfterLogin(userData) {
    // Save to localStorage
    localStorage.setItem('userProfile', JSON.stringify(userData));
    localStorage.setItem('isLoggedIn', 'true');

    // Update UI
    const userProfileDiv = document.getElementById('user-profile');
    const authButtons = document.getElementById('auth-buttons');

    if (userProfileDiv && authButtons) {
        userProfileDiv.classList.remove('hidden');
        authButtons.classList.add('hidden');

        // Fill profile data
        document.getElementById('profile-name').textContent = userData.name || 'Usuário';
        document.getElementById('profile-full-name').textContent = userData.name || 'Nome Completo';
        document.getElementById('profile-email').textContent = userData.email || 'email@exemplo.com';
        document.getElementById('profile-avatar').src = userData.avatar || 'https://via.placeholder.com/40x40/FF6B35/FFFFFF?text=U';
        document.getElementById('profile-avatar-large').src = userData.avatar || 'https://via.placeholder.com/80x80/FF6B35/FFFFFF?text=U';
    }
}

// Error Handling
window.addEventListener('error', (e) => {
    console.error('Erro no site:', e.error);
});

// Analytics (placeholder)
function trackEvent(eventName, properties = {}) {
    console.log('Evento:', eventName, properties);
    // Integração com Google Analytics ou outro serviço
}

// Track page views
trackEvent('page_view', {
    page: window.location.pathname,
    title: document.title
});

// Export functions for testing
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        searchNews,
        generateMockNews,
        debounce,
        loadRecentMovies,
        loadMockMovies
    };
}

// Top Games and Events Section
const topGamesEventsSection = document.createElement('section');
topGamesEventsSection.className = 'top-games-events container';
topGamesEventsSection.innerHTML = `
    <div class="top-games">
        <h2>Top Jogos</h2>
        <ul>
            <li><img src="img/game1.jpg" alt="Game 1"> <span>Game 1</span></li>
            <li><img src="img/game2.jpg" alt="Game 2"> <span>Game 2</span></li>
            <li><img src="img/game3.jpg" alt="Game 3"> <span>Game 3</span></li>
        </ul>
    </div>
    <div class="events">
        <h2>Agenda de Eventos</h2>
        <ul>
            <li><strong>20/08</strong> - Lançamento: Jogo X</li>
            <li><strong>25/08</strong> - Torneio eSports Y</li>
            <li><strong>01/09</strong> - Evento Z</li>
        </ul>
    </div>
`;

document.querySelector('.container').appendChild(topGamesEventsSection);

// Load Recent Movies from TMDB API
async function loadRecentMovies() {
    const apiKey = 'SUA_CHAVE_API_AQUI'; // Replace with your TMDB API key
    const url = `https://api.themoviedb.org/3/movie/now_playing?api_key=${apiKey}&language=pt-BR&page=1`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        const movies = data.results.slice(0, 6); // Get first 6 movies

        const moviesGrid = document.getElementById('movies-grid');
        moviesGrid.innerHTML = '';

        movies.forEach(movie => {
            const movieCard = document.createElement('article');
            movieCard.className = 'movie-card';
            movieCard.innerHTML = `
                <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="${movie.title}" onerror="this.src='https://via.placeholder.com/300x450/FF6B35/FFFFFF?text=Poster+Não+Disponível'">
                <div class="movie-content">
                    <h3>${movie.title}</h3>
                    <p>${movie.overview.substring(0, 100)}...</p>
                    <div class="movie-meta">
                        <span><i class="far fa-calendar"></i> ${new Date(movie.release_date).getFullYear()}</span>
                        <span><i class="far fa-star"></i> ${movie.vote_average.toFixed(1)}</span>
                    </div>
                </div>
            `;
            moviesGrid.appendChild(movieCard);
        });
    } catch (error) {
        console.error('Erro ao carregar filmes:', error);
        // Fallback to mock data
        loadMockMovies();
    }
}

// Mock Movies Data
function loadMockMovies() {
    const mockMovies = [
        {
            title: 'Filme Exemplo 1',
            overview: 'Descrição do filme exemplo 1.',
            release_date: '2023-01-01',
            vote_average: 8.5,
            poster_path: 'https://image.tmdb.org/t/p/w500/uDgy6hyPd82kOHh6I95FLtLnj6p.jpg'
        },
        {
            title: 'Filme Exemplo 2',
            overview: 'Descrição do filme exemplo 2.',
            release_date: '2023-02-01',
            vote_average: 7.8,
            poster_path: 'https://image.tmdb.org/t/p/w500/9UmkXtqL8SI?si=L6yOKt-P_w6XNFsH.jpg'
        },
        {
            title: 'Filme Exemplo 3',
            overview: 'Descrição do filme exemplo 3.',
            release_date: '2023-03-01',
            vote_average: 9.0,
            poster_path: 'https://image.tmdb.org/t/p/w500/q3U4AF7sGBo?si=7SgcU598PG4qtT5V.jpg'
        }
    ];

    const moviesGrid = document.getElementById('movies-grid');
    moviesGrid.innerHTML = '';

    mockMovies.forEach(movie => {
        const movieCard = document.createElement('article');
        movieCard.className = 'movie-card';
        movieCard.innerHTML = `
            <img src="${movie.poster_path}" alt="${movie.title}">
            <div class="movie-content">
                <h3>${movie.title}</h3>
                <p>${movie.overview}</p>
                <div class="movie-meta">
                    <span><i class="far fa-calendar"></i> ${new Date(movie.release_date).getFullYear()}</span>
                    <span><i class="far fa-star"></i> ${movie.vote_average}</span>
                </div>
            </div>
        `;
        moviesGrid.appendChild(movieCard);
    });
}
