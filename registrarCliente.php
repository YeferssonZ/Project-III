<?php
//print_r($_POST);
if (empty($_POST["oculto"]) || empty($_POST["txtNombres"]) || empty($_POST["txtApellidos"]) || empty($_POST["txtDni"]) || empty($_POST["txtCelular"])) {
    header('Location: index.php?mensaje=falta');
    exit();
}

include_once 'model/conexion.php';
$nombres = $_POST["txtNombres"];
$apellidos = $_POST["txtApellidos"];
$dni = $_POST["txtDni"];
$celular = $_POST["txtCelular"];

$sentencia = $bd->prepare("INSERT INTO clientes(nombres, apellidos, dni, celular) VALUES (?,?,?,?);");
$resultado = $sentencia->execute([$nombres, $apellidos, $dni, $celular]);

if ($resultado === TRUE) {
    header('Location: index.php?mensaje=registrado');
} else {
    header('Location: index.php?mensaje=error');
    exit();
}