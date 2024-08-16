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

        if(isset($_POST['QTDEstoque']) && isset($_POST['PosicaoEstoque']) && isset($_POST['QTTdoca']) && isset($_POST['id_pedido'])  && isset($_POST['cod_itempedido'])  && isset($_POST['ItemEstoque'])){
            $quantidadeEstoque = $conexao -> real_escape_string($_POST['QTDEstoque']);
            $posicaoEstoque = $conexao -> real_escape_string($_POST['PosicaoEstoque']);
            $QttDoca = $conexao -> real_escape_string($_POST['QTTdoca']);
            $QuantidadeArmazenada = $conexao -> real_escape_string($_POST['ItemEstoque']);
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
                } elseif($quantidadeEstoque > $Quantidade_na_doca){
                    echo json_encode(array('success' => false, 'message' => 'Você selecionou mais itens para irem ao estoque do que estão parados na doca, verifique se os itens já não foram estocados'));
                    exit();
                } else{
                    // Atualizando a quantidade do item à espera na doca                 
                    $NewQTTDoca = $QttDoca - $quantidadeEstoque;

                    $Updateitem = "UPDATE itenspedido SET Quantidade_doca = '$NewQTTDoca' WHERE cod_itenPedido = '$cod_itempedido' AND cod_pedido = '$id_pedido' AND codTurma = '{$_SESSION['codTurma']}'";
                    $executar = $conexao->query($Updateitem);

                    if (!$executar) {
                        echo json_encode(['success' => false, 'message' => 'ERRO', 'newqttdoca' => 0, 'codItemPedido' => 0]);
                        exit();
                    }else{

                    $SelectEstoque = "SELECT cod_estoque FROM estoque WHERE Andar ='$andar' AND Apartamento = '$apartamento'";
                    $executar = $conexao->query($SelectEstoque);

                    if ($executar && $executar->num_rows > 0) {
                        $row = $executar->fetch_assoc();
                        $cod_estoque = $row['cod_estoque'];

                        $InsetItemEstoque = "INSERT INTO itensestoque (Quantidade, Situacao, cod_estoque, cod_itenPedido, codTurma)
                        VALUES ('$quantidadeEstoque', 'Em movimentação', '$cod_estoque', '$cod_itempedido', '{$_SESSION['codTurma']}')";
                        $execute = $conexao->query($InsetItemEstoque);

                        if ($execute) {
                            echo json_encode(['success' => true, 'message' => 'Item enviado para a movimentação', 'newqttdoca' => $NewQTTDoca, 'codItemPedido' => $cod_itempedido]);
                            exit();
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Erro ao enviar pedido para a movimentação']);
                            exit();
                        }
                    } else {
                        $Updateitem = "UPDATE itenspedido SET Quantidade_doca = '$QttDoca' WHERE cod_itenPedido = '$cod_itempedido' AND cod_pedido = '$id_pedido' AND codTurma = '{$_SESSION['codTurma']}'";
                        $executar = $conexao->query($Updateitem);

                        echo json_encode(['success' => false, 'message' => 'A posição selecionada não existe no estoque']);
                        exit();
                    }
                }
            }

        } else{
            echo json_encode(array('success' => false, 'message' => 'Erro aos procesar dados'));
            exit();
        }
}
}
?>
