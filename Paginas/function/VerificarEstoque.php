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

    if(isset($_POST['nome_produto']) && isset($_POST['UN_produto']) && isset($_POST['Quantidade_produto']) && isset($_POST['SKU_produto'])){
        $nome_produto_digitado = $conexao -> real_escape_string($_POST['nome_produto']);
        $UN_produto_digitado = $conexao -> real_escape_string($_POST['UN_produto']);
        $SKU_produto_digitado = $conexao -> real_escape_string($_POST['SKU_produto']);
        $Quantidade_produto_digitada = $conexao -> real_escape_string($_POST['Quantidade_produto']);

        //Pesquisar os produtos e o código do produto com base no nome e UN que a pessoa digitou
        $SelectProduto = "SELECT * FROM produtos WHERE Nome='$nome_produto_digitado' AND UN = '$UN_produto_digitado' AND SKU = '$SKU_produto_digitado'";
        $executeProdutos = $conexao -> query($SelectProduto);

        if($executeProdutos && $executeProdutos -> num_rows > 0){
        while($rowProdutos = $executeProdutos -> fetch_assoc()){
            $cod_produto = $rowProdutos['cod_produto'];

            //Produrar as informações dos itens que estão no estoque
            $selectItens = "SELECT * FROM itenspedido WHERE cod_produto = '$cod_produto' AND codTurma ='{$_SESSION['codTurma']}'";
            $executeItens = $conexao -> query($selectItens);

            if($executeItens && $executeItens->num_rows > 0){
                while($rowItens = $executeItens->fetch_assoc()){
                    $cod_itenpedido = $rowItens['cod_itenPedido'];
            
                    // Procurar todos os itens que estão no estoque
                    $SelectItensEstoque = "SELECT * FROM itensestoque WHERE cod_itenpedido = '$cod_itenpedido' AND Situacao = 'No estoque' AND codTurma ='{$_SESSION['codTurma']}'";
                    $executeEstoque = $conexao->query($SelectItensEstoque);
            
                    if($executeEstoque && $executeEstoque->num_rows > 0){
                        $posicoes_estoque = [];
                        while($rowEstoque = $executeEstoque->fetch_assoc()){
                            $cod_estoque = $rowEstoque['cod_estoque'];
                            $Quantidade_estoque = $rowEstoque['Quantidade'];

                            if($Quantidade_produto_digitada == $Quantidade_estoque){
                                $color = 'green';
                            } elseif($Quantidade_produto_digitada > $Quantidade_estoque){
                                $color = 'red';
                            } else {
                                $color = 'blue';
                            }
                            
                            //Select posicao do estoque
                            $SelectPosicaoEstoque = "SELECT * FROM estoque WHERE cod_estoque = '$cod_estoque'";
                            $executePosicaoEstoque = $conexao -> query($SelectPosicaoEstoque);

                            while($rowEstoque = $executePosicaoEstoque -> fetch_assoc()){
                                $andar = $rowEstoque['Andar'];
                                $Apartamento = $rowEstoque['Apartamento'];

                                $posicao = $andar . $Apartamento;

                                $posicoes_estoque[] = ['cod_estoque' => $cod_estoque, 'color' => $color, 'Quantidade' => $Quantidade_estoque, 'Posicoes' => $posicao];
                        }
                    }
                    echo json_encode(['success' => true, 'message' => 'Quantidade comparada', 'positions' => $posicoes_estoque]);
                    exit();
                }else{
                        echo json_encode(['success' => false, 'message' => 'Erro ao pesquisar itens do estoque']);
                        exit();
                    }
                }
            }  else{
            echo json_encode(['success' => false, 'message' => 'Erro ao pesquisar pelos itens do pedido, este item não foi criado nessa turma']);
            exit();
        }
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Erro ao pesquisar produtos, confira o SKU e a UN do produto']);
    exit();
}
    } else{
        echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
        exit();
    }
}
?>
