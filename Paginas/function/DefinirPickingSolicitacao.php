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

        if(isset($_POST['QTDEstoque']) && isset($_POST['PosicaoEstoque']) && isset($_POST['QTTespera']) && isset($_POST['id_solicitacao'])  && isset($_POST['cod_itempSolicitacao']) && isset($_POST['ItemPicking'])){
            $quantidadeEstoque = $conexao -> real_escape_string($_POST['QTDEstoque']);
            $posicaoEstoque = $conexao -> real_escape_string($_POST['PosicaoEstoque']);
            $QTTespera = $conexao -> real_escape_string($_POST['QTTespera']);
            $QuantidadePicking = $conexao -> real_escape_string($_POST['ItemPicking']);
            $cod_itempSolicitacao = $conexao -> real_escape_string($_POST['cod_itempSolicitacao']);
            $id_solicitacao = $conexao -> real_escape_string($_POST['id_solicitacao']);

            $andar = substr($posicaoEstoque, 0, 1);
            $apartamento = substr($posicaoEstoque, 1);

            $sql="SELECT * FROM itenssolicitacao WHERE cod_itemSolicitacao = ' $cod_itempSolicitacao' AND cod_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}'";
            $execute = $conexao -> query($sql);

            if($execute && $execute -> num_rows > 0){
                $row = $execute -> fetch_assoc();
                $QuantidadeItem = $row['Quantidade'];
                $Quantidade_espera = $row['Quantidade_espera'];

                if($quantidadeEstoque > $QuantidadeItem){
                    echo json_encode(array('success' => false, 'message' => 'Você selecionou mais itens do que o pedido possui para irem ao estoque'));
                    exit();
                } elseif($quantidadeEstoque > $Quantidade_espera){
                    echo json_encode(array('success' => false, 'message' => 'Você selecionou mais itens para irem ao estoque do que estão parados na doca, verifique se os itens já não foram estocados'));
                    exit();
                } else{
                    // Atualizando a quantidade do item à espera na doca                 
                    $NewQTTEspera = $Quantidade_espera - $quantidadeEstoque;

                    $Updateitem = "UPDATE itenssolicitacao SET Quantidade_espera = '$NewQTTEspera' WHERE cod_itemSolicitacao = '$cod_itempSolicitacao' AND cod_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}'";
                    $executar = $conexao->query($Updateitem);

                    if (!$executar) {
                        echo json_encode(['success' => false, 'message' => 'ERRO', 'newqttdoca' => 0, 'cod_itemSolicitacao' => 0]);
                        exit();
                    }else{
                        $SelectEstoque = "SELECT cod_estoque FROM estoque WHERE Andar ='$andar' AND Apartamento = '$apartamento'";
                        $executar = $conexao->query($SelectEstoque);

                        if ($executar && $executar->num_rows > 0) {
                            $row = $executar->fetch_assoc();
                            $cod_estoque = $row['cod_estoque'];
                            
                            $InsetItensPicking = "INSERT INTO itenspicking (Quantidade, Situacao, cod_estoque, cod_itemSolicitacao , codTurma)
                            VALUES ('$quantidadeEstoque', 'No processo de picking', '$cod_estoque', '$cod_itempSolicitacao', '{$_SESSION['codTurma']}')";
                            $execute = $conexao->query($InsetItensPicking);

                            if ($execute) {
                                echo json_encode(['success' => true, 'message' => 'Item enviado para Picking', 'newqttespera' => $NewQTTEspera, 'cod_itemSolicitacao' => $cod_itempSolicitacao]);
                                exit();
                            }else {
                                echo json_encode(['success' => false, 'message' => 'Erro ao enviar pedido para o picking']);
                                exit();
                            }
                        }else {
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
