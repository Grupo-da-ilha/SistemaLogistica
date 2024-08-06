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

if (isset($_POST['solicitacaoId'])) {
        // Guardar valor em uma variável
        $solicitacaoId = $conexao->real_escape_string($_POST['solicitacaoId']);
    
        // Consulta para encontrar produtos no estoque com o nome digitado
        $query = "UPDATE solicitacoes SET Situacao = 'Em processo de picking' WHERE id_solicitacao = '$solicitacaoId' AND codTurma = '{$_SESSION['codTurma']}'";
    
        $resultado = $conexao->query($query);
    
        if ($resultado) {
            echo json_encode(array('success' => true, 'message' => 'Itens e solicitação esperando no picking'));
            exit();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar situação da solicitação'));
            exit();
        }
}

$conexao->close();
?>