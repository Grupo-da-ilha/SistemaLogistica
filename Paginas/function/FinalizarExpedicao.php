<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo json_encode(array('success' => false, 'message' => 'Erro na conexão com o banco de dados: ' . $conexao->connect_error));
    exit();
}

if (isset($_POST['id_solicitacao']) && !empty($_POST['doca'])) {
    $id_solicitacao = $conexao->real_escape_string($_POST['id_solicitacao']);
    $doca = $conexao -> real_escape_string($_POST['doca']);
    
    // Atualize a situação da solicitação
    $query = "UPDATE solicitacoes SET Situacao = 'Nas docas', Doca='$doca' WHERE id_solicitacao = '$id_solicitacao'";
    $resultado = $conexao->query($query);

    if ($resultado) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar a situação'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Doca não digitada'));
}

$conexao->close();
?>
