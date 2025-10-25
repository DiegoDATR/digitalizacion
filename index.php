<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
include 'config/bd.php'; // Conexión a la base de datos
$conexion = conexion();
$nombreArchivo = isset($_POST['nombreArchivo']) ? trim($_POST['nombreArchivo']) : null;
$query = listar1($conexion, $nombreArchivo);
if ($query->num_rows === 0) {
    echo "<div class='alert alert-warning text-center w-50 mx-auto mt-3'>No se encontraron resultados para \"<strong>" . htmlspecialchars($nombreArchivo) . "</strong>\".</div>";
}
$nombreArchivo = isset($_POST['nombreArchivo']) ? trim($_POST['nombreArchivo']) : null;
if (isset($_POST['nombreArchivo']) && !empty(trim($_POST['nombreArchivo']))) {
    $nombreArchivo = trim($_POST['nombreArchivo']);
}

// Llamar a la función listar con el filtro, si se proporcionó un nombre


?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-end align-items-center mt-3">
            <span class="me-3 fw-bold text-primary">
                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </span>
            <a class="btn btn-danger btn-sm" href="logout.php">Salir</a>
        </div>
        <h1 class="text-center mt-3">Busqueda</h1> 
    <form class="m-auto w-50 mt-2 mb-2" method="POST" action="busqueda.php">
        
    <div class="mb-2">
        <label class="form-label">Nombre del archivo</label>
        <input class="form-control form-control-sm" type="text" name="nombreArchivo" id="nombreArchivo" autocomplete="off" required>
    </div>
    
    <button class="btn btn-primary btn-sm">Buscar archivo</button>
    <a class="btn btn-success btn-sm" href="agregar.php">Agregar nuevo registro</a>
</form>
    </div>
   

<script src="bootstrap/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    function buscar(nombre) {
        $.ajax({
            url: 'buscar_ajax.php',
            type: 'POST',
            data: {nombreArchivo: nombre},
            success: function(data){
                $('#resultados').html(data);
            }
        });
    }
    // Búsqueda inicial (opcional)
    buscar($('#nombreArchivo').val());
    // Búsqueda en tiempo real
    $('#nombreArchivo').on('keyup', function(){
        buscar($(this).val());
    });
});
</script>
<div id="resultados">
<table class="table table-sm table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Archivo</th>
            <th>Fecha</th>
            
        </tr>
    </thead>
    <tbody>
        <?php 
        $contador = 0;
        while ($datos = mysqli_fetch_assoc($query)) {
            $contador++;
            $id = $datos['id'];
            $nombre = $datos['nombre'];
            $categoria = $datos['categoria'];
            $fecha = $datos['fecha'];
            $archivo = $datos['archivo'];
            $tipo = $datos['tipo'];

            $valor = "";
            if ($categoria == 'pdf') {
                $valor = "<img width='50' src='img/pdf.png'>";
            }
            if ($valor == '') {
                $valor = "<img width='50' src='img/desconocido.png'>";
            }
        ?>
        <tr>
            <td><?php echo $contador; ?></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo $categoria; ?></td>
            <td><a href="cargar.php?id=<?php echo $id; ?>"><?php echo $valor; ?> Descargar</a></td>
            <td><?php echo $fecha; ?></td>
             
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>