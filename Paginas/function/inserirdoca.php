<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Failed to connect to MySQL: " . $conexao->connect_error;
    exit();
}else{
    $doca = $conexao -> real_escape_string($_POST['doca']);

    $sql = "SELECT * FROM docas WHERE cod_pedido = '".$_SESSION['codigo_pedido_doca']."' AND codprojeto = '".$_SESSION['Idprojeto']."'";
    $execute = $conexao ->query($sql);

    if($execute -> num_rows > 0){
        echo json_encode(array('success' => false, 'message' => 'Esse pedido já está em uma doca'));
        exit();
    }else{
        
    $sql = "INSERT INTO docas (posicao, cod_pedido, codprojeto)
    VALUES ('".$doca."', '".$_SESSION['codigo_pedido_doca']."', '".$_SESSION['Idprojeto']."')";
    $execute = $conexao -> query($sql);

    if($execute){
        echo json_encode(array('success' => true, 'message' => 'Esse pedido já está em uma doca'));
    } else{
        echo 'Erro ao inserir pedido na doca';
        $conexao -> close();
    }
}
    }
?>