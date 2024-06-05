<?php
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Erro na conexão com o banco de dados: " . $conexao->connect_error;
    exit();
}

if (isset($_POST['codProduto'])) {
    $cod_produto = $conexao->real_escape_string($_POST['codProduto']);
    $sql = "SELECT Nome FROM produtos WHERE cod_produto = '$cod_produto'";
    $result = $conexao->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['Nome'];
    } else {
        echo "Produto não encontrado";
    }
}

$conexao->close();
?>