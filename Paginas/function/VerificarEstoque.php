<?php
/*session_start();

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

    $posicoes_estoque = [];

    if(isset($_POST['nome_produto']) && isset($_POST['UN_produto']) && isset($_POST['Quantidade_produto'])){
        $nome_produto_digitado = $conexao -> real_escape_string($_POST['nome_produto']);
        $UN_produto_digitado = $conexao -> real_escape_string($_POST['UN_produto']);
        $Quantidade_produto_digitada = $conexao -> real_escape_string($_POST['Quantidade_produto']);

        //Pordurar todos os itens que estão no estoque
        $SelectItensEstoque = "SELECT * FROM itensestoque WHERE Situacao = 'No estoque' AND codTurma ='{$_SESSION['codTurma']}'";
        $executeEstoque = $conexao -> query($SelectItensEstoque);

        if($executeEstoque && $executeEstoque -> num_rows > 0){
            while($rowEstoque = $executeEstoque -> fetch_assoc()){
                $cod_itenpedido = $rowEstoque['cod_itenpedido'];
                $cod_estoque = $rowEstoque['cod_estoque'];
                $Quantidade_estoque = $rowEstoque['Quantidade'];

                //Produrar as informações dos itens que estão no estoque
                $selectItens = "SELECT * FROM itenspedido WHERE cod_itenPedido = '$cod_itenpedido' AND codTurma ='{$_SESSION['codTurma']}'";
                $executeItens = $conexao -> query($selectItens);

                if($executeItens && $executeItens -> num_rows > 0){
                    while($rowItens = $executeItens -> fetch_assoc()){
                        $cod_produto = $rowItens['cod_produto'];

                        //Procurar os produtos baseando no nome, un e no cod_produto
                        $SelectProduto = "SELECT * FROM produtos WHERE Nome='$nome_produto_digitado' AND UN = '$UN_produto_digitado'";
                        $executeProdutos = $conexao -> query($SelectProduto);
                    
                        if($executeProdutos && $executeProdutos -> num_rows > 0){
                            while($rowProdutos = $executeProdutos -> fetch_assoc()){
                                $NomeProduto = $rowProdutos['Nome'];
                                $UN = $rowProdutos['UN'];
                                $cod_Produto = $rowProdutos['cod_produto'];

                                if(($nome_produto_digitado == $NomeProduto) && ($UN_produto_digitado == $UN) && ($cod_produto == $cod_Produto)){
                                    // Achou o produto, agora verifica a quantidade e determina a cor
                                    $posicoes_estoque = $cod_estoque;
                                    if($Quantidade_produto_digitada == $Quantidade_estoque){
                                        $color = 'green';
                                    } elseif($Quantidade_produto_digitada > $Quantidade_estoque){
                                        $color = 'red';
                                    } else{
                                        $color = 'Blue';
                                    }

                                    // Retorna a posição (cod_estoque) onde o produto está estocado
                                    echo json_encode(['success' => true, 'color' => $color, 'message' => 'Quantidade comparada', 'position' => $posicoes_estoque]);
                                    exit();

                                } else{
                                    echo json_encode(['success' => false, 'message' => 'Dados insuficientes UN e NOME']);
                                    exit();
                                }
                            }
                        } else{
                            echo json_encode(['success' => false, 'message' => 'Erro ao selecionar produtos']);
                            exit();
                        }
                    }
                } else{
                    echo json_encode(['success' => false, 'message' => 'Erro ao selecionar itens do pedido']);
                    exit();
                }
            }
        } else{
            echo json_encode(['success' => false, 'message' => 'Erro ao selecionar produtos do estoque']);
            exit();
        }
    } else{
        echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
        exit();
    }
}*/
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

    if(isset($_POST['nome_produto']) && isset($_POST['UN_produto']) && isset($_POST['Quantidade_produto'])){
        $nome_produto_digitado = $conexao -> real_escape_string($_POST['nome_produto']);
        $UN_produto_digitado = $conexao -> real_escape_string($_POST['UN_produto']);
        $Quantidade_produto_digitada = $conexao -> real_escape_string($_POST['Quantidade_produto']);

        $SelectProduto = "SELECT * FROM produtos WHERE Nome='$nome_produto_digitado' AND UN = '$UN_produto_digitado'";
        $executeProdutos = $conexao -> query($SelectProduto);

        while($rowProdutos = $executeProdutos -> fetch_assoc()){
            $cod_produto = $rowProdutos['cod_produto'];

            //Produrar as informações dos itens que estão no estoque
            $selectItens = "SELECT * FROM itenspedido WHERE cod_produto = '$cod_produto' AND codTurma ='{$_SESSION['codTurma']}'";
            $executeItens = $conexao -> query($selectItens);

            if($executeItens && $executeItens -> num_rows > 0){
                while($rowItens = $executeItens -> fetch_assoc()){
                    $cod_itenpedido = $rowItens['cod_itenPedido'];

                    //Pordurar todos os itens que estão no estoque
                    $SelectItensEstoque = "SELECT * FROM itensestoque WHERE cod_itenpedido = 'cod_itenpedido' AND Situacao = 'No estoque' AND codTurma ='{$_SESSION['codTurma']}'";
                    $executeEstoque = $conexao -> query($SelectItensEstoque);

                    if($executeEstoque && $executeEstoque -> num_rows > 0){
                        
                    }
                }


        }
    }

?>
