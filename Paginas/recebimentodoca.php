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
    <link rel="stylesheet" href="../css/controle.css"/>
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
    }
    if (isset($_SESSION['Idprojeto'])) {
        $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
        $execute = $conexao->query($sql);
    
        if ($execute->num_rows > 0) {
            $row = $execute->fetch_assoc();
            $codTurma = $row['codTurma'];
        }
    } else {
        echo ''.$_SESSION['Idprojeto']. '';
    }
    echo '
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
                        <h2>'.htmlspecialchars($_SESSION['nome']).'</h2>
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
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>RECEBIMENTO DAS DOCAS</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>DOCAS:</h5>
                                    <a href="recebimentodoca.php" class="button-pedidos">Recebimento das docas</a>
                                    <a href="controledoca.php" class="button-pedidos">Controle das docas</a>
                                <h5>ESTOQUE:</h5>
                                    <a href="estoque.php" class="button-pedidos">Meu Estoque</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PEDIDOS:</h4>';


    $sql = "SELECT * FROM pedido WHERE codTurma ='$codTurma' AND Situacao = 'Nas docas'";
    $executar = $conexao->query($sql);

    if($executar && $executar->num_rows > 0){
        echo "<div class='main'>
                <div class='tablebox'>
                    <h7>Confira os produtos que estão parados nas docas</h7>
                    <table class='tabela'>
                        <tr>
                            <th>Código do pedido</th>
                            <th>Doca</th>
                            <th>Algum item avariado?</th>
                            <th>Algum item faltando?</th>
                            <th>Ações</th>
                        </tr>";

        while($row = $executar->fetch_assoc()){
            $idpedidos = $conexao->real_escape_string($row['id_pedido']);
            $cod_pedido = $conexao->real_escape_string($row['cod_pedido']);
            
            $sql = "SELECT * FROM itenspedido WHERE codTurma ='$codTurma' AND cod_pedido = '$idpedidos'";
            $executeItem = $conexao->query($sql);

            if($executeItem && $executeItem->num_rows > 0){
                while($row = $executeItem->fetch_assoc()){
                    $faltando = $conexao->real_escape_string($row['Faltando']);
                    $avariado = $conexao->real_escape_string($row['Avariado']);

                    if($avariado == 1 && $faltando == 0){
                        $Avariado = 'SIM';
                        $Faltando = 'Não';
                    } elseif($faltando == 1 && $avariado == 0){
                        $Faltando = 'SIM';
                        $Avariado = 'Não';
                    } elseif($avariado == 1 && $faltando == 1){
                        $Avariado = 'SIM';
                        $Faltando = 'SIM';
                    } else{
                        $Avariado = 'Não';
                        $Faltando = 'Não';
                    }
                

            $sqlDoca = "SELECT * FROM docas WHERE codTurma ='$codTurma' AND id_pedido = '$idpedidos'";
            $executeDoca = $conexao->query($sqlDoca);
                }
            if($executeDoca && $executeDoca->num_rows > 0){
                while($rowDoca = $executeDoca->fetch_assoc()){
                    echo '<tr>
                            <td>' . $cod_pedido . '</td>
                            <td>' . htmlspecialchars($rowDoca['posicao']) . '</td>
                            <td>' . $Avariado . '</td>
                            <td>' . $Faltando . '</td>
                            <td>    
                                <form action="controledoca.php" method="POST">
                                    <input type="hidden" name="id_pedido" value="' . htmlspecialchars($idpedidos) . '">
                                    <input type="hidden" name="posicao_doca" value="' . htmlspecialchars($rowDoca['posicao']) . '">
                                    <input type="submit" name="DesignarProdutos" value="Abrir" style="display: block;" id="abrir">
                                </form>
                            </td>
                        </tr>';
                }
            } else {
                echo 'Nenhuma doca encontrada para o pedido ' . $cod_pedido . '';
            }
        
    }
}

        echo '</table>
            </div>
        </div>';
    } else {
        echo 'Nenhum pedido encontrado nas docas';
    }

    $conexao->close();
    echo '
                </div>
            </div>
        </div>
    </main>';

} ?>
</body>
</html>
