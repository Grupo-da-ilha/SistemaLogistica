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

if (isset($_POST['cod_item_picking'])) {
        // Guardar valor em uma variável
        $cod_item_picking = $conexao->real_escape_string($_POST['cod_item_picking']);
    
        if(!empty($_POST['observacao_solicitacao'])){
            $observacao_solicitacao = $conexao->real_escape_string($_POST['observacao_solicitacao']);

            $UpdateObservacoes = "UPDATE itenspicking SET observacoes = '$observacao_solicitacao', Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
            $executeUpdate = $conexao -> query($UpdateObservacoes);

            if($executeUpdate){
                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Adicionada observação e atualizada Sitaucao do item']);
                exit();
            } else{
                echo json_encode(['success' => false, 'message' => 'Erro ao adicionar observação ao item']);
                exit();
            }
        } else{
            $UpdateSituacao = "UPDATE itenspicking SET Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
            $executeUpdateSituacao = $conexao -> query($UpdateSituacao);

            if($executeUpdateSituacao){
                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Item esperando a transportadora']);
                exit();
            } else{
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar situação do item']);
                exit();
            }
        } 

}

$conexao->close();
?>