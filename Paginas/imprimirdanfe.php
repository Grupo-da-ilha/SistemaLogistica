<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI/MENU</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="SENAI Supply Chain Solutions">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/menuhorizontal.css"/>
    <link rel="stylesheet" href="../css/imprimirdanfe.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
<script>
        window.onload = function() {
            window.print(); // Abre a caixa de diálogo de impressão assim que a página é carregada
        };
    </script>
<body>
<?php
session_start();
if (isset($_POST['project_id'])) {
    $_SESSION['Idprojeto'] = $_POST['project_id'];
}
if (empty($_SESSION['nome'])) {
    header('Location: sair.php');
    exit();
} else {
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname, $user, $password, $database);

    if ($conexao->connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao->connect_error;
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
    
    if (isset($_POST['enviar_cod']) && !empty($_POST['cod_pedido'])) {
        $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
        $_SESSION['cod_pedido'] = $cod_pedido; 
        $sql = "SELECT id_pedido FROM pedido WHERE cod_pedido = '$cod_pedido' AND codTurma ='{$_SESSION['codTurma']}'";
        $execute = $conexao -> query($sql);

        if($execute -> num_rows > 0){
            $row = $execute -> fetch_assoc();
            $_SESSION['idpedido'] = $row['id_pedido'];
        }
    }

    echo ' 
    <main>
        <br>
                <div class="info-total">
                    <div class="criar-danfe">
                        <div class="criar-danfes-container">
                            <br>';
    
    if(empty($_POST['tipoDanfe'])){
        $_POST['tipoDanfe'] = "";
    }

    if($_POST['tipoDanfe'] == 'Pedido'){
    $sql = "SELECT * FROM pedido  WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
    $execute = $conexao->query($sql);

    if ($execute && $execute->num_rows > 0){

        //Buscando data de entrega
        $rowPedido = $execute -> fetch_assoc();
        $dataentrega = $rowPedido['DataEntrega'];
        $valortotal = $rowPedido['ValorTotal'];

        if(!isset($_POST['enviar_cod']) && empty($_POST['cod_pedido'])){
        $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
                nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.id_pedido
                FROM nota_fiscal WHERE nota_fiscal.id_pedido = '".$_SESSION['idpedido']."' ORDER BY nota_fiscal.id_pedido ASC";

        $execute = $conexao->query($sql);

        if ($execute && $execute->num_rows > 0) {
            $row = $execute->fetch_assoc();
            $CNPJ_fabricante = $row['CNPJ_Emitente'];
            $CNPJ_Transportadora = $row['CNPJ_Transportadora'];
            $CNPJ_destinatario = $row['CNPJ_Destinatario'];
            $cod_nota = $row['cod_nota'];
            $chave_acesso = $row['chave_acesso'];
            $Data_expedicao = $row['DataExpedicao'];
            $InformacoesAdicionais = $row['InformacoesAdicionais'];

            $sqlTransp = "SELECT * FROM transportadoras WHERE CNPJ = '".$CNPJ_Transportadora."'";
            $executeTransp = $conexao->query($sqlTransp);

            if ($executeTransp && $executeTransp->num_rows > 0) {
                $rowTransp = $executeTransp->fetch_assoc();
                $nomeTransp = $rowTransp['Nome'];
                $FrotaTransp = $rowTransp['QuantidadeFrota'];
                $CEPTransp = $rowTransp['CEP'];
                $TelefeoneTransp = $rowTransp['Telefone'];
                $BairroTransp = $rowTransp['bairro'];
                $RuaTransp = $rowTransp['rua'];
                $CidadeTransp = $rowTransp['cidade'];
                $EstadoTransp = $rowTransp['estado'];

                $sqlFabri = "SELECT * FROM fabricantes WHERE CNPJ = '".$CNPJ_fabricante."'";
                $executeFabri = $conexao->query($sqlFabri);

                if ($executeFabri && $executeFabri->num_rows > 0) {
                    $rowFabri = $executeFabri->fetch_assoc();
                    $nomeFabri = $rowFabri['Nome'];
                    $CEPFabri = $rowFabri['CEP'];
                    $TelefeoneFabri = $rowFabri['Telefone'];
                    $BairroFabri = $rowFabri['bairro'];
                    $RuaFabri = $rowFabri['rua'];
                    $CidadeFabri = $rowFabri['cidade'];
                    $EstadoFabri = $rowFabri['estado'];

                    $sqlDest = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_destinatario."'";
                    $executeDest = $conexao->query($sqlDest);

                    if ($executeDest && $executeDest->num_rows > 0) {
                        $rowDest = $executeDest->fetch_assoc();
                        $nomeDest = $rowDest['Nome'];
                        $CEPDest = $rowDest['CEP'];
                        $TelefeoneDest = $rowDest['Telefone'];
                        $BairroDest = $rowDest['bairro'];
                        $RuaDest = $rowDest['rua'];
                        $CidadeDest = $rowDest['cidade'];
                        $EstadoDest = $rowDest['estado'];
                        echo '<div class="danfe">
                    <div class="logo-danfe">
                    <img src="../css/cssimg/logo.png" style="width: 100%;">
                    </div>
                    <div class="coddanfe">';
                    echo '<h5>CÓDIGO PEDIDO: ' . htmlspecialchars($_SESSION['cod_pedido']) . '</h5>
                    </div>
                    <div class="infos-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DANFE</h7>';
                    echo '</div>';
                    echo '<div style="display: flex; flex-direction: row;"><p>Código da DANFE:</p><p style="font-weight: bold;"> ' . htmlspecialchars($cod_nota) . '</p></div>';
                    echo '<p>Chave de acesso da DANFE: ' . htmlspecialchars($chave_acesso) . '</p>';
                    echo '<p>Data de Emissão: ' . htmlspecialchars($Data_expedicao) . '</p>';
                    echo '<p>Data de Entrega: ' . htmlspecialchars($dataentrega) . '</p>';
                    echo '<p>Valor Total: ' . htmlspecialchars($valortotal) . '</p>';
                    echo'</div>
                    <div class="bar-danfe">
                    </div>
                    <div class="infos-trans">
                    <div class="titulo-div-danfe">';
                    echo '<h7>TRANSPORTADORA: ' . htmlspecialchars($nomeTransp) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_Transportadora) . '</p>';
                    echo '<p>Quantidade de Frota: ' . htmlspecialchars($FrotaTransp) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneTransp) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPTransp) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroTransp) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaTransp) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeTransp) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoTransp) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-fornecedor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>FORNECEDOR: ' . htmlspecialchars($nomeFabri) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_fabricante) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneFabri) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPFabri) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroFabri) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaFabri) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeFabri) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoFabri) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-recptor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>DESTINATÁRIO: ' . htmlspecialchars($nomeDest) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_destinatario) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneDest) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPDest) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroDest) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaDest) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeDest) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoDest) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-adicionais">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES ADICIONAIS:</h7>';
                    echo '</div>';
                    echo '<p>Informações Adicionais: ' . htmlspecialchars($InformacoesAdicionais) . '</p>';
                    echo'</div>';
                    echo'<div class="itens-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DO PEDIDO:</h7>';
                    echo '</div>';
                    echo '<div class="tabela-itens">
                                <div class="sub-produtos"> NOME </div>
                                <div class="sub-produtos"> QUANTIDADE </div>
                                <div class="sub-produtos"> VALOR UNITÁRIO </div>
                                <div class="sub-produtos"> VALOR TOTAL </div>
                                <div class="sub-produtos"> UN </div>
                                <div class="sub-produtos"> SKU </div>
                            </div>';
                         //Buscas itenspedido 
                            $selectItens = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['idpedido']."' AND codTurma ='{$_SESSION['codTurma']}'";
                            $executeItens = $conexao -> query($selectItens);

                            if($executeItens && $executeItens -> num_rows > 0){
                                while($rowitens = $executeItens -> fetch_assoc()){

                                    //Informações dos itens
                                    $cod_produto = $rowitens['cod_produto'];
                                    $QuantidadeItem = $rowitens['Quantidade'];
                                    $ValorUnitario = $rowitens['ValorUnitario'];
                                    $ValorTotalItem = $rowitens['ValorTotal'];


                                    $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                    $executeProdutos = $conexao -> query($selectProdutos);

                                    if($executeProdutos && $executeProdutos -> num_rows > 0){

                                        while($rowProdutos = $executeProdutos-> fetch_assoc()){
                                        
                                        //Informações dos Produtos
                                        $nome_produto = $rowProdutos['Nome'];
                                        $UN_produto = $rowProdutos['UN'];
                                        $NCM_produto = $rowProdutos['NCM'];
                                        $SKU_produto = $rowProdutos['SKU'];

                                        echo '
                                        <div class="caixa-itens">
                                            <div class="itens-pedido">
                                                <div class="info-itens-pedido">' . htmlspecialchars($nome_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($QuantidadeItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($ValorUnitario) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($ValorTotalItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($UN_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($SKU_produto) . '</div>
                                            </div>    
                                        </div>
                                        ';
                                        
                                    }
                                    echo'</table>';
                                    }else{
                                        echo 'erro sql produtos';
                                    }
                                }
                            }else{
                                echo 'erro sql itenspedido';
                            }
                    echo'</div>';
                    echo'</div>';
                    echo'</div>';
                    
                    } else {
                        echo "<p>Destinatário não encontrado</p>";
                    }
                } else {
                    echo "<p>Fabricante não encontrado</p>";
                }
            } else {
                echo "<p>Transportadora não encontrada</p>";
            }
        } else {
            echo "<p>Pedido não encontrado</p>";
        }
    }


