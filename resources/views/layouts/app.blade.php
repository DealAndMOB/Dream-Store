<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dreams Music Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')
    <style>
      :root {
    --primary-color: #8B0000;
    --secondary-color: #1a1a1a;
    --background-color: #f5f5f5;
    --sidebar-width: 280px;
    --header-height: 80px;
    }

    body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        background-color: var(--background-color);
        overflow-x: hidden;
        position: relative;
        padding-bottom: 80px; /* Altura del footer */
    }

    /* Header Styles */
    .main-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: var(--header-height);
        background-color: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        z-index: 1030;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 2rem;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.5rem;
        border-radius: 15px;
        background: white;
        transition: transform 0.3s ease;
    }

    .logo-container:hover {
        transform: translateY(-2px);
    }

    .main-header img, .mobile-header img {
        height: 55px;
        width: auto;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        top: calc(var(--header-height) + 20px);
        left: 20px;
        height: calc(100vh - var(--header-height) - 120px); /* Reducida para dejar espacio al footer */
        width: var(--sidebar-width);
        background: var(--primary-color);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        z-index: 1040;
        box-shadow: 0 4px 25px rgba(0,0,0,0.1);
    }

    .sidebar:hover {
        transform: translateX(5px);
    }

    .sidebar-nav {
        padding: 1rem 0;
    }

    .sidebar-nav .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
        margin-bottom: 0.8rem;
        position: relative;
        overflow: hidden;
    }

    .sidebar-nav .nav-link:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: white;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .sidebar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white !important;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .sidebar-nav .nav-link:hover:before {
        transform: translateX(0);
    }

    .sidebar-nav .nav-link i {
        width: 24px;
        text-align: center;
        font-size: 1.2em;
        transition: transform 0.3s ease;
        color: rgba(255, 255, 255, 0.9);
    }

    .sidebar-nav .nav-link:hover i {
        transform: scale(1.1);
        color: white;
    }

    /* Mobile Header */
    .mobile-header {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: var(--header-height);
        background-color: white;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        z-index: 1030;
        padding: 0 1rem;
        justify-content: space-between;
        align-items: center;
    }

    /* Main Content */
    .main-content {
        margin-left: calc(var(--sidebar-width) + 40px);
        margin-top: calc(var(--header-height) + 20px);
        padding: 2rem;
        min-height: calc(100vh - var(--header-height) - 180px); /* Ajustado para el footer */
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0,0,0,0.1);
        margin-right: 20px;
        margin-bottom: 20px; /* Espacio para el footer */
        animation: fadeIn 0.5s ease;
    }

    /* Footer */
    footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: var(--primary-color);
        color: white;
        padding: 1.5rem;
        z-index: 1020;
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .main-header {
            display: none;
        }

        .sidebar {
            transform: translateX(-100%);
            left: 0;
            top: var(--header-height);
            height: calc(100vh - var(--header-height));
            border-radius: 0;
            margin: 0;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .mobile-header {
            display: flex;
        }

        .mobile-header .logo-container {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .main-content {
            margin-left: 20px;
            margin-top: calc(var(--header-height) + 20px);
            margin-bottom: 100px; /* Espacio para el footer en móvil */
        }

        footer {
            margin-left: 0;
        }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1039;
        }

        .mobile-menu-overlay.show {
            display: block;
        }
    }

    /* Botones y elementos interactivos */
    .btn-header {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.3s ease;
        color: var(--secondary-color);
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .btn-header:hover {
        background-color: #f8f9fa;
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    /* Animaciones adicionales */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    </style>
</head>
<body>
  <!-- Main Header (Desktop) -->
  <header class="main-header">
    <div class="logo-container">
        <img src="{{ asset('images/logo-dreams.png') }}" alt="Dreams Music Store">
    </div>
</header>

<!-- Mobile Header -->
<header class="mobile-header">
    <button class="btn btn-header" onclick="toggleSidebar()">
        <i class="fas fa-bars fa-lg"></i>
    </button>
    <div class="logo-container">
        <img src="{{ asset('images/logo-dreams.png') }}" alt="Dreams Music Store">
    </div>
    <a class="btn btn-header" href="#">
        <i class="fas fa-shopping-cart fa-lg"></i>
    </a>
</header>

<!-- Sidebar -->
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-tags"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#adminSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="adminSubmenu">
                    <i class="fas fa-user-cog"></i>
                    <span>Admin</span>
                </a>
                <div class="collapse" id="adminSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">
                                <i class="fas fa-box"></i>
                                <span>Gestión Productos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Carrito</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" onclick="toggleSidebar()"></div>

<!-- Main Content -->
<main class="main-content">
    @yield('content')
</main>

<!-- Footer -->
<footer class="text-center">
    <p class="mb-0">&copy; 2024 Dreams Music Store. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts adicionales -->
@stack('scripts')

<script>
    function toggleSidebar() {
        document.querySelector('.sidebar').classList.toggle('show');
        document.querySelector('.mobile-menu-overlay').classList.toggle('show');
    }

    // Mantener activo el submenú si estamos en una ruta de admin
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.pathname.includes('/admin/')) {
            document.querySelector('#adminSubmenu').classList.add('show');
        }
    });
</script>
</body>
</html>