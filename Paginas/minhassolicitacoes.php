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
                    <h3>MEUS PEDIDOS</h3>
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>SOLICITAÇÕES:</h5>
                                <a href="solicitacao.php" class="button-pedidos">Criar Solicitação</a>
                                <h5>PEDIDOS:</h5>
                                <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                <h5>NOTA FISCAL:</h5>
                                <a href="danfe.php" class="button-pedidos">Minhas DANFE</a>
                            </div>
                        </div>
                        <div class="orientar-tabela">
<?php
    if (isset($cod_turma)) {
        $selectSolicitacaoes = "SELECT * FROM solicitacoes WHERE codTurma = '$cod_turma'";
        $executar = $conexao->query($selectSolicitacaoes);

        if ($executar->num_rows > 0) {
            $sql = "SELECT solicitacoes.id_solicitacao, solicitacoes.cod_solicitacao, solicitacoes.Data_criacao, solicitacoes.Situacao, solicitacoes.Observacao
            FROM solicitacoes WHERE codTurma = '$cod_turma'";

            $execute = $conexao->query($sql);
            if ($execute && $execute->num_rows > 0) {
                echo "
                <div class=\"tablebox\">
                <h7>Confira as solicitações já criadas:</h7>
                <table class=\"tabela\">
                    <tr>
                        <th>CODIGO DA SOLICITAÇÃO</th>
                        <th>Data da criação</th>
                        <th>Situação</th>
                        <th>Observações</th>
                        <th>Ações</th>
                    </tr>";
                while ($row = $execute->fetch_assoc()) {
                    $_SESSION['cod_solicitacao'] = $row['cod_solicitacao'];
                    echo "
                    <tr>
                        <td>".$row['cod_solicitacao']."</td>
                        <td>".$row['Data_criacao']."</td>
                        <td>".$row['Situacao']."</td>
                        <td>".$row['Observacao']."</td>
                        <td>
                            <form action=\"minhassolicitacoes.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"id_solicitacao\" value=\"" . $row['id_solicitacao'] . "\" >
                                <input type=\"submit\" name=\"VerProdutos\" value=\"Ver Produtos\" style=\"display:block;\" class=\"vermais\">
                            </form>
                            <form action=\"minhassolicitacoes.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"id_solicitacaoDelete\" value=\"" . $row['id_solicitacao'] . "\" >
                                <input type=\"submit\" name=\"DeleteSolici\" value=\"Deletar Solicitação\" style=\"display:block; background-color:red; color: white;\" class=\"vermais\">
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo 'Nenhum pedido criado';
            }
            echo "</table></div>";
        }

        if (isset($_POST['VerProdutos']) && !empty($_POST['id_solicitacao'])) {
            $id_solicitacao = $conexao->real_escape_string($_POST['id_solicitacao']);
            $selectSolicitacao = "SELECT * FROM solicitacoes WHERE id_solicitacao = '".$id_solicitacao."' AND codTurma ='$cod_turma'";
            $executar = $conexao->query($selectSolicitacao);

            if ($executar->num_rows > 0) {
                $row = $executar->fetch_assoc();
                $_SESSION['cod_solicitacao'] = $row['cod_solicitacao'];
                $sql2 = "SELECT produtos.cod_produto, produtos.PrecoUNI, produtos.Nome, produtos.PesoGramas, produtos.NCM, produtos.UN, itenssolicitacao.Quantidade
                FROM produtos
                LEFT JOIN itenssolicitacao ON produtos.cod_produto = itenssolicitacao.cod_produto
                WHERE itenssolicitacao.cod_solicitacao = '".$id_solicitacao."' ORDER BY produtos.Nome ASC";

                $execute = $conexao->query($sql2);
                if ($execute && $execute->num_rows > 0) {
                    echo "
                    <div class='main'>
                        <div class='tablebox'>
                            <h7>Confira os produtos já adicionados à solicitação ". $_SESSION['cod_solicitacao'].":</h7>
                            <table class='tabela'>
                                <tr>
                                    <th>Nome</th>
                                    <th>UN</th>
                                    <th>QTD</th>
                                    <th>NCM</th>
                                </tr>";
                    while ($row = $execute->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>" . htmlspecialchars($row['Nome']) . "</td>
                            <td>" . htmlspecialchars($row['UN']) . "</td>
                            <td>" . htmlspecialchars($row['Quantidade']) . "</td>
                            <td>" . htmlspecialchars($row['NCM']) . "</td>
                        </tr>";
                    }
                    echo "</table></div></div>"; // Fechar divs
                }   
            }
        }
        if (isset($_POST['DeleteSolici']) && !empty($_POST['id_solicitacaoDelete'])) {
            $id_solicitacaoDelete = $conexao->real_escape_string($_POST['id_solicitacaoDelete']);
        
            // Primeiro, exclua os registros dependentes na tabela `itenssolicitacao`
            $DeleteItensSolicitacao = "DELETE FROM itenssolicitacao WHERE cod_solicitacao = '".$id_solicitacaoDelete."'";
            $conexao->query($DeleteItensSolicitacao);
        
            // Agora, exclua o registro principal na tabela `solicitacoes`
            $DeleteSolicitacao = "DELETE FROM solicitacoes WHERE id_solicitacao = '".$id_solicitacaoDelete."' AND codTurma ='$cod_turma'";
            $executar = $conexao->query($DeleteSolicitacao);
        
            if ($conexao->affected_rows > 0) {
                echo "Solicitação excluída com sucesso.";
            } else {
                echo "Nenhuma solicitação encontrada para excluir ou erro na exclusão.";
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

