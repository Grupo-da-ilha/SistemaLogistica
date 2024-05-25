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
    <link rel="stylesheet" href="../css/danfe.css"/>
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
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname, $user, $password, $database);

    if ($conexao->connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao->connect_error;
        exit();
    }else{

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
                                    <a href="danfe.php" class="button-pedidos">Minhas DANFE</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <h4> VEJA AQUI AS SUAS DANFES JÁ CRIADAS</h5>
                            <br>

                        ';
                        $hostname = "127.0.0.1";
                        $user = "root";
                        $password = "";
                        $database = "logistica";

                        $conexao = new mysqli($hostname, $user, $password, $database);

                        if ($conexao->connect_errno) {
                            echo "Failed to connect to MySQL: " . $conexao->connect_error;
                            exit();
                        } else {
                            $sql = "SELECT nota_fiscal.cod_nota, nota_fiscal.chave_acesso, nota_fiscal.DataExpedicao, nota_fiscal.CNPJ_Emitente, 
                            nota_fiscal.InformacoesAdicionais, nota_fiscal.CNPJ_Transportadora, nota_fiscal.CNPJ_Destinatario, nota_fiscal.cod_pedido
                            FROM `nota_fiscal` ORDER BY nota_fiscal.cod_pedido ASC";

                            $execute = $conexao -> query($sql);

                            if($execute -> num_rows > 0){
                                echo '
                                    <div class="nota_fiscal">';
                                        while ($row = $execute -> fetch_assoc()){
                                            echo '
                                                <h5> DANFE correspondente ao pedido com codigo: ' . htmlspecialchars($row['cod_pedido']) . '</h6>';
                                            echo '
                                                <h9> Codigo da DANFE: ' . htmlspecialchars($row['cod_nota']) . '</h9>';
                                            echo '<br>';
                                            echo '
                                                <h9> Chave de acesso da DANFE: ' . htmlspecialchars($row['chave_acesso']) . '</h9>';
                                            echo '<br>';
                                            echo '
                                                <h9> Data de Emissão: ' . htmlspecialchars($row['DataExpedicao']) . '</h9>';
                                            echo '<br>';
                                            echo '
                                                <h9> CNPJ do Emitente: ' . htmlspecialchars($row['CNPJ_Emitente']) . '</h9>'; 
                                            echo '<br>';
                                            echo '
                                                <h9> CNPJ da Transportadora: ' . htmlspecialchars($row['CNPJ_Transportadora']) . '</h9>';  
                                            echo '<br>';
                                            echo '
                                                <h9> CNPJ do Destinatario: ' . htmlspecialchars($row['CNPJ_Destinatario']) . '</h9>';    
                                            echo '<br>';
                                            echo '
                                                <h9> Informações Adicionais: ' . htmlspecialchars($row['InformacoesAdicionais']) . '</h9>';          
                                        }
                            }

                        }
echo' 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>'; 
}
    ?>
</body>
</html>