if (isset($_POST['enviar_cod']) && !empty($_POST['cod_pedido'])) {
    $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);

    
    $sqlPedido = "SELECT * FROM pedido  WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
    $executarPedido = $conexao->query($sqlPedido);

    if($executarPedido && $executarPedido -> num_rows > 0){
        $rowPedido2 = $executarPedido -> fetch_assoc();
        $dataEntrega = $rowPedido2['DataEntrega'];
        $valorTotal = $rowPedido2['ValorTotal'];
    }else{
        echo 'erro';
    }
    
    $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
            nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.id_pedido
            FROM nota_fiscal WHERE nota_fiscal.id_pedido = '".$_SESSION['idpedido']."' ORDER BY nota_fiscal.id_pedido ASC";

    $execute = $conexao->query($sql);

    if ($execute && $execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $CNPJ_fabricante = $row['CNPJ_Emitente'];
        $CNPJ_Transportadora = $row['CNPJ_Transportadora'];
        $CNPJ_destinatario = $row['CNPJ_Destinatario'];
        $cod_nota = $row['cod_nota'];
        $chave_acesso = $row['chave_acesso'];
        $Data_expedicao = $row['DataExpedicao'];
        $InformacoesAdicionais = $row['InformacoesAdicionais'];

        $sqlTransp = "SELECT * FROM transportadoras WHERE CNPJ = '".$CNPJ_Transportadora."'";
        $executeTransp = $conexao->query($sqlTransp);

        if ($executeTransp && $executeTransp->num_rows > 0) {
            $rowTransp = $executeTransp->fetch_assoc();
            $nomeTransp = $rowTransp['Nome'];
            $FrotaTransp = $rowTransp['QuantidadeFrota'];
            $CEPTransp = $rowTransp['CEP'];
            $TelefeoneTransp = $rowTransp['Telefone'];
            $BairroTransp = $rowTransp['bairro'];
            $RuaTransp = $rowTransp['rua'];
            $CidadeTransp = $rowTransp['cidade'];
            $EstadoTransp = $rowTransp['estado'];

            $sqlFabri = "SELECT * FROM fabricantes WHERE CNPJ = '".$CNPJ_fabricante."'";
            $executeFabri = $conexao->query($sqlFabri);

            if ($executeFabri && $executeFabri->num_rows > 0) {
                $rowFabri = $executeFabri->fetch_assoc();
                $nomeFabri = $rowFabri['Nome'];
                $CEPFabri = $rowFabri['CEP'];
                $TelefeoneFabri = $rowFabri['Telefone'];
                $BairroFabri = $rowFabri['bairro'];
                $RuaFabri = $rowFabri['rua'];
                $CidadeFabri = $rowFabri['cidade'];
                $EstadoFabri = $rowFabri['estado'];

                $sqlDest = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_destinatario."'";
                $executeDest = $conexao->query($sqlDest);

                if ($executeDest && $executeDest->num_rows > 0) {
                    $rowDest = $executeDest->fetch_assoc();
                    $nomeDest = $rowDest['Nome'];
                    $CEPDest = $rowDest['CEP'];
                    $TelefeoneDest = $rowDest['Telefone'];
                    $BairroDest = $rowDest['bairro'];
                    $RuaDest = $rowDest['rua'];
                    $CidadeDest = $rowDest['cidade'];
                    $EstadoDest = $rowDest['estado'];
                    echo '<div class="danfe">
                    <div class="logo-danfe">
                    <img src="../css/cssimg/logo.png" style="width: 100%;">
                    </div>
                    <div class="coddanfe">';
                    echo '<h5>CÓDIGO PEDIDO: ' . htmlspecialchars($_SESSION['cod_pedido']) . '</h5>
                    </div>
                    <div class="infos-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DANFE</h7>';
                    echo '</div>';
                    echo '<p>Código da DANFE: ' . htmlspecialchars($cod_nota) . '</p>';
                    echo '<p>Chave de acesso da DANFE: ' . htmlspecialchars($chave_acesso) . '</p>';
                    echo '<p>Data de Emissão: ' . htmlspecialchars($Data_expedicao) . '</p>';
                    echo '<p>Data de Emissão: ' . htmlspecialchars($dataEntrega) . '</p>';
                    echo '<p>Valor Total: ' . htmlspecialchars($valorTotal) . '</p>';
                    echo'</div>
                    <div class="bar-danfe">
                    </div>
                    <div class="infos-trans">
                    <div class="titulo-div-danfe">';
                    echo '<h7>TRANSPORTADORA: ' . htmlspecialchars($nomeTransp) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_Transportadora) . '</p>';
                    echo '<p>Quantidade de Frota: ' . htmlspecialchars($FrotaTransp) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneTransp) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPTransp) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroTransp) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaTransp) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeTransp) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoTransp) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-fornecedor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>FORNECEDOR: ' . htmlspecialchars($nomeFabri) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_fabricante) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneFabri) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPFabri) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroFabri) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaFabri) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeFabri) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoFabri) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-recptor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>DESTINATÁRIO: ' . htmlspecialchars($nomeDest) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_destinatario) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneDest) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPDest) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroDest) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaDest) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeDest) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoDest) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-adicionais">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES ADICIONAIS:</h7>';
                    echo '</div>';
                    echo '<p>Informações Adicionais: ' . htmlspecialchars($InformacoesAdicionais) . '</p>';
                    echo'</div>';
                    echo'<div class="itens-danfe">
                    <div class="titulo-div-danfe-itens">';
                    echo '<h7>INFORMAÇÕES DO PEDIDO:</h7>';
                    echo '</div>';
                    echo '<div class="tabela-itens">
                                <div class="sub-produtos"> NOME </div>
                                <div class="sub-produtos"> QUANTIDADE </div>
                                <div class="sub-produtos"> VALOR UNITÁRIO </div>
                                <div class="sub-produtos"> VALOR TOTAL </div>
                                <div class="sub-produtos"> UN </div>
                            </div>';
                         //Buscas itenspedido 
                            $selectItens = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['idpedido']."' AND codTurma ='{$_SESSION['codTurma']}'";
                            $executeItens = $conexao -> query($selectItens);

                            if($executeItens && $executeItens -> num_rows > 0){
                                while($rowitens = $executeItens -> fetch_assoc()){

                                    //Informações dos itens
                                    $cod_produto = $rowitens['cod_produto'];
                                    $QuantidadeItem = $rowitens['Quantidade'];
                                    $ValorUnitario = $rowitens['ValorUnitario'];
                                    $ValorTotalItem = $rowitens['ValorTotal'];


                                    $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                    $executeProdutos = $conexao -> query($selectProdutos);

                                    if($executeProdutos && $executeProdutos -> num_rows > 0){

                                        while($rowProdutos = $executeProdutos-> fetch_assoc()){
                                        
                                        //Informações dos Produtos
                                        $nome_produto = $rowProdutos['Nome'];
                                        $UN_produto = $rowProdutos['UN'];
                                        $NCM_produto = $rowProdutos['NCM'];

                                        echo '
                                        <div class="caixa-itens">
                                            <div class="itens-pedido">
                                                <div class="info-itens-pedido">' . htmlspecialchars($nome_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($QuantidadeItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($ValorUnitario) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($ValorTotalItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($UN_produto) . '</div>
                                            </div>    
                                        </div>
                                        ';
                                        
                                    }
                                    echo'</table>';
                                    }else{
                                        echo 'erro sql produtos';
                                    }
                                }
                            }else{
                                echo 'erro sql itenspedido';
                            }
                    echo'</div>';
                    echo'</div>';

                } else {
                    echo "<p>Destinatário não encontrado</p>";
                }
            } else {
                echo "<p>Fabricante não encontrado</p>";
            }
        } else {
            echo "<p>Transportadora não encontrada</p>";
        }
    } else {
        echo "<p>Pedido não encontrado ou não foi finalizado</p>";
    }
}
    }else{
        echo '<p>Código do pedido não corresponde, por favor verifique os seus pedidos criados</p>';
    }
} else{
    $sql = "SELECT * FROM solicitacoes  WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
    $execute = $conexao->query($sql);

    if ($execute && $execute->num_rows > 0){

        //Buscando data de entrega
        $rowSolicitacao = $execute -> fetch_assoc();
        $data_criacao = $rowSolicitacao['Data_criacao'];

        if(!isset($_POST['enviar_cod']) && empty($_POST['cod_pedido'])){
        $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
                nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.id_solicitacao
                FROM nota_fiscal WHERE nota_fiscal.id_solicitacao = '".$_SESSION['id_solicitacao']."' ORDER BY nota_fiscal.id_solicitacao ASC";

        $execute = $conexao->query($sql);

        if ($execute && $execute->num_rows > 0) {
            $row = $execute->fetch_assoc();
            $CNPJ_emitente = $row['CNPJ_Emitente'];
            $CNPJ_Transportadora = $row['CNPJ_Transportadora'];
            $CNPJ_destinatario = $row['CNPJ_Destinatario'];
            $cod_nota = $row['cod_nota'];
            $chave_acesso = $row['chave_acesso'];
            $Data_expedicao = $row['DataExpedicao'];
            $InformacoesAdicionais = $row['InformacoesAdicionais'];

            $sqlTransp = "SELECT * FROM transportadoras WHERE CNPJ = '".$CNPJ_Transportadora."'";
            $executeTransp = $conexao->query($sqlTransp);

            if ($executeTransp && $executeTransp->num_rows > 0) {
                $rowTransp = $executeTransp->fetch_assoc();
                $nomeTransp = $rowTransp['Nome'];
                $FrotaTransp = $rowTransp['QuantidadeFrota'];
                $CEPTransp = $rowTransp['CEP'];
                $TelefeoneTransp = $rowTransp['Telefone'];
                $BairroTransp = $rowTransp['bairro'];
                $RuaTransp = $rowTransp['rua'];
                $CidadeTransp = $rowTransp['cidade'];
                $EstadoTransp = $rowTransp['estado'];

                $sqlFabri = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_emitente."'";
                $executeFabri = $conexao->query($sqlFabri);

                if ($executeFabri && $executeFabri->num_rows > 0) {
                    $rowFabri = $executeFabri->fetch_assoc();
                    $nomeFabri = $rowFabri['Nome'];
                    $CEPFabri = $rowFabri['CEP'];
                    $TelefeoneFabri = $rowFabri['Telefone'];
                    $BairroFabri = $rowFabri['bairro'];
                    $RuaFabri = $rowFabri['rua'];
                    $CidadeFabri = $rowFabri['cidade'];
                    $EstadoFabri = $rowFabri['estado'];

                    $sqlDest = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_destinatario."'";
                    $executeDest = $conexao->query($sqlDest);

                    if ($executeDest && $executeDest->num_rows > 0) {
                        $rowDest = $executeDest->fetch_assoc();
                        $nomeDest = $rowDest['Nome'];
                        $CEPDest = $rowDest['CEP'];
                        $TelefeoneDest = $rowDest['Telefone'];
                        $BairroDest = $rowDest['bairro'];
                        $RuaDest = $rowDest['rua'];
                        $CidadeDest = $rowDest['cidade'];
                        $EstadoDest = $rowDest['estado'];
                        echo '<div class="danfe">
                    <div class="logo-danfe">
                    <img src="../css/cssimg/logo.png" style="width: 100%;">
                    </div>
                    <div class="coddanfe">';
                    echo '<h5>CÓDIGO DA SOLICITAÇÃO: ' . htmlspecialchars($_SESSION['cod_solicitacao']) . '</h5>
                    </div>
                    <div class="infos-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DANFE</h7>';
                    echo '</div>';
                    echo '<div style="display: flex; flex-direction: row;"><p>Código da DANFE:</p><p style="font-weight: bold;"> ' . htmlspecialchars($cod_nota) . '</p></div>';
                    echo '<p>Chave de acesso da DANFE: ' . htmlspecialchars($chave_acesso) . '</p>';
                    echo '<p>Data de Emissão: ' . htmlspecialchars($Data_expedicao) . '</p>';
                    echo'</div>
                    <div class="barras-danfe">
                    </div>
                    <div class="infos-trans">
                    <div class="titulo-div-danfe">';
                    echo '<h7>TRANSPORTADORA: ' . htmlspecialchars($nomeTransp) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_Transportadora) . '</p>';
                    echo '<p>Quantidade de Frota: ' . htmlspecialchars($FrotaTransp) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneTransp) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPTransp) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroTransp) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaTransp) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeTransp) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoTransp) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-fornecedor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>FORNECEDOR: ' . htmlspecialchars($nomeFabri) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_emitente) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneFabri) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPFabri) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroFabri) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaFabri) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeFabri) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoFabri) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-recptor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>DESTINATÁRIO: ' . htmlspecialchars($nomeDest) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_destinatario) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneDest) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPDest) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroDest) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaDest) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeDest) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoDest) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-adicionais">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES ADICIONAIS:</h7>';
                    echo '</div>';
                    echo '<p>Informações Adicionais: ' . htmlspecialchars($InformacoesAdicionais) . '</p>';
                    echo'</div>';
                    echo'<div class="itens-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DO PEDIDO:</h7>';
                    echo '</div>';
                    echo '<div class="tabela-itens">
                                <div class="sub-produtos"> NOME </div>
                                <div class="sub-produtos"> QUANTIDADE </div>
                                <div class="sub-produtos"> UN </div>
                                <div class="sub-produtos"> NCM </div>
                                <div class="sub-produtos"> SKU </div>
                            </div>';
                         //Buscas itenspedido 
                            $selectItens = "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '".$_SESSION['id_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}'";
                            $executeItens = $conexao -> query($selectItens);

                            if($executeItens && $executeItens -> num_rows > 0){
                                while($rowitens = $executeItens -> fetch_assoc()){

                                    //Informações dos itens
                                    $cod_produto = $rowitens['cod_produto'];
                                    $QuantidadeItem = $rowitens['Quantidade'];


                                    $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                    $executeProdutos = $conexao -> query($selectProdutos);

                                    if($executeProdutos && $executeProdutos -> num_rows > 0){

                                        while($rowProdutos = $executeProdutos-> fetch_assoc()){
                                        
                                        //Informações dos Produtos
                                        $nome_produto = $rowProdutos['Nome'];
                                        $UN_produto = $rowProdutos['UN'];
                                        $NCM_produto = $rowProdutos['NCM'];
                                        $SKU_produto = $rowProdutos['SKU'];

                                        echo '
                                        <div class="caixa-itens">
                                            <div class="itens-pedido">
                                                <div class="info-itens-pedido">' . htmlspecialchars($nome_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($QuantidadeItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($UN_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($NCM_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($SKU_produto) . '</div>
                                            </div>    
                                        </div>
                                        ';
                                        
                                    }
                                    echo'</table>';
                                    }else{
                                        echo 'erro sql produtos';
                                    }
                                }
                            }else{
                                echo 'erro sql itenspedido';
                            }
                    echo'</div>';
                    echo'</div>';
                    echo'</div>';
                    
                    } else {
                        echo "<p>Destinatário não encontrado</p>";
                    }
                } else {
                    echo "<p>Fabricante não encontrado</p>";
                }
            } else {
                echo "<p>Transportadora não encontrada</p>";
            }
        } else {
            echo "<p>Pedido não encontrado</p>";
        }
    }


