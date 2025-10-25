<?php
include 'config/bd.php';
$conexion = conexion();
$nombreArchivo = isset($_POST['nombreArchivo']) ? trim($_POST['nombreArchivo']) : '';
$sql = "SELECT * FROM archivo WHERE nombre LIKE '%$nombreArchivo%' ORDER BY id DESC";
$query = mysqli_query($conexion, $sql);

echo '<div class="mx-auto w-75 mt-3">';
echo '<table class="table table-sm table-striped text-center align-middle">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Nombre</th>
    <th>Categoría</th>
    <th>Archivo</th>
    <th>Fecha</th>
</tr>
</thead>
<tbody>';
$contador = 0;
while ($datos = mysqli_fetch_assoc($query)) {
    $contador++;
    $id = $datos['id'];
    $nombre = $datos['nombre'];
    $categoria = $datos['categoria'];
    $fecha = $datos['fecha'];
    $valor = ($categoria == 'pdf') ? "<img width='50' src='img/pdf.png'>" : "<img width='50' src='img/desconocido.png'>";
    echo "<tr>
        <td>$contador</td>
        <td>$nombre</td>
        <td>$categoria</td>
        <td><a href='cargar.php?id=$id'>$valor Ver archivo</a></td>
        <td>$fecha</td>
    </tr>";
}
if ($contador == 0) {
    echo "<tr><td colspan='5' class='text-center'>No se encontraron resultados.</td></tr>";
}
echo '</tbody></table>';
?>