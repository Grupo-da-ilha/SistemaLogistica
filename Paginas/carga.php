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
                                <h5>NOTA FISCAL:</h5>
                                <input type="text" id="idnotafiscal" class="idnotafiscal" value="N° Nota fiscal:" required>
                                <h5>PEDIDO DE COMPRA:</h5>
                                <input type="text" id="pedidodecompra" class="pedidodecompra" value="Pedido de compra:" required>
                                <h5>DOCA:</h5>
                                <input type="text" id="doca" class="doca" placeholder="Doca:" required>
                                <input type="submit" id="enviar-recebimento-carga" value="ENVIAR">
                            </div>
                        </div>
                        <div class="produtos">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>'; } ?>
</body>
</html>