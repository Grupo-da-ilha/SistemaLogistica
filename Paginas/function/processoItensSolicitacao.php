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
    //Buscando id do projeto e consequentemente a turma
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

    //Excluir item do pedido
    if (isset($_POST['Excluir']) && !empty($_POST['codigoItemSolicitacao'])) {
        $cod_itemSolicitacao = $_POST['codigoItemSolicitacao'];
        $sql = "DELETE FROM `itenssolicitacao` WHERE cod_itemSolicitacao = '$cod_itemSolicitacao'";
        $result = $conexao->query($sql);

        $conexao->close();
        header('Location: ../solicitacao.php', true, 301);
        exit();
    }

    //Atualizar Quantidade do item 
    if (isset($_POST['AtualizarQTD'])) {
        if (!empty($_POST['codigoItemSolicitacao']) && !empty($_POST['QTD'])) {
            $cod_itemsolicitacao = $_POST['codigoItemSolicitacao'];
            $Quantidade = $_POST['QTD'];

            $sql2 = "UPDATE `itenssolicitacao` SET Quantidade = '$Quantidade' WHERE cod_itemSolicitacao = '$cod_itemsolicitacao'";
            $resultado = $conexao->query($sql2);

            $conexao->close();
            header('Location: ../solicitacao.php', true, 301);
            exit();     
        } else {
            echo 'Quantidade não digitada'; 
        }
    }

    //Definindo data e horário atuais
    date_default_timezone_set('America/Sao_Paulo');
    $datahoje = date("Y-m-d H:i:s");

    //Atualizando dados do pedido e da nota fiscal
    if (isset($_POST['UpdateValor']) && !empty($_SESSION['codigoSolicitacao'])) {
        $sql = "UPDATE `solicitacoes` SET Situacao = 'Em processamento' WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
        $resultado = $conexao->query($sql);

        if ($resultado && !empty($_POST['texto'])) {
            $texto = $_POST['texto'];
            $sql = "UPDATE `solicitacoes` SET Observacao = '".$texto."' WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
            $resultado = $conexao->query($sql);
        }
        
        $conexao->close();
        header('Location: ../controlesolicitacoes.php', true, 301);
        exit();
    }
}
?>