if (isset($_POST['enviar_cod']) && !empty($_POST['cod_pedido'])) {
    $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);

    
    $sqlSolicitacao = "SELECT * FROM solicitacoes  WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
    $executarSolicitacao = $conexao->query($sqlSolicitacao);

    if($executarSolicitacao && $executarSolicitacao -> num_rows > 0){
        $rowSolicitacao2 = $executarSolicitacao -> fetch_assoc();
        $Data_Criacao = $rowSolicitacao2['Data_criacao'];
    }else{
        echo 'erro';
    }
    
    $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
            nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.id_solicitacao
            FROM nota_fiscal WHERE nota_fiscal.id_solicitacao = '".$_SESSION['id_solicitacao']."' ORDER BY nota_fiscal.id_solicitacao ASC";

    $execute = $conexao->query($sql);

    if ($execute && $execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $CNPJ_emitente = $row['CNPJ_Emitente'];
        $CNPJ_Transportadora = $row['CNPJ_Transportadora'];
        $CNPJ_destinatario = $row['CNPJ_Destinatario'];
        $cod_nota = $row['cod_nota'];
        $chave_acesso = $row['chave_acesso'];
        $Data_expedicao = $row['DataExpedicao'];
        $InformacoesAdicionais = $row['InformacoesAdicionais'];

        $sqlTransp = "SELECT * FROM transportadoras WHERE CNPJ = '".$CNPJ_Transportadora."'";
        $executeTransp = $conexao->query($sqlTransp);

        if ($executeTransp && $executeTransp->num_rows > 0) {
            $rowTransp = $executeTransp->fetch_assoc();
            $nomeTransp = $rowTransp['Nome'];
            $FrotaTransp = $rowTransp['QuantidadeFrota'];
            $CEPTransp = $rowTransp['CEP'];
            $TelefeoneTransp = $rowTransp['Telefone'];
            $BairroTransp = $rowTransp['bairro'];
            $RuaTransp = $rowTransp['rua'];
            $CidadeTransp = $rowTransp['cidade'];
            $EstadoTransp = $rowTransp['estado'];

            $sqlFabri = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_emitente."'";
            $executeFabri = $conexao->query($sqlFabri);

            if ($executeFabri && $executeFabri->num_rows > 0) {
                $rowFabri = $executeFabri->fetch_assoc();
                $nomeFabri = $rowFabri['Nome'];
                $CEPFabri = $rowFabri['CEP'];
                $TelefeoneFabri = $rowFabri['Telefone'];
                $BairroFabri = $rowFabri['bairro'];
                $RuaFabri = $rowFabri['rua'];
                $CidadeFabri = $rowFabri['cidade'];
                $EstadoFabri = $rowFabri['estado'];

                $sqlDest = "SELECT * FROM clientes WHERE CNPJ = '".$CNPJ_destinatario."'";
                $executeDest = $conexao->query($sqlDest);

                if ($executeDest && $executeDest->num_rows > 0) {
                    $rowDest = $executeDest->fetch_assoc();
                    $nomeDest = $rowDest['Nome'];
                    $CEPDest = $rowDest['CEP'];
                    $TelefeoneDest = $rowDest['Telefone'];
                    $BairroDest = $rowDest['bairro'];
                    $RuaDest = $rowDest['rua'];
                    $CidadeDest = $rowDest['cidade'];
                    $EstadoDest = $rowDest['estado'];
                    echo '<div class="danfe">
                    <div class="logo-danfe">
                    <img src="../css/cssimg/logo.png" style="width: 100%;">
                    </div>
                    <div class="coddanfe">';
                    echo '<h5>CÓDIGO DA SOLICITAÇÃO: ' . htmlspecialchars($_SESSION['cod_solicitacao']) . '</h5>
                    </div>
                    <div class="infos-danfe">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES DANFE</h7>';
                    echo '</div>';
                    echo '<p>Código da DANFE: ' . htmlspecialchars($cod_nota) . '</p>';
                    echo '<p>Chave de acesso da DANFE: ' . htmlspecialchars($chave_acesso) . '</p>';
                    echo '<p>Data de Emissão: ' . htmlspecialchars($Data_expedicao) . '</p>';
                    echo'</div>
                    <div class="barras-danfe">
                    </div>
                    <div class="infos-trans">
                    <div class="titulo-div-danfe">';
                    echo '<h7>TRANSPORTADORA: ' . htmlspecialchars($nomeTransp) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_Transportadora) . '</p>';
                    echo '<p>Quantidade de Frota: ' . htmlspecialchars($FrotaTransp) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneTransp) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPTransp) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroTransp) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaTransp) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeTransp) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoTransp) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-fornecedor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>FORNECEDOR: ' . htmlspecialchars($nomeFabri) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_emitente) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneFabri) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPFabri) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroFabri) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaFabri) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeFabri) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoFabri) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-recptor">
                    <div class="titulo-div-danfe">';
                    echo '<h7>DESTINATÁRIO: ' . htmlspecialchars($nomeDest) . '</h7>';
                    echo '</div>';
                    echo '<p>CNPJ: ' . htmlspecialchars($CNPJ_destinatario) . '</p>';
                    echo '<p>Telefone: ' . htmlspecialchars($TelefeoneDest) . '</p>';
                    echo '<p>CEP: ' . htmlspecialchars($CEPDest) . '</p>';
                    echo '<p>Bairro: ' . htmlspecialchars($BairroDest) . '</p>';
                    echo '<p>Rua: ' . htmlspecialchars($RuaDest) . '</p>';
                    echo '<p>Cidade: ' . htmlspecialchars($CidadeDest) . '</p>';
                    echo '<p>Estado: ' . htmlspecialchars($EstadoDest) . '</p>';
                    echo'</div>';
                    echo'<div class="infos-adicionais">
                    <div class="titulo-div-danfe">';
                    echo '<h7>INFORMAÇÕES ADICIONAIS:</h7>';
                    echo '</div>';
                    echo '<p>Informações Adicionais: ' . htmlspecialchars($InformacoesAdicionais) . '</p>';
                    echo'</div>';
                    echo'<div class="itens-danfe">
                    <div class="titulo-div-danfe-itens">';
                    echo '<h7>INFORMAÇÕES DO PEDIDO:</h7>';
                    echo '</div>';
                    echo '<div class="tabela-itens">
                                <div class="sub-produtos"> NOME </div>
                                <div class="sub-produtos"> QUANTIDADE </div>
                                <div class="sub-produtos"> UN </div>
                                <div class="sub-produtos"> NCM </div>
                                <div class="sub-produtos"> SKU </div>
                            </div>';
                         //Buscas itenspedido 
                            $selectItens = "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '".$_SESSION['id_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}'";
                            $executeItens = $conexao -> query($selectItens);

                            if($executeItens && $executeItens -> num_rows > 0){
                                while($rowitens = $executeItens -> fetch_assoc()){

                                    //Informações dos itens
                                    $cod_produto = $rowitens['cod_produto'];
                                    $QuantidadeItem = $rowitens['Quantidade'];


                                    $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                    $executeProdutos = $conexao -> query($selectProdutos);

                                    if($executeProdutos && $executeProdutos -> num_rows > 0){

                                        while($rowProdutos = $executeProdutos-> fetch_assoc()){
                                        
                                        //Informações dos Produtos
                                        $nome_produto = $rowProdutos['Nome'];
                                        $UN_produto = $rowProdutos['UN'];
                                        $NCM_produto = $rowProdutos['NCM'];
                                        $SKU_produto = $rowProdutos['SKU'];

                                        echo '
                                        <div class="caixa-itens">
                                            <div class="itens-pedido">
                                                <div class="info-itens-pedido">' . htmlspecialchars($nome_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($QuantidadeItem) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($UN_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($NCM_produto) . '</div>
                                                <div class="info-itens-pedido">' . htmlspecialchars($SKU_produto) . '</div>
                                            </div>    
                                        </div>
                                        ';
                                        
                                    }
                                    echo'</table>';
                                    }else{
                                        echo 'erro sql produtos';
                                    }
                                }
                            }else{
                                echo 'erro sql itenspedido';
                            }
                    echo'</div>';
                    echo'</div>';

                } else {
                    echo "<p>Destinatário não encontrado</p>";
                }
            } else {
                echo "<p>Emitente não encontrado</p>";
            }
        } else {
            echo "<p>Transportadora não encontrada</p>";
        }
    } else {
        echo "<p>Pedido não encontrado ou não foi finalizado</p>";
    }
}
    }else{
        echo '<p>Código da solicitação não corresponde, por favor verifique os seus pedidos criados</p>';
    }
}
}

    echo ' 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>';
?>
<script>
</script>
</body>
</html>
