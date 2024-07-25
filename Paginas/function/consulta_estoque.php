<?php
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";
$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Failed to connect to MySQL: " . htmlspecialchars($conexao->connect_error);
    exit();
}

// Depuração: Verifique o conteúdo do array $_POST
error_log(print_r($_POST, true));

if (isset($_POST['cod_produto']) && isset($_POST['qtde_estoque'])) {
    $cod_produto = $_POST['cod_produto'];
    $qtde_estoque = $_POST['qtde_estoque'];
    $codTurma = $_SESSION['codTurma']; // Assumindo que você já tem a sessão iniciada

    // Consulta ao banco de dados
    $SelectItenSolicitacaoEstoque = "SELECT produtos.Nome
        FROM produtos
        INNER JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
        INNER JOIN itensestoque ON itenspedido.cod_itenpedido = itensestoque.cod_itenpedido
        WHERE produtos.cod_produto = '$cod_produto'
        AND itensestoque.Situacao = 'No estoque'
        AND itensestoque.codTurma = '$codTurma'
        AND itensestoque.quantidade >= '$qtde_estoque'";

    $resultado = $conexao->query($SelectItenSolicitacaoEstoque);

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $posicoes_estoque = [];

            echo json_encode(array('success' => true, $posicoes_estoque));
            exit();
        }
    } else {
        echo "Nenhum produto encontrado no estoque";
    }
} else {
    echo "Dados não recebidos corretamente.";
}

$conexao->close();
?>
