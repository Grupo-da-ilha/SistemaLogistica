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
    <link rel="stylesheet" href="../css/picking.css"/>
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
        echo "Failed to connect to MySQL: " . htmlspecialchars($conexao->connect_error);
        exit();
    } else {
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
                    <a href="recebimentodoca.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="controledoca.php" class="functions-menu">CONTROLE</a>
                    <a href="operacaomovimentacao.php" class="functions-menu">OPERAÇÃO</a>
                    <a href="expediçao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="vistoriasolicitacoes.php" class="functions-menu">CONFERÊNCIA SOLICITACAÇÕES</a>
                </li>
            </div>
            <div class="movimentacao-container">
                <div class="titulo-recebimento">
                    <h3>PICKING</h3>    
                </div>
                <h4> Operações de picking em aberto: </h6>
                <h7> Abra a solicitação que você deseja operar </h7>
                ';
                $sql = "SELECT * FROM solicitacoes WHERE Situacao = 'Em processo de Picking' AND codTurma ='{$_SESSION['codTurma']}'";
                $execute = $conexao -> query($sql);

                if($execute && $execute -> num_rows > 0){
                    echo '
                        <div class="div-operacoes">
                            <table class="tabela">
                                <tr>
                                    <td> Número das solicitações </td>
                                    <td> Ações </td>
                                </tr>
                    ';
                    while($row = $execute -> fetch_assoc()){
                        //Quandar cod_estoque
                        $cod_solicitacao = $row['cod_solicitacao'];
                        $id_solicitacao = $row['id_solicitacao'];
                        
                        echo '<tr>
                                <td>' . htmlspecialchars($cod_solicitacao) . '</td>
                                <td>
                                    <form action="processopicking.php" method="POST">
                                        <input type="hidden" name="id_solicitacao_picking" value="' . $id_solicitacao . '" style="display: block;"></label>
                                        <input type="submit" name="AbrirSolicitacao" class="AbrirSolicitacao" value="ABRIR" style="display: block;">
                                    </form>
                                </td>
                            </tr>';
                    }
                    //Forms para enviar os produtos selecionados para a tela de operação
                    echo '
                        </table>
                        <br>
                    </div>
                    ';
                } else{
                    echo 'Nenhuma solicitação no processo de picking';
                }
echo '
            </div>
        </div>
    </main>';          
    }
    } ?>
</body>
</html>