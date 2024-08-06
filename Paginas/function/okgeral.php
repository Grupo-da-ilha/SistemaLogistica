<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

header('Content-Type: application/json');

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco de dados: ' . $conexao->connect_error]);
    exit();
}

if (isset($_POST['codigosItensPicking'])) {
    $codigosItensPicking = $_POST['codigosItensPicking'];

    foreach ($codigosItensPicking as $item) {
        $cod_item_picking = $conexao->real_escape_string($item['cod_item_picking']);
        $observacao = $conexao->real_escape_string($item['observacao']);

        if (!empty($observacao)) {
            $UpdateObservacoes = "UPDATE itenspicking SET observacoes = '$observacao', Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND codTurma = '{$_SESSION['codTurma']}'";
            $executeUpdate = $conexao->query($UpdateObservacoes);

            if (!$executeUpdate) {
                echo json_encode(['success' => false, 'message' => 'Erro ao adicionar observação ao item']);
                exit();
            }
        } else {
            $UpdateSituacao = "UPDATE itenspicking SET Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND codTurma = '{$_SESSION['codTurma']}'";
            $executeUpdateSituacao = $conexao->query($UpdateSituacao);

            if (!$executeUpdateSituacao) {
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar situação do item']);
                exit();
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Itens conferidos, esperando a transportadora']);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Nenhum dado enviado']);
$conexao->close();
?>
