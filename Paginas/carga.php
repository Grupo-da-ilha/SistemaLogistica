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
    <link rel="stylesheet" href="../css/carga.css"/>
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
    echo '<header>
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
                        <h2>'.htmlspecialchars($_SESSION['nome']).'</h2>
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
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">ESTOQUE</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                    <a href="#" class="functions-menu">CONTROLE</a>
                </li>
            </div>
            <div class="recebimentocontainer">
                <div class="titulo-recebimento">
                    <h3>VISTORIA E CONFERÊNCIA CARGA</h3>    
                </div>
                <div class="info-total">
                    <div class="vistoria-carga">
                        <div class="notafiscal">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-recebimento">
                                <form action="carga.php" method="POST">
                                    <h5>NOTA FISCAL:</h5>
                                    <input type="text" id="idnotafiscal" class="idnotafiscal" name="nota_fiscal" placeholder="N° Nota fiscal:" value="'.htmlspecialchars($_SESSION['nota_fiscal'] ?? '').'">
                                    <h5>PEDIDO DE COMPRA:</h5>
                                    <input type="text" id="pedidodecompra" class="pedidodecompra" name="cod_pedido" placeholder="Pedido de compra:" value="'.htmlspecialchars($_SESSION['cod_pedido'] ?? '').'">
                                    <input type="submit" id="enviar-recebimento-pedido" name="enviar-pedido" value="ENVIAR" style="display:block; margin-top: 5px;">
                                    <h5 style="display: none">DOCA:</h5>
                                    <input type="text" id="doca" class="doca" placeholder="Doca:" style="display: none" name="doca">
                                    <input type="submit" id="enviar-recebimento-carga" value="OK" style="display: none" name="enviar_doca">
                                </form>
                            </div>
                        </div>';

                            $hostname = "127.0.0.1";
                            $user = "root";
                            $password = "";
                            $database = "logistica";

                            $conexao = new mysqli($hostname, $user, $password, $database);

                            if ($conexao->connect_errno) {
                                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                                exit();
                            }else{

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if(isset($_POST['enviar-pedido']) && !empty($_POST['nota_fiscal']) && !empty($_POST['cod_pedido'])){
                                    $_SESSION['nota_fiscal'] = $_POST['nota_fiscal'];
                                    $_SESSION['cod_pedido'] = $_POST['cod_pedido'];

                                    $nota_fiscal = $conexao->real_escape_string($_SESSION['nota_fiscal']);
                                    $cod_pedido = $conexao->real_escape_string($_SESSION['cod_pedido']);

                                    $sql = "SELECT * FROM nota_fiscal WHERE cod_nota = '$nota_fiscal'";
                                    $execute = $conexao->query($sql);

                                    if($execute->num_rows > 0){
                                        $sql = "SELECT * FROM pedido WHERE cod_pedido = '$cod_pedido'";
                                        $execute = $conexao->query($sql);

                                        if($execute->num_rows > 0){
                                            $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '$cod_pedido'";
                                            $execute = $conexao->query($sql);

                                            if($execute->num_rows > 0){ 
                                                $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                FROM produtos 
                                                LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                WHERE itenspedido.cod_pedido = '{$_SESSION['cod_pedido']}' ORDER BY produtos.Nome ASC";
                                                $resultado = $conexao->query($sql);  
                                                
                                                echo '<div class="produtos" style="overflow-y: auto;">
                                                        <h4>PRODUTOS:</h4>';
                                                while ($row = $resultado->fetch_assoc()){
                                                    echo '<h6>Produto: ' . htmlspecialchars($row['Nome']). '</h6>';
                                                    echo '<h6>Quantidade: ' . htmlspecialchars($row['Quantidade']). '</h6>';
                                                    echo '<h6>Preço Unitário: ' . htmlspecialchars($row['PrecoUNI']). '</h6>';
                                                    echo '<h6>Valor Total: ' . htmlspecialchars($row['ValorTotal']). '</h6>';
                                                    echo '<h6>UN: ' . htmlspecialchars($row['UN']). '</h6>';
                                                    echo '<form action="function/processorecebimento.php" method="POST">
                                                            <input type="hidden" name="codigoItemPedido" value="' . htmlspecialchars($row['cod_itenPedido']). '">
                                                            Avariado?
                                                            <input type="checkbox" id="avariado-produto" class="avariado-produto" name="avariado">
                                                            Faltando?
                                                            <input type="checkbox" id="avariado-produto" class="avariado-produto" name="Faltando">
                                                            <input type="submit" name="UpdateItem" value="OK">
                                                            <input type="submit" name="Confirmar-pedido" value="OK">
                                                          </form>';
                                                }
                                                echo '</div>';
                                            } else {
                                                echo 'Nenhum item encontrado para esse código de pedido';
                                            }
                                        } else {
                                            echo 'Código do pedido não encontrado';
                                        }
                                    } else {
                                        echo 'Código da nota fiscal não encontrado';
                                    }  
                                } else {
                                    echo 'Código da nota fiscal e pedido não digitados';
                                }

                                if(isset($_POST['enviar_doca']) && !empty($_POST['doca'])){
                                    $_SESSION['doca'] = $_POST['doca'];
                                    $doca = $conexao->real_escape_string($_POST['doca']);
                                    $cod_pedido = $conexao->real_escape_string($_SESSION['cod_pedido']);

                                    $sql = "INSERT INTO docas (posicao, cod_pedido) VALUES ('$doca', '$cod_pedido')";
                                    $executar = $conexao -> query($sql);

                                    if($executar){
                                                $sql = "SELECT * FROM nota_fiscal WHERE cod_nota = '".$_SESSION['nota_fiscal']."'";
                                                $execute = $conexao->query($sql);
            
                                                if($execute->num_rows > 0){
                                                    $sql = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."'";
                                                    $execute = $conexao->query($sql);
            
                                                    if($execute->num_rows > 0){
                                                        $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."'";
                                                        $execute = $conexao->query($sql);
            
                                                        if($execute->num_rows > 0){ 
                                                            $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                            FROM produtos 
                                                            LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                            WHERE itenspedido.cod_pedido = '{$_SESSION['cod_pedido']}' ORDER BY produtos.Nome ASC";
                                                            $resultado = $conexao->query($sql);  
                                                            
                                                            echo '<div class="produtos" style="overflow-y: auto;">
                                                                    <h4>PRODUTOS:</h4>';
                                                            while ($row = $resultado->fetch_assoc()){
                                                                echo '<h6>Produto: ' . htmlspecialchars($row['Nome']). '</h6>';
                                                                echo '<h6>Quantidade: ' . htmlspecialchars($row['Quantidade']). '</h6>';
                                                                echo '<h6>Preço Unitário: ' . htmlspecialchars($row['PrecoUNI']). '</h6>';
                                                                echo '<h6>Valor Total: ' . htmlspecialchars($row['ValorTotal']). '</h6>';
                                                                echo '<h6>UN: ' . htmlspecialchars($row['UN']). '</h6>';
                                                                echo '<form action="function/processorecebimento.php" method="POST">
                                                                        <input type="hidden" name="codigoItemPedido" value="' . htmlspecialchars($row['cod_itenPedido']). '">
                                                                        Avariado?
                                                                        <input type="checkbox" id="avariado-produto" class="avariado-produto" name="avariado">
                                                                        Faltando?
                                                                        <input type="checkbox" id="avariado-produto" class="avariado-produto" name="Faltando">
                                                                        <input type="submit" name="UpdateItem" value="OK">
                                                                        <input type="submit" name="Confirmar-pedido" value="OK">
                                                                      </form>';
                                                            }
                                                            echo '</div>';
                                                        } else {
                                                        }
                                                    } else {
                                                    }
                                                } else {
                                                }  
                                            } else {
                                            }
                                    }
                                } else {
                                    echo 'Erro ao inserir pedido nas docas';
                                }
                            }
                        }

echo '            </div>
                </div>
            </div>
        </div>
    </main>';
?>
    <script>
        var elementdoca = document.getElementById('doca');
        elementdoca.style.display = 'block';

        var elementsubmit = document.getElementById('enviar-recebimento-carga');
        elementsubmit.style.display = 'block';
    </script>
</body>
</html>
