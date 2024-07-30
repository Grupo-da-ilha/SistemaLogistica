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
}

if (isset($_SESSION['Idprojeto'])) {
    $idprojeto = $conexao->real_escape_string($_SESSION['Idprojeto']);
    $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '$idprojeto'";
    $execute = $conexao->query($sql);
    
    if ($execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $_SESSION['codTurma'] = $row['codTurma'];
    } else {
        echo json_encode(array('success' => false, 'message' => 'Projeto não encontrado.'));
        exit();
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'ID do projeto não definido.'));
    exit();
}

if (!isset($_SESSION['codTurma'])) {
    echo json_encode(array('success' => false, 'message' => 'CodTurma não encontrado.'));
    exit();
}

$idpedido = $conexao->real_escape_string($_SESSION['Idpedido']);
$codTurma = $conexao->real_escape_string($_SESSION['codTurma']);

$sql = "SELECT * FROM itenspedido WHERE cod_pedido = '$idpedido' AND codTurma = '$codTurma'";
$execute = $conexao->query($sql);

if ($execute->num_rows > 0) {
    while ($row = $execute->fetch_assoc()) {
        $VistoriaConcluida = $row['VistoriaConcluida'];

        if ($VistoriaConcluida == 0) {
            echo json_encode(array('success' => false, 'message' => 'Você não concluiu a vistoria em alguns dos itens'));
            exit();
        } else {
            $sql = "SELECT * FROM docas WHERE id_pedido = '$idpedido'";
            $execute = $conexao->query($sql);

            if ($execute->num_rows > 0) {
                $UpdateSitacao = "UPDATE pedido SET Situacao = 'Nas docas' WHERE id_pedido = '$idpedido'";
                $executeUpdateSituacao = $conexao->query($UpdateSitacao);

                if ($executeUpdateSituacao) {
                    echo json_encode(array('success' => true));
                    exit();
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Erro ao finalizar vistoria deste pedido'));
                    exit();
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Você não inseriu o pedido nas docas ainda'));
                exit();
            }
        }
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Nenhum item encontrado para esse pedido'));
    exit();
}

$conexao->close();
?>
