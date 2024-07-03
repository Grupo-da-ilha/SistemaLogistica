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

    if(isset($_POST['nome_produto']) && isset($_POST['UN_produto']) && isset($_POST['Quantidade_produto'])){
        $nome_produto = $conexao -> real_escape_string($_POST['nome_produto']);
        $UN_produto = $conexao -> real_escape_string($_POST['UN_produto']);
        $Quantidade_produto = $conexao -> real_escape_string($_POST['Quantidade_produto']);

        $SelectProduto = "SELECT * FROM produtos WHERE Nome='$nome_produto' AND UN = '$UN_produto'";
        $executeProdutos = $conexao -> query($SelectProduto);

        if($executeProdutos && $executeProdutos -> num_rows > 0){
            $rowProdutos = $executeProdutos -> fetch_assoc();

            $cod_produto = $rowProdutos['cod_produto'];

            $selectItens = "SELECT * FROM itenspedido WHERE cod_produto = '$cod_produto' AND codTurma ='{$_SESSION['codTurma']}'";
            $executeItens = $conexao -> query($selectItens);

            if($executeItens && $executeItens -> num_rows > 0){
                while($rowItens = $executeItens -> fetch_assoc()){
                    $cod_itenpedido = $rowItens['cod_itenPedido'];

                    $selectItensEstoque = "SELECT * FROM itensestoque WHERE cod_itenpedido = '$cod_itenpedido' AND codTurma ='{$_SESSION['codTurma']}' AND Situacao = 'No estoque'";
                    $executeItensEstoque = $conexao -> query($executeItensEstoque);

                    if($executeItensEstoque && $executeItensEstoque -> num_rows > 0){
                        
                    }
                }
            }
        }
    } else{
        echo json_encode(['success' => false, 'message' => 'Dados insuficientes'])
    }
}
?>