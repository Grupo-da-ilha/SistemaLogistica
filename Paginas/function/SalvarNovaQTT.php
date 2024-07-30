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

    if(isset($_POST['Quantidade_falta']) && isset($_POST['Clausula']) && isset($_POST['codigoitem'])){
        //Guardar valores em variáveis
        $Quantidade_digitada = $conexao -> real_escape_string($_POST['Quantidade_falta']);
        $Clausula = $conexao -> real_escape_string($_POST['Clausula']);
        $cod_itenPedido = $conexao -> real_escape_string($_POST['codigoitem']);

        //Consulta para pegar quantidade atual
        $SelectQTTItem = "SELECT * FROM itenspedido WHERE cod_itenPedido = '$cod_itenPedido' AND codTurma ='{$_SESSION['codTurma']}'";
        $executar = $conexao -> query($SelectQTTItem);

        if($executar && $executar -> num_rows > 0){
            $rowItem = $executar -> fetch_assoc();
            $Quantidade_atual = $rowItem['Quantidade'];

            if($Clausula == 'Faltando'){
                $newQTT = $Quantidade_atual + $Quantidade_digitada;

                //Update valor da Quantidade 
                $UpdateQTTItem = "UPDATE itenspedido SET Quantidade = '$newQTT', Quantidade_doca = '$newQTT' WHERE cod_itenPedido = '$cod_itenPedido' AND codTurma ='{$_SESSION['codTurma']}'";
                $executeUpdate = $conexao -> query($UpdateQTTItem);

                if($executeUpdate){
                    echo json_encode(array('success' => true));
                    exit();
                }else{
                    echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar quantidade nova'));
                    exit();
                }
            } elseif($Clausula == 'Avariado'){

                $newQTT = $Quantidade_atual - $Quantidade_digitada;
                
                //Update valor da Quantidade 
                $UpdateQTTItem = "UPDATE itenspedido SET Quantidade = '$newQTT', Quantidade_doca = '$newQTT' WHERE cod_itenPedido = '$cod_itenPedido' AND codTurma ='{$_SESSION['codTurma']}'";
                $executeUpdate = $conexao -> query($UpdateQTTItem);
                
                if($executeUpdate){
                    echo json_encode(array('success' => true));
                    exit();
                }else{
                    echo json_encode(array('success' => false, 'message' => 'Erro ao atualizar quantidade dos itens avariados'));
                    exit();
                }
            }
        }else{
            echo json_encode(array('success' => false, 'message' => 'Erro ao pesquisar por esse item'));
            exit();
        }
    }else{
        echo json_encode(array('success' => false, 'message' => 'Dados insuficientes'));
        exit();
    }

}
?>