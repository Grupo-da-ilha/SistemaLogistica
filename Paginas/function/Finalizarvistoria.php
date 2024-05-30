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
    if(isset($_POST['Vistoria_recebimento'])){
        header('Location: ../movimentacao.php', true, 301);
        $conexao -> close();
    } else{
        echo 'Não foi possível finalizar vistoria';
    }
    }
