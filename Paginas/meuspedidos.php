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
    <link rel="stylesheet" href="../css/meuspedidos.css"/>
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
    }
    
    if (isset($_SESSION['Idprojeto'])) {
        $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
        $execute = $conexao->query($sql);
    
        if ($execute->num_rows > 0) {
            $row = $execute->fetch_assoc();
            $cod_turma = $row['codTurma'];
        }
    } else {
        echo ''.$_SESSION['Idprojeto']. '';
    }

    if (isset($_POST['VerProdutos']) && !empty($_POST['cod_pedido'])) {
        $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
        $selectPedido = "SELECT id_pedido FROM pedido WHERE cod_pedido = '$cod_pedido' AND codTurma = '$cod_turma'";
        $executar = $conexao->query($selectPedido);

        if ($executar->num_rows > 0) {
            $row = $executar->fetch_assoc();
            $_SESSION['id_pedido'] = $row['id_pedido'];
        }
    }
?>
    <header>
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
                            <h2><?php echo $_SESSION['nome']; ?></h2>
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
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>MEUS PEDIDOS</h3>
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
                                <a href="danfe.php" class="button-pedidos">Minhas DANFE</a>
                            </div>
                        </div>
                        <div>
<?php
    if (isset($cod_turma)) {
        $selectPedidos = "SELECT * FROM pedido WHERE codTurma = '$cod_turma'";
        $executar = $conexao->query($selectPedidos);

        if ($executar->num_rows > 0) {
            $sql = "SELECT pedido.id_pedido, pedido.cod_pedido, pedido.DataVenda, pedido.ValorTotal, pedido.CNPJEmitente, 
            pedido.CNPJ_Destinatario, pedido.CNPJ_Transportadora, pedido.Situacao, pedido.InformacaoAdicional
            FROM pedido WHERE codTurma = '$cod_turma'";

            $execute = $conexao->query($sql);
            if ($execute && $execute->num_rows > 0) {
                echo "
                <div class=\"tablebox\">
                <h7>Confira os pedidos já criados:</h7>
                <table class=\"tabela\">
                    <tr>
                        <th>CODIGO DO PEDIDO</th>
                        <th>DataVenda</th>
                        <th>Valor Total</th>
                        <th>CNPJ Emintente</th>
                        <th>CNPJ Destinatario</th>
                        <th>CNPJ Transportadora</th>
                        <th>Situação</th>
                        <th>Informações Adicionais</th>
                        <th>Ações</th>
                    </tr>";
                while ($row = $execute->fetch_assoc()) {
                    $_SESSION['cod_pedido'] = $row['cod_pedido'];
                    echo "
                    <tr>
                        <td>".$row['cod_pedido']."</td>
                        <td>".$row['DataVenda']."</td>
                        <td>".$row['ValorTotal']."</td>
                        <td>".$row['CNPJEmitente']."</td>
                        <td>".$row['CNPJ_Destinatario']."</td>
                        <td>".$row['CNPJ_Transportadora']."</td>
                        <td>".$row['Situacao']."</td>
                        <td>".$row['InformacaoAdicional']."</td>
                        <td>
                            <form action=\"meuspedidos.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"id_pedido\" value=\"" . $row['id_pedido'] . "\" >
                                <input type=\"submit\" name=\"VerProdutos\" value=\"Ver Produtos\" style=\"display:block;\" class=\"vermais\">
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo 'Nenhum pedido criado';
            }
            echo "</table></div>";
        }

        if (        isset($_POST['VerProdutos']) && !empty($_POST['id_pedido'])) {
            $id_pedido = $conexao->real_escape_string($_POST['id_pedido']);
            $selectPedido = "SELECT * FROM pedido WHERE id_pedido = '".$id_pedido."' AND codTurma ='$cod_turma'";
            $executar = $conexao->query($selectPedido);

            if ($executar->num_rows > 0) {
                $row = $executar->fetch_assoc();
                $_SESSION['cod_pedido'] = $row['cod_pedido'];
                $sql2 = "SELECT produtos.cod_produto, produtos.PrecoUNI, produtos.Nome, produtos.PesoGramas, produtos.NCM, produtos.UN, itenspedido.Quantidade, itenspedido.ValorTotal 
                FROM produtos
                LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
                WHERE itenspedido.cod_pedido = '".$id_pedido."' ORDER BY produtos.Nome ASC";

                $execute = $conexao->query($sql2);
                if ($execute && $execute->num_rows > 0) {
                    echo "
                    <div class='main'>
                        <div class='tablebox'>
                            <h7>Confira os produtos já adicionados ao pedido ". $_SESSION['cod_pedido'].":</h7>
                            <table class='tabela'>
                                <tr>
                                    <th>Nome</th>
                                    <th>UN</th>
                                    <th>QTD</th>
                                    <th>R$/unit</th>
                                    <th>NCM</th>
                                    <th>Valor total</th>
                                </tr>";
                    while ($row = $execute->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>" . htmlspecialchars($row['Nome']) . "</td>
                            <td>" . htmlspecialchars($row['UN']) . "</td>
                            <td>" . htmlspecialchars($row['Quantidade']) . "</td>
                            <td>" . htmlspecialchars($row['PrecoUNI']) . "</td>
                            <td>" . htmlspecialchars($row['NCM']) . "</td>
                            <td>" . htmlspecialchars($row['ValorTotal']) . "</td>
                        </tr>";
                    }
                    echo "</table></div></div>"; // Fechar divs
                }   
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
    </main>
</body>
</html>

