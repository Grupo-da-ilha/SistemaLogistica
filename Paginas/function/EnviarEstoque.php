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
} else {
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

    if(isset($_POST['CodigoItemEstoque'])){
        $cod_itenestoque = $conexao -> real_escape_string($_POST['CodigoItemEstoque']);

        $UpdateSituacao = "UPDATE itensestoque SET Situacao = 'No estoque' WHERE cod_itenEstoque = '$cod_itenestoque'";
        $sqlUpdate = $conexao -> query($UpdateSituacao);

        if(!$sqlUpdate){
            echo 'Erro ao atualizar situacao';
        }else{
            header('Location: ../operacaomovimentacao.php?update=1', true, 301);
        }
    }
}
?>