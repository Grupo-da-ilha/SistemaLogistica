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

    if (isset($_POST['AtualizarQTD']) && !empty($_POST['codigoItemPedido']) && !empty($_POST['QTD']) && !empty($_SESSION['cod_pedido'])) {
        $cod_item = $_POST['codigoItemPedido'];
        $Quantidade = $_POST['QTD'];
        $valorUnitario = $_POST['valorUnitario'];
        $valorTotalItem = $Quantidade * $valorUnitario;

        $sql2 = "UPDATE `itenspedido` SET Quantidade = '$Quantidade', ValorTotal = '$valorTotalItem' WHERE cod_itenPedido = '$cod_item'";
        $resultado = $conexao->query($sql2);



        $conexao->close();
        header('Location: ../criarpedido.php', true, 301);
        exit();     
        
    } else{
        echo 'Quantidade não digitada'; 
    }

    if (isset($_POST['UpdateValor']) && !empty($_SESSION['cod_pedido'])) {
        $sql = "UPDATE `pedido` SET Situacao = 'Em transporte' WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
        $resultado = $conexao->query($sql);


        if($resultado && !empty($_POST['texto'])){
            $texto = $_POST['texto'];
            $sql = "UPDATE `pedido` SET InformacaoAdicional = '".$texto."' WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
            $resultado = $conexao->query($sql);
        }
        if ($resultado) {
            $sql = "SELECT pedido.cod_pedido, pedido.DataVenda, pedido.ValorTotal, pedido.CNPJEmitente, pedido.CNPJ_Destinatario, pedido.CNPJ_Transportadora, pedido.Situacao, pedido.InformacaoAdicional 
                    FROM `pedido`";
            $execute = $conexao->query($sql);
        
            if ($execute->num_rows > 0) {
                $row = $execute->fetch_assoc();
        
                $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
                        nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario
                        FROM `nota_fiscal` WHERE id_pedido = '{$_SESSION['idpedido']}'";
                $resultado = $conexao->query($sql);
        
                if ($resultado->num_rows > 0) {
                    $sql = "DELETE FROM nota_fiscal WHERE id_pedido = '" . $_SESSION['idpedido'] . "'";
                    $execute = $conexao->query($sql);
        
                    if ($execute) {
                        $total_numeros = 44;
                        $sequencia = array();
        
                        for ($i = 0; $i < $total_numeros; $i++) {
                            $numero_aleatorio = rand(0, 9);
                            $sequencia[] = $numero_aleatorio;
                        }
        
                        $total_numero = 5 ;
                        $cod_nota = array();
        
                        for ($i = 0; $i < $total_numero; $i++) {
                            $numero_aleatorio = rand(0, 9);
                            $cod_nota[] = $numero_aleatorio;
                        }
        
                        $sql = "INSERT INTO nota_fiscal (cod_nota, chave_acesso, DataExpedicao, CNPJ_Destinatario, CNPJ_Transportadora, CNPJ_Emitente, InformacoesAdicionais, id_pedido) 
                                VALUES ('" . implode($cod_nota) . "', '" . implode($sequencia) . "', '" . $row['DataVenda'] . "', '" . $row['CNPJ_Destinatario'] . "', '" . $row['CNPJ_Transportadora'] . "', '" . $row['CNPJEmitente'] . "', '" .$texto. "', '" . $_SESSION['idpedido'] . "')";
        
                        $execute = $conexao->query($sql);
                    }
                } else {
                    $total_numeros = 44;
                    $sequencia = array();
        
                    for ($i = 0; $i < $total_numeros; $i++) {
                        $numero_aleatorio = rand(0, 9);
                        $sequencia[] = $numero_aleatorio;
                    }
        
                    $total_numero = 5;
                    $cod_nota = array();
        
                    for ($i = 0; $i < $total_numero; $i++) {
                        $numero_aleatorio = rand(0, 9);
                        $cod_nota[] = $numero_aleatorio;
                    }
        
                    $sql = "INSERT INTO nota_fiscal (cod_nota, chave_acesso, DataExpedicao, CNPJ_Destinatario, CNPJ_Transportadora, CNPJ_Emitente, InformacoesAdicionais, id_pedido) 
                            VALUES ('" . implode($cod_nota) . "', '" . implode($sequencia) . "', '" . $row['DataVenda'] . "', '" . $row['CNPJ_Destinatario'] . "', '" . $row['CNPJ_Transportadora'] . "', '" . $row['CNPJEmitente'] . "', '" . $texto. "', '" . $_SESSION['idpedido'] . "')";
        
                    $execute = $conexao->query($sql);
                }
            }
        }
        
        
        $conexao->close();
        header('Location: ../danfe.php', true, 301);
        exit();
    }
}
?>