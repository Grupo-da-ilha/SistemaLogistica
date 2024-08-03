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

if (isset($_SESSION['Idprojeto'])) {
    $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
    $execute = $conexao->query($sql);

    if ($execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $_SESSION['codTurma'] = $row['codTurma'];
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'ID do projeto não encontrado'));
    exit();
}

if (isset($_POST['cod_item_picking'])) {
    $cod_item_picking = $conexao->real_escape_string($_POST['cod_item_picking']);
    $query = "SELECT * FROM itenspicking WHERE cod_itemPicking = '$cod_item_picking' AND codTurma = '{$_SESSION['codTurma']}'";
    $resultado = $conexao->query($query);

    if ($resultado && $resultado->num_rows > 0) {
        $UpdateSituaciao = "UPDATE itenspicking SET Situacao = 'Na expedição' WHERE cod_itemPicking = '$cod_item_picking' AND codTurma = '{$_SESSION['codTurma']}'";
        $executeUpdate = $conexao->query($UpdateSituaciao);

        if ($executeUpdate) {
            echo json_encode(array('success' => true, 'Expedicao' => 1, 'cod_item_picking' => $cod_item_picking));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Falha ao registrar item como pego'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Dados insuficientes'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Código do item não fornecido'));
}

$conexao->close();
?>
