<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema CRUD - IESTP FFAA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card-dashboard {
            transition: transform 0.3s;
            cursor: pointer;
        }
        .card-dashboard:hover {
            transform: translateY(-10px);
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="text-white">
                    <i class="fas fa-database"></i> Sistema CRUD
                </h1>
                <p class="text-white">Seleccione una opción para gestionar</p>
            </div>
        </div>
        
        <div class="row">
            <!-- Tarjeta de Personas -->
            <div class="col-md-6 mb-4">
                <div class="card card-dashboard shadow-lg" onclick="window.location.href='persona.php'">
                    <div class="card-body text-center">
                        <div class="icon-circle bg-primary text-white mx-auto">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h3 class="card-title">Gestión de Personas</h3>
                        <p class="card-text">Administrar registros de personas con operaciones CRUD</p>
                        <button class="btn btn-primary">
                            <i class="fas fa-arrow-right"></i> Ingresar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Tarjeta de Productos -->
            <div class="col-md-6 mb-4">
                <div class="card card-dashboard shadow-lg" onclick="window.location.href='productos.php'">
                    <div class="card-body text-center">
                        <div class="icon-circle bg-success text-white mx-auto">
                            <i class="fas fa-boxes fa-3x"></i>
                        </div>
                        <h3 class="card-title">Gestión de Productos</h3>
                        <p class="card-text">Administrar inventario de productos con operaciones CRUD</p>
                        <button class="btn btn-success">
                            <i class="fas fa-arrow-right"></i> Ingresar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas rápidas -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <i class="fas fa-chart-line"></i> Módulos Disponibles
                        </h5>
                        <div class="row text-center mt-3">
                            <div class="col-md-6">
                                <h3><i class="fas fa-users"></i> Personas</h3>
                                <p>CRUD completo de personas</p>
                            </div>
                            <div class="col-md-6">
                                <h3><i class="fas fa-boxes"></i> Productos</h3>
                                <p>CRUD completo de productos con control de stock</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>