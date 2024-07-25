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
    <link rel="stylesheet" href="../css/pedido.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
<body>
<?php
// Iniciar uma sessão
session_start();
if (empty($_SESSION['nome'])){
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
    }else{
        if (isset($_POST['enviar_cod']) && !empty($_POST['cod_solicitacao'])) {
            $cod_solicitacao = $conexao->real_escape_string($_POST['cod_solicitacao']);
            $_SESSION['cod_solicitacao'] = $cod_solicitacao;
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
                    <a href="carga.php" class="functions-menu">VISTORIA</a>
                    <a href="recebimentodoca.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="controledoca.php" class="functions-menu">CONTROLE</a>
                    <a href="estoque.php" class="functions-menu">ESTOQUE</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>CRIAR SOLICITAÇÃO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>PEDIDO:</h5>
                                    <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                    <a href="meuspedidos.php" class="button-pedidos">Meus Pedidos</a>
                                <h5>SOLICITAÇÕES:</h5>
                                    <a href="minhassolicitacoes.php" class="button-pedidos">Minhas Solicitações</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <form action="" method="POST" class="criarpedidos">
                                    <h4>CRIAR:</h4>
                            <div class="options-criarpedido">
                                <h5>CÓDIGO DA SOLICITAÇÃO:</h5>
                                <input type="text" name="codSolicitacao" style="display: block;" class="input-options-criar-pedido">
                                    <div class="options-criarpedido-input">
                                        <input type="submit" name="enviar_solicitacao" value="CONFIRMAR SOLICITAÇÃO" style="display: block;" class="input-function-criar-pedido"> 
                                    </div> 
                                        <h5>NOME DO PRODUTO:</h5>
                                        <div style="display:flex; justify-content: space-between;">
                                            <input type="text" name="NomeProduto" id="NomeProduto" style="display: block;" class="input-options-consulta"> 
                                            <input type="text" name="NomeProdutoEstoque" id="NomeProdutoEstoque" style="display: block;" class="input-options-consulta"> 
                                        </div>
                                    <input type="submit" name="enviar_produto" value="ADICIONAR PRODUTO" style="display: block;" class="input-function-criar-pedido">
                                    <br>
                                    <a class="ahrefcadastrar" href="produtosestoque.php"><input type="button" value="VER PRODUTOS ESTOCADOS" style="display:block"></a>
                                </form>
                            </div>
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PRODUTOS:</h4>';?>
                                      

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>';
<script>
  </script>              
</body>
</html>