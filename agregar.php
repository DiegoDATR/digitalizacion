<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<h1 class="text-center mt-3">Registro de Documentos</h1>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <form class="m-auto w-50 mt-2 mb-2" method="POST" enctype="multipart/form-data" action="acciones/insertar.php">
            <div class="mb-2">
                <label class="form-label">Nombre del archivo</label>
                <input class='form-control form-control-sm' type="text" name="nombreArchivo">
            </div>
            <div class="mb-2">
                <label class="form-label">Selecciona un archivo </label>
                <input class='form-control form-control-sm' type="file" accept="application/pdf" name="archivo" required>
            </div>
            <button class="btn btn-primary btn-sm">Subir archivo</button>
           
            <form action="" method="post">
            <a class="btn btn-danger btn-sm" href="index.php">Cancelar</a>  
            </form>
             

        </form>
        <div class="mx-auto w-75 mt-3">
            <table class="table table-sm table-striped text-center align-middle">
                <table class="table table-sm table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>categoria</th>
                            <th>Archivo</th>
                            <th>fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config/bd.php';
                        $conexion = conexion();
                        $query = listar($conexion);
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
                                $valor = "<img  width='50' src='img/pdf.png'>";
                            }
                            if ($valor == '') {
                                $valor = "<img  width='50' src='img/desconocido.png'>";
                            }


                        ?>
                            <tr>
                                <td><?php echo $contador; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td><?php echo $categoria; ?></td>
                                <td><a href="cargar.php?id=<?php echo $id; ?>"><?php echo $valor; ?> ver archivo</a></td>
                                <td><?php echo $fecha; ?></td>
                                <td>
                                    <?php if ($rol == 'admin'): ?>
                                        <a class='btn btn-secondary' href="editar.php?id=<?php echo $id ?>">Editar</a>
                                        <a class='btn btn-danger' href="acciones/eliminar.php?id=<?php echo $id ?>">Eliminar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>


        </div>


        <script src="bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>