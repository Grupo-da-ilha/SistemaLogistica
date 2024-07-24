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

if (isset($_POST['NomeProduto'])) {
        // Guardar valor em uma variável
        $nomeProdutoDigitado = $conexao->real_escape_string($_POST['NomeProduto']);
    
        // Consulta para encontrar produtos no estoque com o nome digitado
        $query = "SELECT produtos.Nome
                  FROM produtos
                  INNER JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
                  INNER JOIN itensestoque ON itenspedido.cod_itenpedido = itensestoque.cod_itenpedido
                  WHERE produtos.Nome = '$nomeProdutoDigitado'
                  AND itensestoque.Situacao = 'No estoque' AND
                  itensestoque.codTurma = '{$_SESSION['codTurma']}'";
    
        $resultado = $conexao->query($query);
    
        if ($resultado && $resultado->num_rows > 0) {
            echo "Produto no estoque";
        } else {
            echo "Produto não estocado";
        }
}

$conexao->close();
?>