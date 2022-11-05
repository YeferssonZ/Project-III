<?php include 'template/header.php' ?>

<?php
include_once "model/conexion.php";
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("select * from clientes where id = ?;");
$sentencia->execute([$codigo]);
$clientes = $sentencia->fetch(PDO::FETCH_OBJ);

$sentencia_alquiler = $bd->prepare("select * from alquiler where id_clientes = ?;");
$sentencia_alquiler->execute([$codigo]);
$alquiler = $sentencia_alquiler->fetchAll(PDO::FETCH_OBJ); 

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Ingresar datos para el alquiler de libro:
                </div>
                <form class="p-4" method="POST" action="registrarAlquiler.php">
                    <div class="mb-3">
                        <label class="form-label">Nombre del libro alquilado: </label>
                        <input type="text" class="form-control" name="txtAlquiler" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha del alquiler: </label>
                        <input type="date" class="form-control" name="txtFecha_Alquiler" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de devolución: </label>
                        <input type="date" class="form-control" name="txtFecha_Devolucion" autofocus required>
                    </div>
                    <div class="d-grid">
                        <input type="hidden" name="codigo" value="<?php echo $clientes->id;?>"><P></P>
                        <input type="submit" class="btn btn-primary" value="Registrar">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Lista de libros alquilados:
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Libro alquilado</th>
                                <th scope="col">Fecha de alquiler</th>
                                <th scope="col">Fecha de devolución</th>
                                <th scope="col" colspan="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($alquiler as $dato) {
                            ?>
                                <tr>
                                    <td scope="row"><?php echo $dato->id; ?></td>
                                    <td><?php echo $dato->alquiler; ?></td>
                                    <td><?php echo $dato->fecha_alquiler; ?></td>
                                    <td><?php echo $dato->fecha_devolucion; ?></td>
                                    <td><center><a class="text-primary" href="enviarMensaje.php?codigo=<?php echo $dato->id; ?>"><i class="bi bi-cursor"></i></a></center></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php' ?>