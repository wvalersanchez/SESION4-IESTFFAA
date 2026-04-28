<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PERSONA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>CRUD de Personas</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <button onclick="nuevoRegistro()" data-toggle="modal" data-target="#modalPersonaCreate" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <tr>
                                <td colspan="4" class="text-center">Cargando datos...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear/editar persona -->
    <div class="modal fade" tabindex="-1" id="modalPersonaCreate" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nueva Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="personaForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Nombre (*)</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Edad (*)</label>
                                    <input type="number" id="edad_persona" name="edad" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardar" onclick="submitForm()" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    let idEditar = null;

    $(document).ready(function() {
        listarPersonas();
    });

    function nuevoRegistro() {
        limpiarFormulario();
        $('#modalTitle').text('Nueva Persona');
        $('#btnGuardar').text('Guardar');
        idEditar = null;
    }

    function listarPersonas() {
        $.ajax({
            url: '../controlador/PersonaController.php?op=listar',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let html = '';
                if (data.length === 0) {
                    html = '<tr><td colspan="4" class="text-center">No hay registros</td></tr>';
                } else {
                    data.forEach((item, index) => {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${escapeHtml(item.nombre)}</td>
                                <td>${item.edad}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-warning btn-sm" onclick="editar(${item.id}, '${escapeHtml(item.nombre)}', ${item.edad})">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-sm" onclick="eliminar(${item.id})">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#tableBody').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Error al listar:', error);
                $('#tableBody').html('<tr><td colspan="4" class="text-center text-danger">Error al cargar datos</td></tr>');
            }
        });
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
        const edad = $('#edad_persona').val();

        if (!nombre || !edad) {
            alert('Por favor, complete todos los campos');
            return;
        }

        $.ajax({
            url: '../controlador/PersonaController.php?op=guardar',
            type: 'POST',
            data: {
                nombre: nombre,
                edad: edad
            },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    alert(res.message);
                    $('#modalPersonaCreate').modal('hide');
                    listarPersonas();
                    limpiarFormulario();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function() {
                alert('Error al conectar con el servidor');
            }
        });
    }

    function actualizar() {
        const nombre = $('#nombre').val().trim();
        const edad = $('#edad_persona').val();

        if (!nombre || !edad) {
            alert('Por favor, complete todos los campos');
            return;
        }

        $.ajax({
            url: '../controlador/PersonaController.php?op=actualizar',
            type: 'POST',
            data: {
                id: idEditar,
                nombre: nombre,
                edad: edad
            },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    alert(res.message);
                    $('#modalPersonaCreate').modal('hide');
                    listarPersonas();
                    limpiarFormulario();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function() {
                alert('Error al conectar con el servidor');
            }
        });
    }

    function editar(id, nombre, edad) {
        idEditar = id;
        $('#nombre').val(nombre);
        $('#edad_persona').val(edad);
        $('#modalTitle').text('Editar Persona');
        $('#btnGuardar').text('Actualizar');
        $('#modalPersonaCreate').modal('show');
    }

    function eliminar(id) {
        if (confirm('¿Está seguro de eliminar este registro?')) {
            $.ajax({
                url: '../controlador/PersonaController.php?op=eliminar',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        alert(res.message);
                        listarPersonas();
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function() {
                    alert('Error al conectar con el servidor');
                }
            });
        }
    }

    function limpiarFormulario() {
        $('#nombre').val('');
        $('#edad_persona').val('');
        idEditar = null;
    }

    // Función para prevenir XSS
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