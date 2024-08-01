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
    <link rel="stylesheet" href="../css/movimentacao.css"/>
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
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="estoque.php" class="functions-menu">ESTOQUE</a>
                    <a href="picking.php" class="functions-menu">PICKING</a>
                    <a href="expediçao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="relatorios.php" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="movimentacao-container">
                <div class="titulo-recebimento">
                    <h3>PROCESSO DE PICKING</h3>    
                </div>
                <h7> Selecione os produtos desejados para ir à operação </h7>
                ';
                //Verificar se a pessoa clicou para abrir a solicitação
                if(isset($_POST['id_solicitacao_picking'])){
                $id_solicitacao = $conexao -> real_escape_string($_POST['id_solicitacao_picking']);
                    
                $sql = "SELECT * FROM itenspicking WHERE Situacao = 'No processo de picking'";
                $execute = $conexao -> query($sql);

                if($execute && $execute -> num_rows > 0){
                    echo '
                        <div class="div-operacoes">
                            <table class="tabela">
                                <tr>
                                    <td> Produtos </td>
                                    <td> UN </td>
                                    <td> QTD </td>
                                    <td> Posição </td>
                                    <td> Ações </td>
                                </tr>
                    ';
                    while($row = $execute -> fetch_assoc()){
                        //Quandar cod_estoque
                        $cod_estoque = $row['cod_estoque'];
                        $cod_itemPicking = $row['cod_itemPicking'];
                        $cod_itemSolicitacao = $row['cod_itemSolicitacao'];
                        $QuantidadeItemPicking = $row['Quantidade'];

                        //Pesquisar itens
                        $selectItens = "SELECT * FROM itenssolicitacao WHERE cod_itemSolicitacao = '$cod_itemSolicitacao'";
                        $executar = $conexao -> query($selectItens);

                        if($executar && $executar -> num_rows > 0){
                            while($rowItens = $executar -> fetch_assoc()){
                                $cod_produto = $rowItens['cod_produto'];

                                //Pesquisar produtos
                                $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                $resultado = $conexao -> query($selectProdutos);
                                
                                if($resultado && $resultado -> num_rows > 0){
                                    while($rowPorduto = $resultado -> fetch_assoc()){
                                        $Nome = $rowPorduto['Nome'];
                                        $UN = $rowPorduto['UN'];
                                    }
                                }
                                }
                        }

                        //Pesquisar a posição do item
                        $selectPosicao = "SELECT * FROM estoque WHERE cod_estoque = '$cod_estoque '";
                        $executePosicao = $conexao -> query($selectPosicao);

                        if($executePosicao && $executePosicao -> num_rows > 0){
                            while($rowEstoque = $executePosicao -> fetch_assoc()){
                                $andar = $rowEstoque['Andar'];
                                $apartamento = $rowEstoque['Apartamento'];
                            }
                        }
                        
                        echo '<tr>
                                <td>' . htmlspecialchars($Nome) . '</td>
                                <td>' . htmlspecialchars($UN) . '</td>
                                <td>' . htmlspecialchars($QuantidadeItemPicking) . '</td>
                                <td>' . htmlspecialchars($andar . $apartamento) . '</td>
                                <td style="display: flex;">
                                </td>
                            </tr>';
                    }
                    //Forms para enviar os produtos selecionados para a tela de operação
                    echo '
                        </table>
                        <br>
                        <div class="iroperacao">
                            <input type="submit" id="EnviarOperacao" name="EnviarOperacao" value="Ir para operação" style="display:block;" class="irparaoperacao">
                        </div>  
                    </form>
                    </div>
                    ';
                } else{
                    echo 'Nenhuma operação em aberto';
                }
echo '
            </div>
        </div>
    </main>';          
    }
    } 
    
}?>
</body>
</html>