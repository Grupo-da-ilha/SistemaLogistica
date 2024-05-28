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
    <link rel="stylesheet" href="../css/carga.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
<?php
// Iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: sair.php');
    exit();
} else {  
    echo ' <header>
        <div class="container">
            <div class="main-horizontal">
                <ul class="ul-main">
                    <li class="li-main">
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
                    </li>
                    <li class="li-main">
                        <h1>SENAI SCP</h1>
                        <h2>'.$_SESSION['nome'].'</h2>
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
                    <a href="criarpedido.php" class="functions-menu">PEDIDO</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="recebimentocontainer">
                <div class="titulo-recebimento">
                    <h3>VISTORIA E CONFERÊNCIA CARGA</h3>    
                </div>
                <div class="info-total">
                    <div class="vistoria-carga">
                        <div class="notafiscal">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-recebimento">
                                <form action="carga.php" method="POST">
                                    <h5>NOTA FISCAL:</h5>
                                    <input type="text" id="idnotafiscal" class="idnotafiscal" name="nota_fiscal" placeholder="N° Nota fiscal:" >
                                    <h5>PEDIDO DE COMPRA:</h5>
                                    <input type="text" id="pedidodecompra" class="pedidodecompra" name="cod_pedido" placeholder="Pedido de compra:" >
                                    <input type="submit" id="enviar-recebimento-pedido" name="enviar-pedido" value="ENVIAR" style="display:block; margin-top: 5px;" onsubmit="ShowDoca();">
                                    <h5 style="display: none">DOCA:</h5>
                                    <input type="text" id="doca" class="doca" placeholder="Doca:" style="display: none" name="doca">
                                    <input type="submit" id="enviar-recebimento-carga" value="ENVIAR" style="display: none" name="enviar_doca">
                                </form>
                            </div>
                        </div>';
                            $hostname = "127.0.0.1";
                            $user = "root";
                            $password = "";
                            $database = "logistica";

                            $conexao = new mysqli($hostname, $user, $password, $database);

                            if ($conexao->connect_errno) {
                                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                                exit();
                            } else {
                                if(isset($_POST['enviar-pedido']) && !empty($_POST['cod_pedido']) && !empty($_POST['nota_fiscal'])){
                                    $_SESSION['cod_nota'] = $_POST['nota_fiscal'];
                                    $_SESSION['cod_pedido'] = $_POST['cod_pedido'];

                                    if(isset($_POST['enviar_doca']) && !empty($_POST['doca'])){
                                        $doca = $_POST['doca'];
    
                                        $sql = "INSERT INTO docas (cod_doca, Nome, cod_pedido)
                                                VALUES ('".$doca."', '".$_SESSION['cod_pedido']."')";
                                        $execute = $conexao -> query($sql);                                   
                                    }else{  
                                        echo 'Erro ao inserir pedido nas docas';
                                    }

                                    $sql = "SELECT * FROM nota_fiscal WHERE cod_nota = '".$_SESSION['cod_nota']."'";
                                    $execute = $conexao -> query($sql);

                                    if($execute && $execute -> num_rows > 0){
                                        $row = $execute -> fetch_assoc();
                                        $sql = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."'";
                                        $execute = $conexao -> query($sql);

                                        if($execute && $execute -> num_rows > 0){
                                            $row = $execute -> fetch_assoc();
                                            $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."'";
                                            $execute = $conexao -> query($sql);

                                            if($execute && $execute -> num_rows > 0){
                                                $rowitem = $execute -> fetch_assoc();
                                                $Quantidade = $rowitem['Quantidade'];
                                                $codProduto = $rowitem['cod_produto'];
                                                $ValorTotal = $rowitem['ValorTotal'];
                                                $CoditemPedido = $rowitem['cod_itenPedido'];

                                                $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                FROM produtos 
                                                LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                WHERE itenspedido.cod_pedido = '".$_SESSION['cod_pedido']."' ORDER BY produtos.Nome ASC";
                                                $execute = $conexao -> query($sql);

                                                if($execute && $execute -> num_rows > 0){
                                                    echo '<div class="produtos" style="overflow-y: auto;">
                                                                <h4>PRODUTOS:</h4>';
                                                    while ($row = $execute -> fetch_assoc()){
                                                        echo '  <h6> Produto: ' . htmlspecialchars($row['Nome']). ' </h6>';
                                                        echo '  <h6> Quantidade: ' . htmlspecialchars($Quantidade). ' </h6>';
                                                        echo '  <h6> Preço Unitário: ' . htmlspecialchars($row['PrecoUNI']). ' </h6>';
                                                        echo '  <h6> Valor Total: ' . htmlspecialchars($ValorTotal). ' </h6>';
                                                        echo '  <h6> UN: ' . htmlspecialchars($row['UN']). ' </h6>';
                                                        echo' <form action="function/processorecebimento.php" method="POST">
                                                                <input type=hidden name="codigoItemPedido" value="' . $CoditemPedido. '" style="display: block">
                                                                <input type="checkbox" id="avariado-produto" class="avariado-produto" name="avariado">
                                                                <input type="checkbox" id="avariado-produto" class="avariado-produto" name="Faltando">
                                                                <input type="submit" name="UpdateItem" value="OK">
                                                                <input type="submit" name="Confirmar-pedido" value="OK">
                                                            </form>
                                                        
                                                        ';
                                                        
                                                    }
                                                }

                                                }else{
                                                    echo'Nenhum item encontrado para esse código de pedido';
                                            }
                                            }else{
                                                echo'Código do pedido não encontrado';
                                            }
                                        } else{
                                            echo'Código da nota fiscal não encontrado';
                                        }  
                                    } else{
                                        echo'Código da nota fiscal e pedido não digitados';
                                    }

                                    if(!isset($_POST['enviar-pedido']) && empty($_POST['cod_pedido']) && empty($_POST['nota_fiscal'])){
                                        echo '<div class="produtos">
                                            <h4>PRODUTOS:</h4>
                                            <input type="text" id="idprodutos" class="idprodutos" value="Produto:">
                                            <div class="options-produtos">
                                                <h6>QUANTIDADE:</h6>
                                                <input type="text" id="quantidade-produtos" class="quantidade-produtos" value="Quantidade:">
                                                <h6>PREÇO:</h6>
                                                <input type="text" id="preco-produto" class="preco-produto" value="Preço:" required>
                                                <h6>P TOTAL:</h6>
                                                <input type="text" id="preco-total-produto" class="preco-total-produto" value="Total:" >
                                            </div>
                                            <div class="options-produtos">
                                                <h6>AVARIADO:</h6>
                                                <input type="checkbox" id="avariado-produto" class="avariado-produto">
                                                <h6>EM FALTA:</h6>
                                                <input type="checkbox" id="falta-produto" class="falta-produto">
                                                <input type="checkbox" id="falta-produto" class="falta-produto" value="">
                                            </div>';
                                    }
                            }
                        echo'
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>'; } ?>
    <script>
        var elementdoca = document.getElementById('doca');
        elementdoca.style.display = 'block';

        var elementsubmit = document.getElementById('enviar-recebimento-carga');
        elementsubmit.style.display = 'block';
    </script>
</body>
</html>