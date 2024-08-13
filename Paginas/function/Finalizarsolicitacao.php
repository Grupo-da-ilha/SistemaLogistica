<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Erro na conexão com o banco de dados: " . $conexao->connect_error;
    exit();
}

if (isset($_SESSION['Idprojeto'])) {
    $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
    $execute = $conexao->query($sql);

    if ($execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $_SESSION['codTurma'] = $row['codTurma'];
    }
} else {
    echo ''.$_SESSION['Idprojeto']. '';
}

if (isset($_POST['doca_saida']) && isset($_POST['id_solicitacao'])) {
        // Guardar valor em uma variável
        $id_solicitacao = $conexao->real_escape_string($_POST['id_solicitacao']);
        $doca_saida = $conexao->real_escape_string($_POST['id_solicitacao']);
    
        $UpdateSituacaoEdoca = "UPDATE solicitacoes SET Situacao = 'Mercadoria(s) em transporte', Doca_saida = '$doca_saida' WHERE id_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}'";
        $executeUpdate = $conexao -> query($UpdateSituacaoEdoca);

        if($executeUpdate){
            echo json_encode(['success' => true, 'message' => 'Processo Finalizado, itens em transporte']);
            exit();
        } else{
            echo json_encode(['success' => false, 'message' => 'Erro ao finalizar processo']);
            exit();
        }
}

$conexao->close();
?>