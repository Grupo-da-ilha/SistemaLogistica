<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo json_encode(array('success' => false, 'message' => "Failed to connect to MySQL: " . $conexao->connect_error));
    exit();
} else {
    if(!empty($_POST['coditem'])){
        $codigo_itenPedido = $conexao->real_escape_string($_POST['coditem']);
        $sql = "SELECT * FROM `itenspedido` WHERE VistoriaConcluida = 1 AND cod_itenPedido = '$codigo_itenPedido'";
        $execute = $conexao -> query($sql);

        if($execute -> num_rows > 0){
            echo json_encode(array('success' => true, 'message' => 'A vistoria já foi concluída neste item'));
        }else{
            $sql = "UPDATE itenspedido SET VistoriaConcluida = 1 WHERE cod_itenPedido =  '$codigo_itenPedido'";
            $execute = $conexao -> query($sql);
            if($execute){
                echo json_encode(array('success' => true, 'message' => 'Vistoria concluída neste item'));
            }else {
                echo json_encode(array('success' => false, 'message' => 'Erro ao finalizar vistoria'));
                exit();
            }
        }
        }else {
            echo json_encode(array('success' => false, 'message' => 'Dados insuficientes para concluir a vistoria'));
            exit();
        }
    }