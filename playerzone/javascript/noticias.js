// ====== MENU RESPONSIVO ======
const menuToggle = document.querySelector(".menu-toggle");
const navMenu = document.querySelector(".nav-menu");

if (menuToggle) {
  menuToggle.addEventListener("click", () => {
    navMenu.classList.toggle("active");
  });
}

// ====== FILTRO DE CATEGORIAS ======
const categoryLinks = document.querySelectorAll(".category-list a");
const newsItems = document.querySelectorAll(".news-item");

categoryLinks.forEach(link => {
  link.addEventListener("click", e => {
    e.preventDefault();
    const category = link.dataset.category;

    // remove active dos outros
    categoryLinks.forEach(l => l.classList.remove("active"));
    link.classList.add("active");

    // filtra notícias
    newsItems.forEach(item => {
      if (category === "all" || item.dataset.category === category) {
        item.style.display = "flex";
      } else {
        item.style.display = "none";
      }
    });
  });
});

// ====== ORDENAR NOTÍCIAS ======
const sortSelect = document.querySelector(".sort-select");

if (sortSelect) {
  sortSelect.addEventListener("change", () => {
    const value = sortSelect.value;
    const list = document.querySelector(".news-list");
    const items = Array.from(newsItems);

    items.sort((a, b) => {
      const viewsA = parseFloat(a.querySelector(".fa-eye").parentElement.textContent);
      const viewsB = parseFloat(b.querySelector(".fa-eye").parentElement.textContent);
      const commentsA = parseFloat(a.querySelector(".fa-comment").parentElement.textContent);
      const commentsB = parseFloat(b.querySelector(".fa-comment").parentElement.textContent);

      if (value === "popular") return viewsB - viewsA;
      if (value === "comments") return commentsB - commentsA;
      return 0; // mais recentes já estão na ordem
    });

    list.innerHTML = "";
    items.forEach(i => list.appendChild(i));
  });
}

// ====== PAGINAÇÃO SIMPLES ======
const paginationBtns = document.querySelectorAll(".pagination-btn");
paginationBtns.forEach(btn => {
  btn.addEventListener("click", () => {
    paginationBtns.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    // Aqui você poderia carregar via AJAX ou simular troca de página
    alert("Página " + btn.textContent + " carregada!");
  });
});
