<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Erro na conexão com o banco de dados: " . $conexao->connect_error;
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
    echo ''.$_SESSION['Idprojeto']. '';
}

if (isset($_POST['cod_item_picking'])) {
        // Guardar valor em uma variável
        $cod_item_picking = $conexao->real_escape_string($_POST['cod_item_picking']);

        $query = "SELECT produtos.Nome, produtos.cod_produto, itenspicking.cod_estoque, itenspicking.Quantidade
        FROM produtos
        INNER JOIN itenssolicitacao ON produtos.cod_produto = itenssolicitacao.cod_produto
        INNER JOIN itenspicking ON itenssolicitacao.cod_itemSolicitacao = itenspicking.cod_itemSolicitacao
        WHERE itenspicking.cod_itemPicking = '$cod_item_picking'
        AND itenspicking.Situacao = 'Nas docas' AND
        itenspicking.codTurma = '{$_SESSION['codTurma']}'";

        $resultado = $conexao->query($query);

        if($resultado && $resultado -> num_rows > 0){
            $rowPicking = $resultado -> fetch_assoc();

            $cod_produto_picking = $rowPicking['cod_produto'];
            $cod_estoque_picking = $rowPicking['cod_estoque'];
            $Quantidade_picking = $rowPicking['Quantidade'];

            $SelectItensEstoque = "SELECT produtos.Nome, itensestoque.cod_itenEstoque, itensestoque.Quantidade
            FROM produtos
            INNER JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
            INNER JOIN itensestoque ON itenspedido.cod_itenpedido = itensestoque.cod_itenpedido
            WHERE produtos.cod_produto = '$cod_produto_picking' AND itensestoque.cod_estoque = '$cod_estoque_picking'
            AND itensestoque.Situacao = 'No estoque' AND
            itensestoque.codTurma = '{$_SESSION['codTurma']}'";

            $excuteItensEstoque = $conexao->query($SelectItensEstoque);

            if($excuteItensEstoque && $excuteItensEstoque -> num_rows > 0){
                $rowItensEstoque = $excuteItensEstoque -> fetch_assoc();

                $cod_item_estoque = $rowItensEstoque['cod_itenEstoque'];
                $Quantidade_estoque = $rowItensEstoque['Quantidade'];

                if($Quantidade_estoque > $Quantidade_picking){
                    $newQTTestoque = $Quantidade_estoque - $Quantidade_picking;

                    $updateEstoque = "UPDATE itensestoque SET Quantidade = '$newQTTestoque' WHERE cod_itenEstoque = '$cod_item_estoque' AND codTurma = '{$_SESSION['codTurma']}'";
                    $executeupdateEstoque = $conexao -> query($updateEstoque);

                    if(!$executeupdateEstoque){
                        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar quantia no estoque']);
                        exit();
                    }else{
                        if(!empty($_POST['observacao_solicitacao'])){
                            $observacao_solicitacao = $conexao->real_escape_string($_POST['observacao_solicitacao']);
                
                            $UpdateObservacoes = "UPDATE itenspicking SET observacoes = '$observacao_solicitacao', Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
                            $executeUpdate = $conexao -> query($UpdateObservacoes);
                
                            if($executeUpdate){
                                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Adicionada observação e atualizada Sitaucao do item']);
                                exit();
                            } else{
                                echo json_encode(['success' => false, 'message' => 'Erro ao adicionar observação ao item']);
                                exit();
                            }
                        } else{
                            $UpdateSituacao = "UPDATE itenspicking SET Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
                            $executeUpdateSituacao = $conexao -> query($UpdateSituacao);
                
                            if($executeUpdateSituacao){
                                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Item esperando a transportadora']);
                                exit();
                            } else{
                                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar situação do item']);
                                exit();
                            }
                        } 
                    }
                }else{
                    $deleteitemestoque = "DELETE FROM itensestoque WHERE cod_itenEstoque = '$cod_item_estoque' AND codTurma = '{$_SESSION['codTurma']}'";
                    $executeDeleteEstoque = $conexao -> query($deleteitemestoque);

                    if(!$executeDeleteEstoque){
                        echo json_encode(['success' => false, 'message' => 'Erro ao deletar item do estoque']);
                        exit();
                    } else{
                        if(!empty($_POST['observacao_solicitacao'])){
                            $observacao_solicitacao = $conexao->real_escape_string($_POST['observacao_solicitacao']);
                
                            $UpdateObservacoes = "UPDATE itenspicking SET observacoes = '$observacao_solicitacao', Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
                            $executeUpdate = $conexao -> query($UpdateObservacoes);
                
                            if($executeUpdate){
                                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Adicionada observação e atualizada Sitaucao do item']);
                                exit();
                            } else{
                                echo json_encode(['success' => false, 'message' => 'Erro ao adicionar observação ao item']);
                                exit();
                            }
                        } else{
                            $UpdateSituacao = "UPDATE itenspicking SET Situacao = 'Esperando transportadora' WHERE cod_itemPicking = '$cod_item_picking' AND  codTurma = '{$_SESSION['codTurma']}'";
                            $executeUpdateSituacao = $conexao -> query($UpdateSituacao);
                
                            if($executeUpdateSituacao){
                                echo json_encode(['success' => true, 'Validacao' => 1, 'cod_item_picking' => $cod_item_picking, 'message' => 'Item esperando a transportadora']);
                                exit();
                            } else{
                                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar situação do item']);
                                exit();
                            }
                        } 
                    }
                }
            }else{
                echo json_encode(['success' => false, 'message' => 'Erro ao procurar item no estoque']);
                exit();
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Erro ao puxar item, ou ele não chegou às docas ou já saiu']);
            exit();
        }
}

$conexao->close();
?>