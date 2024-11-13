@extends('layouts.app')

@section('title', 'Dreams Music Store - Tienda de Instrumentos Musicales')

@push('styles')
<style>
    /* Variables y estilos base */
    :root {
        --primary-color: #8B0000;
        --primary-color-rgb: 139, 0, 0;
        --secondary-color: #1a1a1a;
        --accent-color: #ff4444;
        --background-light: #f8f9fa;
        --text-dark: #343a40;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(145deg, var(--secondary-color), var(--primary-color));
        padding: 3rem 0;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('/img/music-pattern.png') repeat;
        opacity: 0.1;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-content h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .hero-content p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Stats Section */
    .stats-section {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
    }

    /* Filtros y búsqueda */
    .filters-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 2.5rem;
        border-radius: 25px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        height: 45px;
    }

    .search-box input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .form-select {
        border-radius: 25px;
        height: 45px;
        border: 2px solid #e9ecef;
        padding-left: 1rem;
        background-position: right 1rem center;
    }

    /* Grid de productos */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 0.5rem;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .product-image {
        position: relative;
        padding-top: 75%;
        background: var(--background-light);
        overflow: hidden;
    }

    .product-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
        padding: 1rem;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-badges {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        z-index: 1;
    }

    .product-content {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .product-description {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .stock-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .stock-high {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .stock-low {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .product-action {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
    }

    .btn-cart {
        flex: 1;
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-cart:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .btn-wishlist {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background-color: rgba(var(--primary-color-rgb), 0.1);
        color: var(--primary-color);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-wishlist:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Loading state */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        visibility: hidden;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .loading-overlay.active {
        visibility: visible;
        opacity: 1;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-section {
            padding: 2rem 0;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stat-item {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 hero-content">
                <h1>Dream Store</h1>
                <p>Descubre nuestros productos de alta calidad</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    {{-- <!-- Estadísticas -->
    <div class="stats-section">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['total_products'] }}</div>
                    <div class="stat-label">Productos Disponibles</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <div class="stat-number">${{ number_format($stats['total_value'], 2) }}</div>
                    <div class="stat-label">Valor en Inventario</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['low_stock_products'] }}</div>
                    <div class="stat-label">Productos con Stock Bajo</div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Filtros y Búsqueda -->
    <div class="filters-section">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" id="searchProducts" placeholder="Buscar productos...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="sortProducts">
                    <option value="">Ordenar por</option>
                    <option value="price_asc">Precio: Menor a Mayor</option>
                    <option value="price_desc">Precio: Mayor a Menor</option>
                    <option value="name">Nombre</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterStock">
                    <option value="">Filtrar por stock</option>
                    <option value="in_stock">En stock</option>
                    <option value="low_stock">Stock bajo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Grid de Productos -->
    <div class="products-grid" id="productsContainer">
        @forelse($products as $product)
            <div class="product-card">
                <div class="product-image">
                    <div class="product-badges">
                        @if($product->stock < 10)
                            <span class="badge bg-danger">¡Últimas unidades!</span>
                        @endif
                    </div>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="product-content">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                    <div class="stock-badge {{ $product->stock > 10 ? 'stock-high' : 'stock-low' }}">
                        <i class="fas fa-box"></i> {{ $product->stock }} disponibles
                    </div>
                    <div class="product-action">
                        <button class="btn btn-cart" onclick="addToCart({{ $product->id }})">
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                        <button class="btn btn-wishlist" onclick="addToWishlist({{ $product->id }})">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-guitar fa-3x mb-3 text-muted"></i>
                <h3>No hay productos disponibles</h3>
                <p class="text-muted">Vuelve más tarde para ver nuestra colección de instrumentos</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    let searchTimeout = null;

    // Búsqueda de productos con debounce
    const searchInput = document.getElementById('searchProducts');
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => performSearch(), 300);
    });

    // Ordenar productos
    const sortSelect = document.getElementById('sortProducts');
    sortSelect.addEventListener('change', performSearch);

    // Filtrar por stock
    const stockFilter = document.getElementById('filterStock');
    stockFilter.addEventListener('change', performSearch);

    function showLoading() {
        loadingOverlay.classList.add('active');
    }

    function hideLoading() {
        loadingOverlay.classList.remove('active');
    }

    function performSearch() {
        const searchTerm = searchInput.value;
        const sortValue = sortSelect.value;
        const stockValue = stockFilter.value;

        showLoading();

        const params = new URLSearchParams({
            query: searchTerm,
            sort: sortValue,
            stock: stockValue
        });

        fetch(`{{ route('shop.search') }}?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateProductsGrid(data.products);
            }
        })
        .finally(() => {
            hideLoading();
        });
    }
});

function updateProductsGrid(products) {
    const container = document.getElementById('productsContainer');
    
    if (products.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-guitar fa-3x mb-3 text-muted"></i>
                <h3>No se encontraron productos</h3>
                <p class="text-muted">Intenta con otros criterios de búsqueda</p>
            </div>
        `;
        return;
    }

    container.innerHTML = products.map(product => `
        <div class="product-card">
            <div class="product-image">
                ${product.stock < 10 ? 
                    '<div class="product-badges"><span class="badge bg-danger">¡Últimas unidades!</span></div>' 
                    : ''}
                <img src="${window.location.origin}/storage/${product.image}" alt="${product.name}">
            </div>
            <div class="product-content">
                <h3 class="product-title">${product.name}</h3>
                <div class="product-price">$${parseFloat(product.price).toLocaleString('es-MX', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })}</div>
                <p class="product-description">${product.description.substring(0, 100)}...</p>
                <div class="stock-badge ${product.stock > 10 ? 'stock-high' : 'stock-low'}">
                    <i class="fas fa-box"></i> ${product.stock} disponibles
                </div>
                <div class="product-action">
                    <button class="btn btn-cart" onclick="addToCart(${product.id})">
                        <i class="fas fa-cart-plus"></i> Agregar
                    </button>
                    <button class="btn btn-wishlist" onclick="addToWishlist(${product.id})">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

function addToCart(productId) {
    fetch(`{{ route('shop.cart.add', '') }}/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: '¡Agregado!',
                text: 'El producto se ha agregado al carrito',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                position: 'top-end',
                toast: true
            });
            // Aquí podrías actualizar el contador del carrito si lo tienes
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error',
            text: 'No se pudo agregar el producto al carrito',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500,
            position: 'top-end',
            toast: true
        });
    });
}

function addToWishlist(productId) {
    const button = event.currentTarget;
    const icon = button.querySelector('i');
    
    fetch(`{{ route('shop.wishlist.add', '') }}/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            icon.classList.toggle('far');
            icon.classList.toggle('fas');
            
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                title: data.message,
                icon: 'success'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            title: 'Error al agregar a favoritos',
            icon: 'error'
        });
    });
}
</script>
@endpush