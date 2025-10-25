<?php 
function conexion(){
    $con=mysqli_connect('localhost','root','','files');
    return $con;
}

function listar($conexion){
    $sql="SELECT * FROM archivo";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function listar1($conexion, $nombreArchivo = null) {
    if ($nombreArchivo) {
        // Consulta correcta con columna real y LIKE
        $stmt = $conexion->prepare("SELECT * FROM archivo WHERE nombre LIKE ?");
        $param = "%" . $nombreArchivo . "%";
        $stmt->bind_param("s", $param);
        $stmt->execute();
        return $stmt->get_result();
    } else {
        // Si no se pasa nombre, devuelve todos
        return $conexion->query("SELECT * FROM archivo");
    }
}
function insertar($conexion,$nombre,$categoria,$fecha,$tipo,$archivoBLOB){
    $sql="INSERT INTO archivo(nombre,categoria,fecha,tipo,archivo) VALUES('$nombre','$categoria','$fecha','$tipo','$archivoBLOB')";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function eliminar($conexion,$id){
    $sql="DELETE from archivo WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function datos($conexion,$id){
    $sql="SELECT * FROM archivo WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    $datos=mysqli_fetch_assoc($query);
    return $datos;
}
function editarNombre($conexion,$id,$nombre){
    $sql="UPDATE archivo SET nombre='$nombre' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function editarArchivo($conexion,$id,$categoria,$tipo,$fecha,$archivoBLOB){
    $sql="UPDATE archivo SET categoria='$categoria',tipo='$tipo',fecha='$fecha',archivo='$archivoBLOB' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}
function editar($conexion,$id,$nombre,$categoria,$tipo,$fecha,$archivoBLOB){
    $sql="UPDATE archivo SET nombre='$nombre', categoria='$categoria',tipo='$tipo',fecha='$fecha',archivo='$archivoBLOB' WHERE id=$id";
    $query=mysqli_query($conexion,$sql);
    return $query;
}

?>