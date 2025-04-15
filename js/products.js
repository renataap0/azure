// Dados dos produtos (simulando uma API)
const productsData = [
    {
        id: 1,
        name: "Creme Facial Hidratante",
        category: "skincare",
        price: 89.90,
        oldPrice: 99.90,
        image: "images/produtos/creme-facial.jpg",
        badge: "Novo",
        description: "Creme facial hidratante com ácido hialurônico para pele seca."
    },
    {
        id: 2,
        name: "Kit Maquiagem Profissional",
        category: "makeup",
        price: 249.90,
        oldPrice: 299.90,
        image: "images/produtos/kit-maquiagem.jpg",
        badge: "Oferta",
        description: "Kit completo com tudo que você precisa para uma maquiagem perfeita."
    },
    {
        id: 3,
        name: "Shampoo Revitalizante",
        category: "haircare",
        price: 59.90,
        image: "images/produtos/shampoo.jpg",
        description: "Shampoo para cabelos danificados com queratina e óleo de argan."
    },
    {
        id: 4,
        name: "Perfume Floral Elegante",
        category: "fragrances",
        price: 179.90,
        image: "images/produtos/perfume.jpg",
        badge: "Mais Vendido",
        description: "Fragrância floral com notas de jasmim e baunilha."
    },
    {
        id: 5,
        name: "Serum Facial Antienvelhecimento",
        category: "skincare",
        price: 129.90,
        oldPrice: 149.90,
        image: "images/produtos/serum-facial.jpg",
        description: "Serum com vitamina C e retinol para reduzir linhas de expressão."
    },
    {
        id: 6,
        name: "Batom Matte Vermelho",
        category: "makeup",
        price: 39.90,
        image: "images/produtos/batom.jpg",
        description: "Batom matte de longa duração na cor vermelho clássico."
    },
    {
        id: 7,
        name: "Condicionador Nutritivo",
        category: "haircare",
        price: 59.90,
        image: "images/produtos/condicionador.jpg",
        description: "Condicionador para cabelos secos e quebradiços."
    },
    {
        id: 8,
        name: "Água de Colônia Fresca",
        category: "fragrances",
        price: 99.90,
        image: "images/produtos/agua-colonia.jpg",
        description: "Fragrância fresca e suave para o dia a dia."
    }
];

// Carregar produtos na página
document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('productsContainer');
    
    if (productsContainer) {
        productsData.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.setAttribute('data-category', product.category);
            
            let badgeHTML = '';
            if (product.badge) {
                badgeHTML = `<span class="product-badge">${product.badge}</span>`;
            }
            
            let oldPriceHTML = '';
            if (product.oldPrice) {
                oldPriceHTML = `<span class="old-price">R$ ${product.oldPrice.toFixed(2)}</span>`;
            }
            
            productCard.innerHTML = `
                ${badgeHTML}
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="product-info">
                    <span class="product-category">${getCategoryName(product.category)}</span>
                    <h3 class="product-title">${product.name}</h3>
                    <div class="product-price">
                        <span class="current-price">R$ ${product.price.toFixed(2)}</span>
                        ${oldPriceHTML}
                    </div>
                    <p class="product-description">${product.description}</p>
                    <div class="product-actions">
                        <button class="add-to-cart">Adicionar ao Carrinho</button>
                        <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                    </div>
                </div>
            `;
            
            productsContainer.appendChild(productCard);
        });
    }
});

function getCategoryName(category) {
    const categories = {
        skincare: "Skincare",
        makeup: "Maquiagem",
        haircare: "Cuidados Capilares",
        fragrances: "Perfumes"
    };
    
    return categories[category] || category;
}