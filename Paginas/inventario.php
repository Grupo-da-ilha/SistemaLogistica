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
    <link rel="stylesheet" href="../css/inventario.css"/>
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
                            <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
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
                    <a href="criarpedido.php" class="functions-menu">PEDIDO</a>
                    <a href="solicitacao.php" class="functions-menu">SOLICITAÇÕES</a>
                    <a href="danfe.php" class="functions-menu">DANFE</a>
                    <a href="carga.php" class="functions-menu">VISTORIA</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="operacaomovimentacao.php" class="functions-menu">OPERAÇÃO</a>
                    <a href="picking.php" class="functions-menu">PICKING</a>
                    <a href="expediçao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="vistoriasolicitacoes.php" class="functions-menu">CONFERÊNCIA SOLICITACAÇÕES</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>INVENTÁRIO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> CONTROLE </h4>
                            <div class="info-pedido">
                                <h5>ESTOQUE:</h5>
                                    <a href="estoque.php" class="button-pedidos">Estoque</a>
                                <h5>RECEBIMENTO:</h5>
                                    <a href="recebimentosolicitacoes.php" class="button-pedidos">Recebimento solicitações</a>
                                    <a href="recebimentodoca.php" class="button-pedidos">Recebimento doca pedidos</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <form action="" method="POST" class="criarpedidos">
                                    <h4>FILTROS</h4>
                            <div class="options-criarpedido">
                                <h5>NOME DO PRODUTO:</h5>
                                <input type="text" name="nome_produto" style="display: block;" class="input-options-criar-pedido">

                                <h5>UN DO PRODUTO:</h5>
                                <input type="text" name="un_produto" style="display: block;" class="input-options-criar-pedido">

                                <h5>SKU DO PRODUTO:</h5>
                                <input type="text" name="sku_produto" style="display: block;" class="input-options-criar-pedido">

                                <input type="submit" name="pesquisar" value="PESQUISAR" style="display: block;" class="input-function-criar-pedido"> 
                                </form>
                            </div>
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PRODUTOS:</h4>';?>
                                    <?php   
                                if (!empty($_POST['nome_produto']) && !empty($_POST['un_produto']) && !empty($_POST['sku_produto'])) {
                                    // Guardar valores nas variáveis
                                    $nome_produto = $conexao->real_escape_string($_POST['nome_produto']);
                                    $un_produto = $conexao->real_escape_string($_POST['un_produto']);
                                    $sku_produto = $conexao->real_escape_string($_POST['sku_produto']);

                                    //Processamento de erros
                                    $SelectProdutoSKU = "SELECT * FROM produtos WHERE SKU = '$sku_produto' AND Nome='$nome_produto'";
                                    $executeSKU = $conexao -> query($SelectProdutoSKU);

                                    if($executeSKU -> num_rows == 0){
                                        echo 'O nome do produto e o SKU não são correspondentes';
                                    } else{

                                    }


                                    // Consulta para encontrar produtos no estoque com o nome digitado
                                    $query = "SELECT produtos.Nome, produtos.SKU, produtos.UN, itensestoque.Quantidade, itensestoque.cod_estoque
                                              FROM produtos
                                              INNER JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
                                              INNER JOIN itensestoque ON itenspedido.cod_itenpedido = itensestoque.cod_itenpedido
                                              WHERE produtos.Nome = '$nome_produto' AND produtos.UN = '$un_produto' AND produtos.SKU = '$sku_produto'
                                              AND itensestoque.Situacao = 'No estoque' AND
                                              itensestoque.codTurma = '{$_SESSION['codTurma']}'";
                                
                                    $resultado = $conexao->query($query);
                                
                                    if (!$resultado) {
                                        echo "Erro na consulta";
                                    } else {
                                        echo "<div style='display: flex; width: 300px; justify-content: space-evenly'>";
                                        while($row = $resultado -> fetch_assoc()){

                                            //Select estoque
                                            $selectPosicao = "SELECT * FROM estoque WHERE cod_estoque = '".$row['cod_estoque']."'";
                                            $executePosicao = $conexao->query($selectPosicao);
                
                                            if($executePosicao && $executePosicao->num_rows > 0){
                                                while($rowEstoque = $executePosicao->fetch_assoc()){
                                                    $andar = $rowEstoque['Andar'];
                                                    $apartamento = $rowEstoque['Apartamento'];
                                                }
                                            } else {
                                                // Definindo variáveis padrão caso não haja posição
                                                $andar = "";
                                                $apartamento = "";
                                            }

                                            echo "
                                                <div style='border: 1px solid black'>
                                                    <p> Produto: ". htmlspecialchars($row['Nome']) ." </p>
                                                    <p> SKU: ". htmlspecialchars($row['SKU']) ." </p>
                                                    <p> UN: ". htmlspecialchars($row['UN']) ." </p>
                                                    <p> QTD: ". htmlspecialchars($row['Quantidade']) ." </p>
                                                    <p> Posicao: ". htmlspecialchars($andar . $apartamento) ." </p>
                                                </div>
                                            ";
                                        }
                                        echo "</div>";
                                    }
                            }
                        }
                    }

                                
                                ?>                                          

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