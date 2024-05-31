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
    $sql = "SELECT * FROM pedido WHERE codTurma = '{$_SESSION['codTurma']}' ";
    $execute = $conexao->query($sql);
    $codigosPedidos = array();
    if($execute->num_rows > 0){
        while($row = $execute->fetch_assoc()){
            $idsPedidos[] = $row['id_pedido'];
        }

            if(in_array($_SESSION['Idpedido'], $idsPedidos)){
                $doca = $conexao->real_escape_string($_POST['doca']);
                $sql = "SELECT * FROM docas WHERE id_pedido = '". $_SESSION['Idpedido']."' AND codTurma = '{$_SESSION['codTurma']}'";
                $execute = $conexao->query($sql);

                if($execute->num_rows > 0){
                    echo json_encode(array('success' => false, 'message' => 'Esse pedido já está em uma doca'));
                    exit();
                } else {
                    $sql = "INSERT INTO docas (posicao, id_pedido, codTurma)
                    VALUES ('".$doca."', '".$_SESSION['Idpedido']."', '".$_SESSION['codTurma']."')";
                    $execute = $conexao->query($sql);

                    if($execute){
                        echo json_encode(array('success' => true, 'message' => 'Doca inserida com sucesso!'));
                    } else{
                        echo json_encode(array('success' => false, 'message' => 'Erro ao inserir pedido na doca'));
                    }
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Esse pedido não foi criado neste projeto'));
                exit();
            }
        }
    }
?>
