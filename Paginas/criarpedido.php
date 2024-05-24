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
    <link rel="stylesheet" href="../css/pedido.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
<?php
// Iniciar uma sessão
session_start();

if (isset($_POST['enviar_pedido'])) {
    $_SESSION['cod_pedido'] = "";
}

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
        if (isset($_POST['enviar_pedido']) && !empty($_POST['codPedido'])) {
            $cod_pedido = $conexao->real_escape_string($_POST['codPedido']);
            $_SESSION['cod_pedido'] = $cod_pedido; 
        }

    }
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
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>CRIAÇÃO DO PEDIDO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>PEDIDOS:</h5>
                                    <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                    <a href="meuspedidos.php" class="button-pedidos">Meus Pedidos</a>
                                <h5>NOTA FISCAL:</h5>
                                    <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                    <a href="meuspedidos.php" class="button-pedidos">Minhas DANFE</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <form action="criarpedido.php" method="POST" class="criarpedidos">
                                <h4>CRIAR:</h4>
                            <div class="options-criarpedido">
                                <h5>COD PEDIDO:</h5>
                                <input type="text" name="codPedido" style="display: block;" class="input-options-criar-pedido">
                            </div>
                            <div class="options-criarpedido">
                                <h5>FORNECEDOR:</h5>
                                    <label class="label-input" for="">
                                        <i class="far fa-envelope icon-modify"></i>
                                        <select name="Fabricante" required style="display: block;" class="input-options-criar-pedido-select">
                                            <option class="options-label">Selecione:</option>
                                            <option class="options-label">CIS</option>
                                            <option class="options-label">WEG</option>
                                            <option class="options-label">Tilibra</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="options-criarpedido">
                                    <h5>TRENSPORTADORA:</h5>
                                        <label class="label-input" for="">
                                            <i class="far fa-envelope icon-modify"></i>
                                            <select name="Transportadora" required style="display: block;" class="input-options-criar-pedido-select">
                                                <option>Selecione:</option>
                                                <option>Tac Transportes</option>
                                                <option>Graédi Transportes</option>
                                                <option>NSL Brasil</option>
                                            </select>
                                        </label>
                                </div>
                                <div class="options-criarpedido-input">
                                    <input type="submit" name="enviar_pedido" value="CONFIRMAR PEDIDO" style="display: block;" class="input-function-criar-pedido"> 
                                </div>
                                <div class="options-criarpedido">
                                    <h5>COD PRODUTO:</h5>
                                    <input type="text" name="codProduto" style="display: block;" class="input-options-criar-pedido"> 
                                </div>
                                <input type="submit" name="enviar_produto" value="ADICIONAR PRODUTO" style="display: block;" class="input-function-criar-pedido"> 
                                <a class="ahrefcadastrar" href="cadastrarprodutos.php"><input type="button" id="verprodutoscadastrados" class="verprodutoscadastrados" value="VER CADASTRAR PRODUTOS"></a>
                            </form>
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PRODUTOS:</h4>'?>
                                    <?php
                                            $hostname = "127.0.0.1";
                                            $user = "root";
                                            $password = "";
                                            $database = "logistica";

                                            $conexao = new mysqli($hostname, $user, $password, $database);

                                            if ($conexao->connect_errno) {
                                                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                                                exit();
                                            }else{

                                            if (isset($_POST['enviar_pedido']) && !empty($_POST['codPedido'])) {
                                                //Criando variáveis
                                                $cod_pedido = $conexao->real_escape_string($_POST['codPedido']);
                                                $_SESSION['cod_pedido'] = $cod_pedido; 
                                                $datahoje = date("Y-m-d H:i:s");
                                                date_default_timezone_set('America/Sao_Paulo'); 

                                                $selectPedido = "SELECT * FROM pedido WHERE cod_pedido = '$cod_pedido'";
                                                $executar = $conexao->query($selectPedido);

                                                if($executar->num_rows > 0){
                                                    echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($cod_pedido) . "</h6>";

                                                } else {
                                                    $nomeFabri = $conexao->real_escape_string($_POST['Fabricante']);
                                                    $selectCNPJFabricante = "SELECT CNPJ FROM fabricantes WHERE Nome = '$nomeFabri'";
                                                    $execute = $conexao -> query($selectCNPJFabricante);

                                                    if($execute && $execute -> num_rows >0){
                                                        $row = $execute -> fetch_assoc();
                                                        $_SESSION['CNPJFabri'] = $row['CNPJ'];
                                                        $nomeTransp = $conexao->real_escape_string($_POST['Transportadora']);

                                                        $selectCNPJTransportadora = "SELECT CNPJ FROM transportadoras WHERE Nome = '$nomeTransp'";
                                                        $execute = $conexao-> query($selectCNPJTransportadora);

                                                        if($execute && $execute -> num_rows > 0){
                                                            $row = $execute -> fetch_assoc();
                                                            $_SESSION['CNPJTransp'] = $row['CNPJ'];
                                                            $sql = "INSERT INTO pedido (cod_pedido, DataVenda, ValorTotal, CNPJEmitente, CNPJ_Destinatario, CNPJ_Transportadora, Situacao) VALUES ('$cod_pedido', '$datahoje', 0.0, '".$_SESSION['CNPJFabri']."', '03.774.819/0001-02', '".$_SESSION['CNPJTransp']."', 'Em Processamento')";
                                                            $result = $conexao->query($sql);
                                            
                                                            if ($result) {
                                                                echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($cod_pedido) . "</h6>";
                                                            } else {
                                                                echo "<h6>Erro ao criar pedido: " . htmlspecialchars($conexao->error) . "</h6>";
                                                            }
                                                        }else{
                                                            echo "<h6>Por favor selecione a Transportadora</h6>";
                                                        }

                                                    }else{
                                                        echo "<h6>Por favor selecione o Fornecedor</h6>";
                                                    }
                                                }
                                            } else{
                                            }

                                            if (isset($_POST['enviar_produto']) && !empty($_POST['codProduto'])) {
                                                $cod_produto = $conexao->real_escape_string($_POST['codProduto']);
                                                $sql = "SELECT Nome, PrecoUNI, UN, NCM, PesoGramas FROM produtos WHERE cod_produto = '$cod_produto'";
                                                $result = $conexao->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $_SESSION['Nome'] = $row['Nome'];
                                                    $_SESSION['PrecoUnitario'] = $row['PrecoUNI'];
                                                    $_SESSION['Peso'] = $row['PesoGramas'];
                                                    $_SESSION['UN'] = $row['UN'];
                                                    $_SESSION['NCM'] = $row['NCM'];

                                                    $sql2 = "INSERT INTO itenspedido (cod_produto, cod_pedido, Quantidade, ValorUnitario, ValorTotal) 
                                                            VALUES ('$cod_produto', '{$_SESSION['cod_pedido']}', 0, '{$_SESSION['PrecoUnitario']}', 0.0)";
                                                    $resultado = $conexao->query($sql2);

                                                    if (!$resultado) {
                                                        echo "<h6>Erro ao adicionar produto ao pedido: " . htmlspecialchars($conexao->error) . "</h6>";
                                                    }
                                                } else {
                                                    echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($_SESSION['cod_pedido']) . "</h6>";
                                                    echo "<h6>Produto não encontrado.</h6>";
                                                }
                                            }

                                            $sql3 = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                    FROM produtos 
                                                    LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                    WHERE itenspedido.cod_pedido = '{$_SESSION['cod_pedido']}' ORDER BY produtos.Nome ASC";
                                            $resul = $conexao->query($sql3);

                                            if ($resul && $resul->num_rows > 0) {
                                                $valorTotalPedido = 0;
                                                echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($_SESSION['cod_pedido']) . "</h6>";
                                                echo "<div class='main'>
                                                        <div class='tablebox'>
                                                            <h7>Confira os produtos já adicionados ao pedido:</h7>
                                                            <table class='tabela'>
                                                                <tr>
                                                                    <th>Nome</th>
                                                                    <th>UN</th>
                                                                    <th>QTD</th>
                                                                    <th>R$/unit</th>
                                                                    <th>NCM</th>
                                                                    <th>Valor total</th>
                                                                    <th>Delete</th>
                                                                </tr>";
                                                while ($row = $resul->fetch_assoc()) {
                                                    $valorTotalItem = $row['Quantidade'] * $row['PrecoUNI'];
                                                    $valorTotalPedido += $valorTotalItem;
                                                    $_SESSION['ValorTotalPedido'] = $valorTotalPedido;
                                                    echo "<tr>
                                                            <td>" . htmlspecialchars($row['Nome']) . "</td>
                                                            <td>" . htmlspecialchars($row['UN']) . "</td>
                                                            <td>
                                                                <form action=\"function/processoItens.php\" method=\"POST\">
                                                                    <input type=\"hidden\" name=\"codigoItemPedido\" value=\"" . $row['cod_itenPedido'] . "\" style=\"display: block;\">
                                                                    <input type=\"text\" name=\"QTD\" value=\"" . $row['Quantidade'] . "\" style=\"display: block;\" class=\"input-informacao\">
                                                                    <input type=\"submit\" name=\"AtualizarQTD\" value=\"ATUALIZAR\" style=\"display: block;\" class=\"input-informacao-atualizar\">
                                                                </form>
                                                            </td>
                                                            <td>" . htmlspecialchars($row['PrecoUNI']) . "</td>
                                                            <td>" . htmlspecialchars($row['NCM']) . "</td>
                                                            <td><h8>".$valorTotalItem."</8></td>
                                                            <td>
                                                                <form action=\"function/processoItens.php\" method=\"POST\" class=\"deletebox\">
                                                                    <input type=\"hidden\" name=\"codigoItemPedido\" value=\"" . $row['cod_itenPedido'] . "\" style=\"display: block;\">
                                                                    <input type=\"submit\" name=\"Excluir\" value=\"Delete\"  style=\"display: block;\" class=\"input-informacao-delete\">
                                                                </form>
                                                            </td>
                                                        </tr>";
                                                }

                                                echo "</table> 
                                                <h6 style=\"margin-top:10px\">Valor Total: " . htmlspecialchars($valorTotalPedido)."</h6>";
                                                echo"
                                                        <form action=\"function/processoItens.php\" method=\"POST\">
                                                            <div class=\"input-finalizar-pedido\">
                                                                <input type=\"hidden\" name=\"codigoPedido\" value=\"" .$_SESSION['cod_pedido']. "\" style=\"display: block;\">
                                                                <input type=\"submit\" name=\"UpdateValor\" onclick=\"FinalizarPedido()\" value=\"Finalizar Pedido\" style=\"display: block;\" class=\"input-finalizar-pedido-button\">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>";
                                            } else {
                                                echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($_SESSION['cod_pedido']) . "</h6>";
                                                echo "<p>Erro ao buscar produtos, nenhum produto foi adicionado ainda " . htmlspecialchars($conexao->error) . "</p>";
                                            }

                                            $conexao->close();
                                        }
                                    }
                                    
echo'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>'; ?>
</body>
</html>