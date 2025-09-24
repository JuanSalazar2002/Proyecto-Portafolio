<?php include "cabecera.php"; ?>
<?php include "conexion.php"; ?>
<?php

# Aquí es para poder subir, INSERTAR, los proyectos a la BD
if ($_POST) {
    # print_r($_POST);
    $nombre= $_POST['nombre'];
    $descripcion= $_POST['descripcion'];
    
    $fecha= new DateTime(); // <- para que la imagen lleve el nombre del tiempo
    // para obtener el nombre de la imagen
    $imagen= $fecha->getTimestamp()."_".$_FILES['archivo']['name'];
    
    // para adjuntar la imagen
    $imagen_temporal= $_FILES['archivo']['tmp_name'];
    move_uploaded_file($imagen_temporal, "imagenes/".$imagen);

    $objConexion = new conexion();
    $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', '$imagen', '$descripcion');";
    $objConexion->ejecutar($sql);
}
if ($_GET) {
    $id= $_GET['borrar'];
    $objConexion = new conexion();
    $imagen= $objConexion->consultar("SELECT imagen FROM proyectos WHERE id= ".$id);
    // print_r($imagen[0]['imagen']); <- acá es para obtener el nombre del archivo
    unlink("imagenes/".$imagen[0]['imagen']);
    $sql= "DELETE FROM `proyectos` WHERE `proyectos`.`id` = ".$id;
    $objConexion->ejecutar($sql);
}

# Esto tiene que funcionar independiente del envio de datos
$objConexion = new conexion();
$proyectos= $objConexion->consultar("SELECT * FROM proyectos");
# print_r($resultado);

?>
<br>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Datos del proyecto</div>
                <div class="card-body">

                    <form action="portafolio.php" method="post" enctype="multipart/form-data">
                        Nombre del proyecto: <input class="form-control" type="text" name="nombre" id="">
                        <br>
                        Imagen del proyecto: <input class="form-control" type="file" name="archivo" id="">
                        <br>
                        Descripción
                        <textarea class="form-control" name="descripcion" rows="3" ></textarea>
                        <br>
                        <input class="btn btn-success" type="submit" value="Enviar Proyecto">
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $proyecto) { ?>
                        <tr>
                            <td> <?php echo $proyecto['id']; ?> </td>
                            <td> <?php echo $proyecto['nombre']; ?> </td>
                            <td>
                                <img width="100" src="imagenes/<?php echo $proyecto['imagen']; ?>" alt="">
                            </td>
                            <td> <?php echo $proyecto['descripcion']; ?> </td>
                            <td> <a href="?borrar=<?php echo $proyecto['id']; ?>" class="btn btn-danger">Eliminar</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include "pie.php"; ?>