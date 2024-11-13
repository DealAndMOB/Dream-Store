@extends('layouts.app')

@section('title', 'Gestión de Productos - Dreams Music Store')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* Variables de color */
    :root {
        --primary-color: #8B0000;
        --primary-color-rgb: 139, 0, 0;
        --secondary-color: #1a1a1a;
        --accent-color: #ff4444;
        --background-light: #f8f9fa;
        --text-dark: #343a40;
    }
    
    /* Estilos para las cards */
    .card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 1.5rem;
        background: white;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .card-header {
        background: linear-gradient(145deg, var(--secondary-color), var(--primary-color));
        color: white;
        border-bottom: none;
        padding: 1rem 1.5rem;
        border-radius: 12px 12px 0 0;
    }
    
    /* Estilos para la tabla */
    .table {
        margin-bottom: 0;
    }

    .table th {
        background-color: var(--background-light);
        color: var(--text-dark);
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table td {
        vertical-align: middle;
    }

    /* Estilos para las imágenes en la tabla */
    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .product-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    /* Estilos para badges y estados */
    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 30px;
    }

    .badge.bg-success.bg-opacity-10 {
        background-color: rgba(25, 135, 84, 0.1) !important;
        color: #198754 !important;
    }

    /* Botones de acción */
    .btn-group .btn {
        padding: 0.5rem;
        margin: 0 0.2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-action-edit {
        background-color: rgba(var(--primary-color-rgb), 0.1);
        color: var(--primary-color);
    }

    .btn-action-edit:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(var(--primary-color-rgb), 0.2);
    }

    .btn-action-delete {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .btn-action-delete:hover {
        background-color: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
    }
    
    /* Área de drop de imágenes */
    .drop-zone {
        width: 100%;
        min-height: 200px;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: var(--background-light);
    }

    .drop-zone:hover {
        border-color: var(--primary-color);
        background-color: #fff;
    }

    .drop-zone__prompt {
        text-align: center;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .drop-zone__input {
        display: none;
    }

    .drop-zone__thumb {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: absolute;
    }

    /* Estilos para el panel de estadísticas */
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .stats-icon:hover {
        transform: scale(1.1);
    }

    /* Estilos para los modales */
    .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(145deg, var(--secondary-color), var(--primary-color));
        color: white;
        border: none;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    /* Form controls */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.6rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.1);
    }

    /* Switch personalizado */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Animaciones */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    .btn-cuadr {
        border-radius: 30px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        background-color: var(--primary-color);
        color: white;
        transition: all 0.3s ease;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            gap: 1rem;
        }

        .stats-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Lista de Productos -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-box me-2"></i>
                        Gestión de Productos
                    </h5>
                    <button class="btn btn-light" onclick="showCreateModal()">
                        <i class="fas fa-plus me-2"></i>
                        Nuevo Producto
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Producto</th>
                                    <th class="px-4 py-3">Precio</th>
                                    <th class="px-4 py-3">Stock</th>
                                    <th class="px-4 py-3">Estado</th>
                                    <th class="px-4 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="product-img me-3">
                                                <img src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}">
                                            </div>
                                            <div class="product-info">
                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                                <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $product->stock }}
                                            </span>
                                            <button class="btn btn-link btn-sm p-0 text-primary" 
                                                    onclick="showStockModal({{ $product->id }})">
                                                <i class="fas fa-boxes"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                   onchange="toggleStatus({{ $product->id }})"
                                                   {{ $product->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="btn-group">
                                            <button class="btn btn-action-edit" 
                                                    onclick="showEditModal({{ $product->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-action-delete" 
                                                    onclick="confirmDelete({{ $product->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-box fa-3x mb-3"></i>
                                            <p>No hay productos registrados</p>
                                            <button class="btn btn-sm btn-cuadr" onclick="showCreateModal()">
                                                Agregar Producto
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Estadísticas -->
        <div class="col-lg-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted mb-4">Resumen de Productos</h6>
                            <div class="row g-4">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                            <i class="fas fa-box text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Total Productos</small>
                                            <span class="fw-bold">{{ $products->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                            <i class="fas fa-check text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Productos Activos</small>
                                            <span class="fw-bold">{{ $products->where('is_active', true)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Stock Bajo</small>
                                            <span class="fw-bold">{{ $products->where('stock', '<', 10)->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Producto -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="productForm" onsubmit="handleSubmit(event)">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="drop-zone rounded-3">
                                <span class="drop-zone__prompt">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <br>Arrastra o selecciona una imagen
                                </span>
                                <input type="file" name="image" class="drop-zone__input" accept="image/*">
                            </div>
                            <small class="text-muted d-block mt-2 text-center">
                                Formatos: JPG, PNG, GIF, WEBP, SVG, BMP<br>
                                Tamaño máximo: 5MB
                            </small>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="description" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="price" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Stock Inicial</label>
                                    <input type="number" class="form-control" name="stock" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-cuadr">
                        <i class="fas fa-save me-2"></i>
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Stock -->
<div class="modal fade" id="stockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h6 class="product-name mb-2"></h6>
                    <span class="badge bg-primary current-stock">Stock Actual: 0</span>
                </div>
                <form id="stockForm" onsubmit="handleStockUpdate(event)">
                    <div class="mb-3">
                        <label class="form-label">Operación</label>
                        <select class="form-select" name="operation" required>
                            <option value="add">Agregar al stock</option>
                            <option value="subtract">Restar del stock</option>
                            <option value="set">Establecer stock</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" class="form-control" name="stock" min="0" required>
                    </div>
                    <input type="hidden" name="product_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="stockForm" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Actualizar Stock
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let productModal;
let stockModal;
let currentProductId = null;

document.addEventListener('DOMContentLoaded', function() {
    productModal = new bootstrap.Modal(document.getElementById('productModal'));
    stockModal = new bootstrap.Modal(document.getElementById('stockModal'));
    initializeDropZones();
});

function showCreateModal() {
    currentProductId = null;
    document.getElementById('productForm').reset();
    document.querySelector('#modalTitle').textContent = 'Nuevo Producto';
    
    // Limpiar y reiniciar la zona de drop de imagen
    const dropZone = document.querySelector('.drop-zone');
    
    // Primero, guardar una referencia al input
    const input = dropZone.querySelector('.drop-zone__input');
    
    // Limpiar todo el contenido del dropZone
    dropZone.innerHTML = '';
    
    // Volver a añadir el input
    dropZone.appendChild(input);
    
    // Crear y añadir el nuevo prompt
    const prompt = document.createElement('span');
    prompt.className = 'drop-zone__prompt';
    prompt.innerHTML = '<i class="fas fa-cloud-upload-alt fa-2x mb-2"></i><br>Arrastra o selecciona una imagen';
    dropZone.appendChild(prompt);
    
    productModal.show();
}

function showEditModal(id) {
    currentProductId = id;
    document.querySelector('#modalTitle').textContent = 'Editar Producto';
    
    fetch(`/admin/gestion-productos/show/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const form = document.getElementById('productForm');
                const product = data.product;
                form.name.value = product.name;
                form.description.value = product.description;
                form.price.value = product.price;
                form.stock.value = product.stock;
                
                // Actualizar la vista previa de la imagen
                if (product.image) {
                    const dropZone = form.querySelector('.drop-zone');
                    updateThumbnail(dropZone, null, `${window.location.origin}/storage/${product.image}`);
                }
                
                productModal.show();
            }
        });
}

function showStockModal(id) {
    fetch(`/admin/gestion-productos/show/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('#stockModal .product-name').textContent = data.product.name;
                document.querySelector('#stockModal .current-stock').textContent = `Stock Actual: ${data.product.stock}`;
                document.querySelector('#stockForm [name="product_id"]').value = id;
                stockModal.show();
            }
        });
}

function handleSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const url = currentProductId 
        ? `/admin/gestion-productos/update/${currentProductId}`
        : '/admin/gestion-productos/store';

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            productModal.hide();
            Swal.fire({
                icon: 'success',
                title: 'Excelente!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.reload();
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud'
        });
    });
}

function handleStockUpdate(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const productId = formData.get('product_id');

    fetch(`/admin/gestion-productos/update-stock/${productId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            stockModal.hide();
            Swal.fire({
                icon: 'success',
                title: '¡Stock Actualizado!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.reload();
            });
        }
    });
}

function toggleStatus(id) {
    fetch(`/admin/gestion-productos/toggle-status/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            toast.fire({
                icon: 'success',
                title: data.message
            });
        }
    });
}

function confirmDelete(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/gestion-productos/destroy/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
}

function initializeDropZones() {
    document.querySelectorAll(".drop-zone__input").forEach(inputElement => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        dropZoneElement.addEventListener("click", e => {
            inputElement.click();
        });

        inputElement.addEventListener("change", e => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", e => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach(type => {
            dropZoneElement.addEventListener(type, e => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", e => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }

            dropZoneElement.classList.remove("drop-zone--over");
        });
    });
}

function updateThumbnail(dropZoneElement, file, existingImageUrl = null) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // Eliminar el prompt si existe
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // Si no existe el thumbnail, créalo
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    // Si tenemos una URL existente
    if (existingImageUrl) {
        thumbnailElement.style.backgroundImage = `url('${existingImageUrl}')`;
        thumbnailElement.dataset.label = 'Imagen actual';
    }
    // Si tenemos un archivo nuevo
    else if (file) {
        thumbnailElement.dataset.label = file.name;

        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        }
    }
}
</script>
@endpush

@endsection