<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stock-bajo {
            background-color: #ffcccc !important;
            font-weight: bold;
        }
        .stock-normal {
            background-color: #ccffcc !important;
        }
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .badge-stock {
            font-size: 12px;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div id="loading" class="loading">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>

        <div class="card shadow-lg">
            <div class="card-header">
                <h3 class="mb-0">
                    <i class="fas fa-boxes"></i> Gestión de Productos
                </h3>
            </div>
            
            <div class="card-body">
                <!-- Dashboard de estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Productos</h5>
                                <h2 id="totalProductos">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Valor Inventario</h5>
                                <h2 id="valorInventario">S/ 0.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Stock Bajo (≤10)</h5>
                                <h2 id="stockBajo">0</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barra de herramientas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button onclick="nuevoProducto()" data-toggle="modal" data-target="#modalProductoCreate" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nuevo Producto
                        </button>
                        <button onclick="recargarTabla()" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> Recargar
                        </button>
                        <button onclick="verBajoStock()" class="btn btn-warning">
                            <i class="fas fa-exclamation-triangle"></i> Ver Stock Bajo
                        </button>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="buscador" class="form-control" placeholder="Buscar producto...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" onclick="buscarProducto()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tabla de productos -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Cargando...</span>
                                    </div>
                                    <br>Cargando productos...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear/editar producto -->
    <div class="modal fade" id="modalProductoCreate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-box-open"></i> Nuevo Producto
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="productoForm">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><i class="fas fa-tag"></i> Nombre <span class="text-danger">*</span></label>
                                    <input type="text" id="nombre" class="form-control" placeholder="Ej: Laptop HP" maxlength="100">
                                    <small class="text-muted">Mínimo 3 caracteres</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><i class="fas fa-align-left"></i> Descripción</label>
                                    <textarea id="descripcion" class="form-control" rows="3" placeholder="Descripción del producto"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-dollar-sign"></i> Precio <span class="text-danger">*</span></label>
                                    <input type="number" id="precio" class="form-control" placeholder="0.00" step="0.01" min="0.01">
                                    <small class="text-muted">Precio en soles (S/)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fas fa-cubes"></i> Stock <span class="text-danger">*</span></label>
                                    <input type="number" id="stock" class="form-control" placeholder="0" min="0">
                                    <small class="text-muted">Cantidad en inventario</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="button" id="btnGuardar" onclick="submitForm()" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    let idEditar = null;
    let datosOriginales = [];

    $(document).ready(function() {
        listarProductos();
        cargarEstadisticas();
        
        // Validaciones en tiempo real
        $('#nombre').on('input', function() {
            if ($(this).val().length < 3 && $(this).val().length > 0) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        $('#precio').on('input', function() {
            if ($(this).val() <= 0) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        $('#buscador').on('keypress', function(e) {
            if (e.which === 13) {
                buscarProducto();
            }
        });
    });

    function mostrarLoading(mostrar) {
        if (mostrar) {
            $('#loading').css('display', 'block');
        } else {
            $('#loading').css('display', 'none');
        }
    }

    function cargarEstadisticas() {
        $.ajax({
            url: '../controlador/ProductoController.php?op=total',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#totalProductos').text(data.total || 0);
                $('#valorInventario').text('S/ ' + (parseFloat(data.valorInventario).toFixed(2)));
            }
        });
        
        // Contar productos con bajo stock
        $.ajax({
            url: '../controlador/ProductoController.php?op=bajoStock&limite=10',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#stockBajo').text(data.length || 0);
            }
        });
    }

    function listarProductos() {
        mostrarLoading(true);
        $.ajax({
            url: '../controlador/ProductoController.php?op=listar',
            type: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(data) {
                datosOriginales = data;
                renderizarTabla(data);
                mostrarLoading(false);
            },
            error: function() {
                mostrarLoading(false);
                Swal.fire('Error', 'No se pudieron cargar los productos', 'error');
                $('#tableBody').html('<tr><td colspan="7" class="text-center text-danger">❌ Error al cargar datos</td></tr>');
            }
        });
    }

    function renderizarTabla(data) {
        let html = '';
        if (data.length === 0) {
            html = '<tr><td colspan="7" class="text-center">📭 No hay productos registrados</td></tr>';
        } else {
            data.forEach((item, index) => {
                let stockClass = item.stock <= 10 ? 'stock-bajo' : '';
                let stockStatus = item.stock <= 5 ? 'danger' : (item.stock <= 10 ? 'warning' : 'success');
                let stockText = item.stock <= 5 ? 'Crítico' : (item.stock <= 10 ? 'Bajo' : 'Normal');
                
                html += `
                    <tr class="${stockClass}">
                        <td>${item.id_producto}</td>
                        <td><strong>${escapeHtml(item.nombre)}</strong></td>
                        <td>${escapeHtml(item.descripcion) || '-'}</td>
                        <td class="text-right">S/ ${parseFloat(item.precio).toFixed(2)}</td>
                        <td class="text-center">
                            <span class="badge badge-${stockStatus} badge-stock">
                                ${item.stock} unidades
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-${stockStatus}">
                                ${stockText}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-warning btn-sm" onclick="editar(${item.id_producto}, '${escapeHtml(item.nombre)}', '${escapeHtml(item.descripcion || '')}', ${item.precio}, ${item.stock})" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-info btn-sm" onclick="verDetalle(${item.id_producto})" title="Ver detalle">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminar(${item.id_producto})" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        $('#tableBody').html(html);
    }

    function buscarProducto() {
        const termino = $('#buscador').val().toLowerCase();
        if (termino === '') {
            renderizarTabla(datosOriginales);
        } else {
            const filtrados = datosOriginales.filter(item => 
                item.nombre.toLowerCase().includes(termino) ||
                (item.descripcion && item.descripcion.toLowerCase().includes(termino))
            );
            renderizarTabla(filtrados);
        }
    }

    function verBajoStock() {
        const bajoStock = datosOriginales.filter(item => item.stock <= 10);
        if (bajoStock.length === 0) {
            Swal.fire('Sin productos', 'No hay productos con stock bajo', 'info');
        } else {
            renderizarTabla(bajoStock);
            Swal.fire('Stock bajo', `Mostrando ${bajoStock.length} productos con stock ≤ 10 unidades`, 'warning');
        }
    }

    function recargarTabla() {
        $('#buscador').val('');
        listarProductos();
        cargarEstadisticas();
        Swal.fire('Actualizado', 'Los datos han sido recargados', 'success');
    }

    function nuevoProducto() {
        limpiarFormulario();
        $('#modalTitle').html('<i class="fas fa-box-open"></i> Nuevo Producto');
        $('#btnGuardar').html('<i class="fas fa-save"></i> Guardar');
        idEditar = null;
    }

    function submitForm() {
        if (idEditar === null) {
            guardar();
        } else {
            actualizar();
        }
    }

    function guardar() {
        const nombre = $('#nombre').val().trim();
        const descripcion = $('#descripcion').val().trim();
        const precio = parseFloat($('#precio').val());
        const stock = parseInt($('#stock').val());

        if (!nombre || nombre.length < 3) {
            Swal.fire('Error', 'El nombre debe tener al menos 3 caracteres', 'warning');
            return;
        }
        
        if (isNaN(precio) || precio <= 0) {
            Swal.fire('Error', 'El precio debe ser mayor a 0', 'warning');
            return;
        }
        
        if (isNaN(stock) || stock < 0) {
            Swal.fire('Error', 'El stock no puede ser negativo', 'warning');
            return;
        }

        mostrarLoading(true);
        $.ajax({
            url: '../controlador/ProductoController.php?op=guardar',
            type: 'POST',
            data: { nombre, descripcion, precio, stock },
            dataType: 'json',
            success: function(res) {
                mostrarLoading(false);
                if (res.status) {
                    Swal.fire('¡Éxito!', res.message, 'success');
                    $('#modalProductoCreate').modal('hide');
                    listarProductos();
                    cargarEstadisticas();
                    limpiarFormulario();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                mostrarLoading(false);
                Swal.fire('Error', 'Error al conectar con el servidor', 'error');
            }
        });
    }

    function actualizar() {
        const nombre = $('#nombre').val().trim();
        const descripcion = $('#descripcion').val().trim();
        const precio = parseFloat($('#precio').val());
        const stock = parseInt($('#stock').val());

        if (!nombre || nombre.length < 3) {
            Swal.fire('Error', 'El nombre debe tener al menos 3 caracteres', 'warning');
            return;
        }
        
        if (isNaN(precio) || precio <= 0) {
            Swal.fire('Error', 'El precio debe ser mayor a 0', 'warning');
            return;
        }

        mostrarLoading(true);
        $.ajax({
            url: '../controlador/ProductoController.php?op=actualizar',
            type: 'POST',
            data: { id: idEditar, nombre, descripcion, precio, stock },
            dataType: 'json',
            success: function(res) {
                mostrarLoading(false);
                if (res.status) {
                    Swal.fire('¡Actualizado!', res.message, 'success');
                    $('#modalProductoCreate').modal('hide');
                    listarProductos();
                    cargarEstadisticas();
                    limpiarFormulario();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                mostrarLoading(false);
                Swal.fire('Error', 'Error al conectar con el servidor', 'error');
            }
        });
    }

    function editar(id, nombre, descripcion, precio, stock) {
        idEditar = id;
        $('#nombre').val(nombre);
        $('#descripcion').val(descripcion);
        $('#precio').val(precio);
        $('#stock').val(stock);
        $('#modalTitle').html('<i class="fas fa-edit"></i> Editar Producto');
        $('#btnGuardar').html('<i class="fas fa-update"></i> Actualizar');
        $('#modalProductoCreate').modal('show');
    }

    function verDetalle(id) {
        $.ajax({
            url: `../controlador/ProductoController.php?op=buscar&id=${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(producto) {
                Swal.fire({
                    title: producto.nombre,
                    html: `
                        <div class="text-left">
                            <p><strong>📝 Descripción:</strong> ${producto.descripcion || 'Sin descripción'}</p>
                            <p><strong>💰 Precio:</strong> S/ ${parseFloat(producto.precio).toFixed(2)}</p>
                            <p><strong>📦 Stock:</strong> ${producto.stock} unidades</p>
                            <p><strong>📅 Fecha creación:</strong> ${producto.fecha_creacion}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Cerrar'
                });
            }
        });
    }

    function eliminar(id) {
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                mostrarLoading(true);
                $.ajax({
                    url: '../controlador/ProductoController.php?op=eliminar',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(res) {
                        mostrarLoading(false);
                        if (res.status) {
                            Swal.fire('¡Eliminado!', res.message, 'success');
                            listarProductos();
                            cargarEstadisticas();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        mostrarLoading(false);
                        Swal.fire('Error', 'Error al conectar con el servidor', 'error');
                    }
                });
            }
        });
    }

    function limpiarFormulario() {
        $('#nombre').val('');
        $('#descripcion').val('');
        $('#precio').val('');
        $('#stock').val('');
        $('#nombre').removeClass('is-invalid');
        $('#precio').removeClass('is-invalid');
        idEditar = null;
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
    </script>
</body>

</html>