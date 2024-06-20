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
    <link rel="stylesheet" href="../css/danfe.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
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

    echo ' <header>
    <div class="container">
        <div class="main-horizontal">
            <ul class="ul-main">
                <li class="li-main">
                    <div class="teste">
                    <input id="main-button" type="checkbox" />
                        <label for="main-button">
                            <div class="div-button-main">
                                <span class="button-main"></span>
                            </div>
                    </label>
                    <nav>
                        <ul class="ul-button">
                        <li class="li-vertical-menu"><a class="a-vertical-menu" href="">MENU</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="professor.php">MENU</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="perfilprofessor.php">PERFIL</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="ajudaprofessor.php">AJUDA</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="">CONFIGURAÇÕES</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sair.php">SAIR</a></li>
                        </ul>
                    </nav>
                        <div class="juntos">
                            <img src="../css/cssimg/logo.png" style="max-width: 85px; max-height: 85px; margin-left: 20px; margin-top: 15px;">
                            <h1>MOVESYS</h1>
                        </div>
                        <h2>'.$_SESSION['nome'].'</h2>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
    <main>
        <div class="container-prin">
            <div class="submenu">
                <li class="lisubmenu">
                    <a href="projetoprofessor.php" class="functions-menu">VOLTAR</a>
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="criar-danfe-container">
                <div class="titulo-pedido">
                    <h3>MINHAS DANFES</h3>
                </div>
                <div class="info-total">
                    <div class="criar-danfe">
                        <div class="submenus-danfe">
                            <h4>INFORMAÇÕES</h4>
                            <div class="info-danfe">
                                <h5>PEDIDOS:</h5>
                                <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                <a href="meuspedidos.php" class="button-pedidos">Meus Pedidos</a>
                            </div>
                        </div>
                        <div class="criar-danfes-container">
                            <h4>VEJA AQUI AS SUAS DANFES JÁ CRIADAS</h4>
                            <form action="danfe.php" method="POST" style="display: flex;" class="cod-pedido-danfe">
                                <input class="input-cod-danfe" type="text" name="cod_pedido" placeholder="Cod do pedido" style="display: block;">
                                <input class="input-enviar-cod-danfe" type="submit" name="enviar_cod" value="GERAR" style="display: block; width: auto;">
                            </form>
                            <br>';
    
    $sql = "SELECT * FROM pedido  WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
    $execute = $conexao->query($sql);

    if ($execute && $execute->num_rows > 0){
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
                    echo'</div>';
                    } else {
                        echo "<br><br>Destinatário não encontrado";
                    }
                } else {
                    echo "<br><br>Fabricante não encontrado";
                }
            } else {
                echo "<br><br>Transportadora não encontrada";
            }
        } else {
            echo "<br><br>Pedido não encontrado";
        }
    }


if (isset($_POST['enviar_cod']) && !empty($_POST['cod_pedido'])) {
    $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
    
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
                    echo'</div>';

                } else {
                    echo "<br><br>Destinatário não encontrado";
                }
            } else {
                echo "<br><br>Fabricante não encontrado";
            }
        } else {
            echo "<br><br>Transportadora não encontrada";
        }
    } else {
        echo "<br><br>Pedido não encontrado ou não foi finalizado";
    }
}
    }else{
        echo 'Código do pedido não corresponde, por favor verifique os seus pedidos criados';
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
</body>
</html>
