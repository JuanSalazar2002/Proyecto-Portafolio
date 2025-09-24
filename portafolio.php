<?php include "cabecera.php"; ?>
<?php include "conexion.php"; ?>
<?php

# Aquí es para poder subir, INSERTAR, los proyectos a la BD
if ($_POST) {
    # print_r($_POST);
    $nombre= $_POST['nombre'];
    $objConexion = new conexion();
    $sql = "INSERT INTO `proyectos` (`id`, `nombre`, `imagen`, `descripcion`) VALUES (NULL, '$nombre', 'fernando.png', 'Prueba 1');";
    $objConexion->ejecutar($sql);
}
if ($_GET) {
    $id= $_GET['borrar'];
    $objConexion = new conexion();
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($proyectos as $proyecto) { ?>
                        <tr>
                            <td> <?php echo $proyecto['id']; ?> </td>
                            <td> <?php echo $proyecto['nombre']; ?> </td>
                            <td> <?php echo $proyecto['imagen']; ?> </td>
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