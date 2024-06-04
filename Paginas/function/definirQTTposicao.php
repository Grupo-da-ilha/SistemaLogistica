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
        if(isset($_POST['QTDEstoque']) && isset($_POST['PosicaoEstoque']) && isset($_POST['QTTDoca']) && isset($_POST['id_pedido'])  && isset($_POST['cod_itempedido'])){
            $quantidadeEstoque = $conexao -> real_escape_string($_POST['QTDEstoque']);
            $posicaoEstoque = $conexao -> real_escape_string($_POST['PosicaoEstoque']);
            $QttDoca = $conexao -> real_escape_string($_POST['QTTDoca']);
            $cod_itempedido = $conexao -> real_escape_string($_POST['cod_itempedido']);
            $id_pedido = $conexao -> real_escape_string($_POST['id_pedido']);

            $andar = substr($posicaoEstoque, 0, 1);
            $apartamento = substr($posicaoEstoque, 1);

            $sql="SELECT * FROM itenspedido WHERE cod_itenPedido = ' $cod_itempedido' AND cod_pedido = '$id_pedido' AND codTurma = '{$_SESSION['codTurma']}'";
            $execute = $conexao -> query($sql);

            if($execute && $execute -> num_rows > 0){
                $row = $execute -> fetch_assoc();
                $QuantidadeItem = $row['Quantidade'];
                $Quantidade_na_doca = $row['Quantidade_doca'];

                if($quantidadeEstoque > $QuantidadeItem){
                    echo json_encode(array('success' => false, 'message' => 'Você selecionou mais itens do que o pedido possui para irem ao estoque'));
                    exit();
                } elseif($Quantidade_na_doca == 0){
                    echo json_encode(array('success' => false, 'message' => 'Todos esses itens já foram para a movimentação ou estão estocados'));
                    exit();
                }elseif($quantidadeEstoque > $Quantidade_na_doca){
                    echo json_encode(array('success' => false, 'message' => 'Você selecionou mais itens para irem ao estoque do que estão parados na doca, verifique se os itens já não foram estocados'));
                    exit();
                } else{
  

                $NewQTTDoca = $Quantidade_na_doca - $quantidadeEstoque;

                $sql = "UPDATE itenspedido SET Quantidade_doca = '$NewQTTDoca' WHERE cod_pedido = '$id_pedido' 
                AND cod_itenPedido = '$cod_itempedido' AND codTurma = '{$_SESSION['codTurma']}'";
                $execute = $conexao -> query($sql);

                if($execute){
                    echo json_encode(array('success' => true, 'message' => 'Item enviado para a movimentação'));
                    exit();
                } else{
                    echo json_encode(array('success' => false, 'message' => 'Dados insuficientes 4'));
                    exit();
                }
            }

        } else{
            echo json_encode(array('success' => false, 'message' => 'Dados insuficientes'));
            exit();
        }

        
    }else{
            echo json_encode(array('success' => false, 'message' => 'Dados insuficientes'));
            exit();
        }

}
?>
