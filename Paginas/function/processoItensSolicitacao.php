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
    if (isset($_POST['AtualizarQTD']) && !empty($_POST['codigoItemSolicitacao']) && !empty($_POST['QTD'])) {
        $cod_itemsolicitacao = $_POST['codigoItemSolicitacao'];
        $Quantidade = $_POST['QTD'];

        $sql2 = "UPDATE `itenssolicitacao` SET Quantidade = '$Quantidade', Quantidade_espera = '$Quantidade' WHERE cod_itemSolicitacao = '$cod_itemsolicitacao'";
        $resultado = $conexao->query($sql2);

        $conexao->close();
        header('Location: ../solicitacao.php', true, 301);
        exit();     
    } else {
        echo 'Quantidade não digitada'; 
    }

    //Definindo data e horário atuais
    date_default_timezone_set('America/Sao_Paulo');
    $datahoje = date("Y-m-d H:i:s");

    //Atualizando dados do pedido e da nota fiscal
    if (isset($_POST['UpdateValor']) && !empty($_POST['codigoSolicitacao']) && !empty($_POST['Tipo_nota'])) {
        $Tipo_nota = $_POST['Tipo_nota'];

        $sql = "UPDATE `solicitacoes` SET Situacao = 'Em processamento' WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
        $resultado = $conexao->query($sql);

        if ($resultado && !empty($_POST['texto'])) {
            $texto = $_POST['texto'];
            $sql = "UPDATE `solicitacoes` SET Observacao = '".$texto."' WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
            $resultado = $conexao->query($sql);
        }

        if ($resultado) {
            $sql = "SELECT solicitacoes.cod_solicitacao, solicitacoes.Data_criacao, solicitacoes.CNPJEmitente, solicitacoes.CNPJ_Destinatario, solicitacoes.CNPJ_Transportadora, solicitacoes.Situacao, solicitacoes.Observacao 
                    FROM `solicitacoes`";
            $execute = $conexao->query($sql);
        
            if ($execute->num_rows > 0) {
                $row = $execute->fetch_assoc();
        
                $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
                        nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.Tipo
                        FROM `nota_fiscal` WHERE id_solicitacao = '{$_SESSION['id_solicitacao']}' AND Tipo = 'Solicitação'";
                $resultado = $conexao->query($sql);
        
                if ($resultado->num_rows > 0) {
                    $sql = "DELETE FROM nota_fiscal WHERE id_solicitacao = '" . $_SESSION['id_solicitacao'] . "' AND Tipo = 'Solicitação'";
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
        
                        $sql = "INSERT INTO nota_fiscal (cod_nota, chave_acesso, DataExpedicao, CNPJ_Destinatario, CNPJ_Transportadora, CNPJ_Emitente, InformacoesAdicionais, id_solicitacao, Tipo) 
                                VALUES ('" . implode($cod_nota) . "', '" . implode($sequencia) . "', '" . $row['Data_criacao'] . "', '" . $row['CNPJ_Destinatario'] . "', '" . $row['CNPJ_Transportadora'] . "', '" . $row['CNPJEmitente'] . "', '" .$texto. "', '" . $_SESSION['id_solicitacao'] . "', '$Tipo_nota')";
        
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
        
                    $sql = "INSERT INTO nota_fiscal (cod_nota, chave_acesso, DataExpedicao, CNPJ_Destinatario, CNPJ_Transportadora, CNPJ_Emitente, InformacoesAdicionais, id_solicitacao, Tipo) 
                            VALUES ('" . implode($cod_nota) . "', '" . implode($sequencia) . "', '" . $row['Data_criacao'] . "', '" . $row['CNPJ_Destinatario'] . "', '" . $row['CNPJ_Transportadora'] . "', '" . $row['CNPJEmitente'] . "', '" . $texto. "', '" . $_SESSION['id_solicitacao'] . "', '$Tipo_nota')";
        
                    $execute = $conexao->query($sql);
                }
            }
        }
        
        $conexao->close();
        header('Location: ../recebimentosolicitacoes.php', true, 301);
        exit();
    } else{
        echo 'Erro ao finalizar solicitação';
    }
}
?>
