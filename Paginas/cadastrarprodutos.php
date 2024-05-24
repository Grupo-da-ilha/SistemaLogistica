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
    <link rel="stylesheet" href="../css/cadastroproduto.css"/>
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
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="criar-pedidoproduto-container">
                <div class="titulo-pedido">
                    <h3>CADASTRO PRODUTO</h3>    
                </div>
                <div class="container-cadastro-produto">
                    <div class="registerbox">
                        <form action="function/criarproduto.php" method="POST" class="formcadastro-produto">
                            <div class="detalhes-produtos">
                                <h5>NOME:</h5>
                                <input type="text" name="nome" placeholder="Nome:" class="button-cadastro-produtos">
                            </div>
                            <div class="detalhes-produtos">
                                <h5>UN DO PRODUTO:</h5>
                                <input type="text" name="UN" placeholder="UN:" class="button-cadastro-produtos">
                            </div>
                            <div class="detalhes-produtos">
                                <h5>PREÇO POR UNIDADE:</h5>
                                <input type="text" name="preco" placeholder="Preço por Unidade:" class="button-cadastro-produtos">
                            </div>
                            <div class="detalhes-produtos">
                                <h5>PESO EM GRAMAS:</h5>
                                <input type="text" name="peso" placeholder="Peso em Gramas:" class="button-cadastro-produtos">
                            </div>
                            <div class="detalhes-produtos">
                                <h5>NCM:</h5>
                                <input type="text" name="NCM"  placeholder="NCM:" class="button-cadastro-produtos">
                            </div>
                            <input type="submit" name="Enviar" class="button-cadastro-enviar" value="CADASTRAR">
                        </form>
                    </div>';
                    
                    // PHP dentro da div "container-cadastro-produto"
                    $hostname = "127.0.0.1";
                    $user = "root";
                    $password = "";
                    $database = "logistica";
                
                    $conexao = new mysqli($hostname,$user,$password,$database);
                
                    if ($conexao -> connect_errno) {
                        echo "Failed to connect to MySQL: " . $conexao -> connect_error;
                        exit();
                    } else{
                        $sql="SELECT `cod_produto`, `PrecoUNI`, `Nome`, `PesoGramas`, `NCM`, `UN` FROM `produtos`";
                    }
                    $result= $conexao->query($sql);
                
                    if($result->num_rows > 0){
                        echo "
                            <div class= \"main\">
                                <div class=\"tablebox\">
                                    <h4>Confira os produtos já cadastrados:</h4>
                                    <table class=\"tabela\">
                                        <tr>
                                            <th>Código do Produto</th>
                                            <th>Nome</th>
                                            <th>Preço UNI</th>
                                            <th>Peso Gramas</th>
                                            <th>UN</th>
                                            <th>NCM</th>
                                        </tr>";
                                        while($row = $result-> fetch_array()){
                                            echo "
                                                <tr>
                                                    <td>".$row['cod_produto']."</td>
                                                    <td>".$row['Nome']."</td>
                                                    <td>".$row['PrecoUNI']."</td>
                                                    <td>".$row['PesoGramas']."</td>
                                                    <td>".$row['UN']."</td>
                                                    <td>".$row['NCM']."</td>
                                                    <td>
                                                        <form action=\"function/deleteproduto.php\" method=\"POST\" class=\"deletebox\">
                                                            <!-- Criando um input do tipo hidden para armazenar o CNPJ da transportadora que queremos excluir-->
                                                            <input type=\"hidden\" name=\"cod_produto\" value=\"" . $row['cod_produto'] . "\">
                                                            <input type=\"submit\" name=\"Excluir\" value=\"Delete\" class=\"deleteInput\">
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }
                                        echo "</table>
                                    </div>
                            </div>";
                    } else{
                        echo "ERRO";
                    }
                    $conexao -> close();
                    echo '</div>
                </div>
            </div>
        </div>
    </main>'; } ?>
</body>
</html>
