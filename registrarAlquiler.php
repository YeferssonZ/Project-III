<?php
//print_r($_POST);
if (empty($_POST["txtAlquiler"]) || empty($_POST["txtFecha_Alquiler"]) || empty($_POST["txtFecha_Devolucion"])) {
    header('Location: index.php');
    exit();
}

include_once 'model/conexion.php';
$alquiler = $_POST["txtAlquiler"];
$fecha_alquiler = $_POST["txtFecha_Alquiler"];
$fecha_devolucion = $_POST["txtFecha_Devolucion"];
$codigo = $_POST["codigo"];


$sentencia = $bd->prepare("INSERT INTO alquiler(alquiler, fecha_alquiler, fecha_devolucion, id_clientes) VALUES (?,?,?,?);");
$resultado = $sentencia->execute([$alquiler, $fecha_alquiler, $fecha_devolucion, $codigo ]);

if ($resultado === TRUE) {
    header('Location: agregarAlquiler.php?codigo='.$codigo);
} 