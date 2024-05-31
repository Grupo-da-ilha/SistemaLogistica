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
    if(!empty($_POST['codigoitem'])){
        $cod_itenPedido = $conexao->real_escape_string($_POST['codigoitem']);
        if(isset($_POST['avariado']) && !isset($_POST['faltando'])){
            $avariado = 1;

            $sql = "SELECT * FROM itenspedido WHERE cod_itenPedido =  '$cod_itenPedido' AND Avariado = '$avariado'";
            $execute = $conexao -> query($sql);

            if($execute -> num_rows > 0){
                echo json_encode(array('success' => true, 'message' => 'O item já foi registrado como avariado'));
            } else{
            
            $sql = "UPDATE itenspedido SET Avariado = '$avariado' WHERE cod_itenPedido = '$cod_itenPedido' AND cod_pedido = '".$_SESSION['Idpedido']."'";
            $execute = $conexao -> query($sql);

            if($execute){
                echo json_encode(array('success' => true, 'message' => 'Adicionado cláusula de pedido avariado'));
                exit();
            } else {
                echo json_encode(array('success' => false, 'message' => 'Erro ao inserir cláusula de avariado no pedido'));
                exit();
            }
        }
        }elseif(isset($_POST['faltando']) && !isset($_POST['avariado'])){
            $faltando = 1;

            $sql = "SELECT * FROM itenspedido WHERE cod_itenPedido =  '$cod_itenPedido' AND Faltando = '$faltando'";
            $execute = $conexao -> query($sql);

            if($execute -> num_rows > 0){
                echo json_encode(array('success' => true, 'message' => 'O item já foi registrado como faltando'));
            } else{
            $sql = "UPDATE itenspedido SET Faltando = '$faltando' WHERE cod_itenPedido = '$cod_itenPedido' AND cod_pedido = '".$_SESSION['Idpedido']."'";
            $execute = $conexao -> query($sql);

            if($execute){
                echo json_encode(array('success' => true, 'message' => 'Adicionado cláusula de pedido faltando'));
                exit();
            } else {
                echo json_encode(array('success' => false, 'message' => 'Erro ao inserir cláusula de faltando no pedido'));
                exit();
            }
        }
        }elseif(isset($_POST['faltando']) && isset($_POST['avariado'])){
            $faltando = 1;
            $avariado = 1;
            $sql = "SELECT * FROM itenspedido WHERE cod_itenPedido =  '$cod_itenPedido' AND Avariado = '$avariado' AND Faltando = '$faltando'";
            $execute = $conexao -> query($sql);

            if($execute -> num_rows > 0){
                echo json_encode(array('success' => true, 'message' => 'O item já foi registrado como avariado e faltando'));
            } else{
            $sql = "UPDATE itenspedido SET Faltando = '$faltando', Avariado = '$avariado' WHERE cod_itenPedido = '$cod_itenPedido' AND cod_pedido = '".$_SESSION['Idpedido']."'";
            $execute = $conexao -> query($sql);

            if($execute){
                echo json_encode(array('success' => true, 'message' => 'Adicionado cláusula de pedido faltando e pedido avariado'));
                exit();
            } else {
                echo json_encode(array('success' => false, 'message' => 'Erro ao inserir as duas cláusulas no pedido'));
                exit();
            }
        }
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Dados insuficientes para processar a vistoria'));
        exit();
    }
}
?>