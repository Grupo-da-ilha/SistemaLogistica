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
    $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '{$_SESSION['Idpedido']}' AND codTurma ='{$_SESSION['codTurma']}'";
    $execute = $conexao -> query($sql);

    if($execute -> num_rows > 0){
            $row = $execute -> fetch_assoc();
            $VistoriaConluida = $row['VistoriaConcluida'];

            if($VistoriaConluida == 0){
                echo json_encode(array('success' => false, 'message' => 'Você não concluiu a vistoria em alguns dos itens'));
                } else{
                    $sql = "SELECT * FROM docas WHERE id_pedido = '{$_SESSION['Idpedido']}'";
                    $execute = $conexao -> query($sql);

                    if($execute -> num_rows > 0){
                        $sql = "UPDATE pedido SET Situacao = 'Nas docas' WHERE id_pedido = '{$_SESSION['Idpedido']}'";
                        $execute = $conexao -> query($sql);

                        if($execute){
                            echo json_encode(array('success' => true));
                        } else{
                            echo json_encode(array('success' => false, 'message' => 'Erro ao finalizar vistoria deste pedido'));
                        }
                    } else{
                        echo json_encode(array('success' => false, 'message' => 'Você não inseriu o pedido nas docas ainda'));
                    }

                }
    } else{
        echo json_encode(array('success' => false, 'message' => 'Nenhum item encontrado para esse pedido'));
        exit();
    }
}   