<?php
if (!isset($_GET['codigo'])) {
    header('Location: index.php?mensaje=error');
    exit();
}

include 'model/conexion.php';
$codigo = $_GET['codigo'];

$sentencia = $bd->prepare("SELECT alq.alquiler, alq.fecha_alquiler, alq.fecha_devolucion , alq.id_clientes, cli.nombres, cli.apellidos, cli.dni, cli.celular
FROM alquiler alq 
INNER JOIN clientes cli ON cli.id = alq.id_clientes 
WHERE alq.id = ?;");
$sentencia->execute([$codigo]);
$clientes = $sentencia->fetch(PDO::FETCH_OBJ);

    $url = 'https://whapi.io/api/send';
    $data = [
        "app" => [
            "id" => '51973610591',
            "time" => '1654728819',
            "data" => [
                "recipient" => [
                    "id" => '51'.$clientes->celular
                ],
                "message" => [[
                    "time" => '1654728819',
                    "type" => 'text',
                    "value" => 'Estimado(a) *'.strtoupper($clientes->nombres).' '.strtoupper($clientes->apellidos).'* Usted alquiló el libro *'.strtoupper($clientes->alquiler).'* el *'.$clientes->fecha_alquiler.'* hasta el *'.$clientes->fecha_devolucion.'*'
                ]]
            ]
        ]
    ];
    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => json_encode($data),
            'header' =>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    header('Location: agregarAlquiler.php?codigo='.$clientes->id);
