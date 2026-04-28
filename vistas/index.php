<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APRENDIENDO FOMRULARIOS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script>
        console.log('Dentro del cosole ,log');
    </script>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <label class="control-label">Construyendo mi formulario</label>
        </div>
        <div class="card-body">
            <form method="post" autocomplete="off">
                <div class="col col-md-12">
                    <button type="submit" class="btn btn-success"> <i class="fas fa-save"></i> save</button>
                </div>
                <div class="row">
                    <!-- input de tipo radio para el estado (activo - inactivo) -->
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            radio button
                        </label>
                    </div>
                    <!-- checkboxs para el estado (activo - inactivo) -->
                    <div class="col col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                checkbox
                            </label>
                        </div>
                    </div>
                    <!-- input de tipo file, carga de archivos -->
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label class="control-label">Subir archivo</label>
                            <input type="file" class="form-control" name="imagen_producto" id="imagen_producto" accept=".png,.jpg,.jpeg" />
                        </div>
                    </div>
                    <!-- input de tipo color -->
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label class="control-label">Colores html</label>
                            <input type="color" class="form-control" name="color_producto" id="color_producto" required />
                        </div>
                    </div>
                    <!-- input de tipo email -->
                    <div class="col col-md-6">
                        <div class="form-group">
                            <label class="control-label">Correo electronico</label>
                            <input type="email" class="form-control" name="email" id="email" required />
                        </div>
                    </div>
                    <!-- input de tipo texto para el nombre -->
                    <div class="col col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre_producto" required />
                        </div>
                    </div>
                    <!-- input de tipo password o contraseña -->
                    <div class="col col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" value="" class="form-control" name="password" id="password" required />
                        </div>
                    </div>
                    <!-- input de tipo numerico para el precio -->
                    <div class="col col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Precio (S/)</label>
                            <input class="form-control" type="number" name="precio" id="precio_producto" required />
                        </div>
                    </div>
                    <!-- input de tipo select -->
                    <div class="col col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Categorias</label>
                            <select id="categoria_producto" name="categoria_producto" class="form-control" required>
                                <option>POLLOS</option>
                                <option>GRANEL</option>
                                <option>DULCES</option>
                                <option>BEBIDAS</option>
                            </select>
                        </div>
                    </div>
                    <!-- texte area, detalles del producto -->
                    <!-- <div class="col col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Text area</label>
                            <textarea class="form-control" name="descripcion" id="descripcion_producto" />
                        </div>
                    </div> -->
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <div class="card">
                <button type="button" class="btn btn-success"><i class="fas fa-plus"> Nuevo</i></button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">nombre</th>
                        <th scope="col">precio</th>
                        <th scope="col">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>s/12</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-sm"> <i class="fas fa-edit"> Editar</i></button>
                                <button type="button" class="btn btn-danger btn-sm"> <i class="fas fa-trash"> Eliminar</i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-sm"> <i class="fas fa-edit"> Editar</i></button>
                                <button type="button" class="btn btn-danger btn-sm"> <i class="fas fa-trash"> Eliminar</i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-sm"> <i class="fas fa-edit"> Editar</i></button>
                                <button type="button" class="btn btn-danger btn-sm"> <i class="fas fa-trash"> Eliminar</i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</body>

</html>