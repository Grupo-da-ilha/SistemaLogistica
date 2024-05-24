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
    if (isset($_POST['Excluir']) && !empty($_POST['codigoItemPedido'])) {
        $cod_item = $_POST['codigoItemPedido'];
        $sql = "DELETE FROM `itenspedido` WHERE cod_itenPedido = '$cod_item'";
        $result = $conexao->query($sql);

        $conexao->close();
        header('Location: ../criarpedido.php', true, 301);
        exit();
    }

    if (isset($_POST['AtualizarQTD']) && !empty($_POST['codigoItemPedido']) && !empty($_POST['QTD'])) {
        $cod_item = $_POST['codigoItemPedido'];
        $Quantidade = $_POST['QTD'];
        $valorUnitario = $_POST['valorUnitario'];
        $valorTotalItem = $Quantidade * $valorUnitario;

        $sql2 = "UPDATE `itenspedido` SET Quantidade = '$Quantidade', ValorTotal = '$valorTotalItem' WHERE cod_itenPedido = '$cod_item'";
        $resultado = $conexao->query($sql2);

        $conexao->close();
        header('Location: ../criarpedido.php', true, 301);
        exit();
    }

    if (isset($_POST['UpdateValor']) && !empty($_SESSION['cod_pedido'])) {
        $sql = "UPDATE `pedido` SET ValorTotal = '" . $_SESSION['ValorTotalPedido'] . "', Situacao = 'Em transporte' WHERE cod_pedido = '" . $_SESSION['cod_pedido'] . "'";
        $resultado = $conexao->query($sql);

        $conexao->close();
        header('Location: ../carga.php', true, 301);
        exit();
    }
}
?>
