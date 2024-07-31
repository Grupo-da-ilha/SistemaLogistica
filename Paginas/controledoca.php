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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
session_start();

if (empty($_SESSION['nome'])) {
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
                                <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
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
                    <a href="danfe.php" class="functions-menu">DANFE</a>
                    <a href="carga.php" class="functions-menu">VISTORIA</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>DESIGNAR ITENS DO PEDIDO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>DOCAS:</h5>
                                    <a href="recebimentodoca.php" class="button-pedidos">Recebimento das docas</a>
                                <h5>ESTOQUE:</h5>
                                    <a href="estoque.php" class="button-pedidos">Meu Estoque</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PARA ONDE OS ITENS VÃO?</h4>';

            if (isset($_POST['id_pedido']) && isset($_POST['posicao_doca'])) {
                $idpedido = $conexao->real_escape_string($_POST['id_pedido']);
                $doca = $conexao->real_escape_string($_POST['posicao_doca']);
                $QuantidadeItemEstoque = 0; 

                $sql = "SELECT cod_pedido FROM pedido WHERE id_pedido = '$idpedido' AND Situacao = 'Nas docas' AND codTurma = '{$_SESSION['codTurma']}'";
                $execute = $conexao->query($sql);

                if ($execute && $execute->num_rows > 0) {
                    $row = $execute->fetch_assoc();
                    $cod_pedido = $row['cod_pedido'];

                    echo '<div class="DivInicial" style="display:flex; margin-bottom: 50px">
                            <h6> Código do pedido: ' . htmlspecialchars($cod_pedido) . '</h6>
                            <h6> Doca: ' . htmlspecialchars($doca) . '</h6>
                        </div>';

                    $sqlItenspedidos= "SELECT * FROM itenspedido WHERE cod_pedido = '$idpedido' AND codTurma = '{$_SESSION['codTurma']}' AND Quantidade_doca != 0";
                    $execute = $conexao->query($sqlItenspedidos);

                    if ($execute && $execute->num_rows > 0) {
                        echo '<div class="MainContainer">
                                <table class="tabela"> 
                                    <tr>
                                        <td>Produtos</td>
                                        <td>UN</td>
                                        <td>Quantidade à espera</td>
                                        <td>QTD para Estoque</td>
                                        <td>Posição no Estoque</td>
                                        <td>Ações</td>
                                    </tr>';
                        while ($row = $execute->fetch_assoc()) {
                            $cod_produto = $row['cod_produto'];
                            $Quantidade = $row['Quantidade'];
                            $QuantidadeDoca = $row['Quantidade_doca'];
                            $codItemPedido = $row['cod_itenPedido'];

                            $sqlProdutos= "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                            $executar = $conexao->query($sqlProdutos);

                            $SelectItensEstoque = "SELECT * FROM itensestoque WHERE cod_itenpedido = '$codItemPedido' AND Situacao = 'Em movimentação' AND codTurma = '{$_SESSION['codTurma']}'";
                            $resultado = $conexao -> query($SelectItensEstoque);

                            if($resultado && $resultado -> num_rows > 0){
                                $rowItenEstoque = $resultado -> fetch_assoc();
                                $QuantidadeEstoque = $rowItenEstoque['Quantidade'];
                            } else{
                                $QuantidadeEstoque = 0;
                            }

                            if ($executar && $executar->num_rows > 0) {
                                while ($rowProdutos = $executar->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . htmlspecialchars($rowProdutos['Nome']) . '</td>
                                            <td>' . htmlspecialchars($rowProdutos['UN']) . '</td>
                                            <td class="Quantidade_espera" cod_itempedido="' . htmlspecialchars($codItemPedido) . '">' . htmlspecialchars($QuantidadeDoca) . '</td>
                                            <form class="form-enviar-produtos" >
                                                <td>
                                                    <input type="text" id="QTDEstoque" name="QTDEstoque" placeholder="Quantidade Estoque" style="display:block;">
                                                </td>
                                                <td>
                                                    <input type="text" id="PosicaoEstoque" name="PosicaoEstoque" placeholder="Posição" style="display:block;">
                                                </td>
                                                <td>
                                                    <input type="hidden" name="id_pedido" value="' . htmlspecialchars($idpedido) . '">
                                                    <input type="hidden" name="QTTdoca" value="' . htmlspecialchars($QuantidadeDoca) . '">
                                                    <input type="hidden" name="ItemEstoque" value="' . htmlspecialchars($QuantidadeEstoque) . '">
                                                    <input type="hidden" name="cod_itempedido" value="' . htmlspecialchars($codItemPedido) . '">
                                                    <input type="submit" id="EnviarEstoque" name="EnviarEstoque" value="Enviar" style="display:block;">
                                                </td>
                                            </form>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Produto no pedido não encontrado</td></tr>';
                            }
                        }
                        echo '</table>
                        </div>';
                    } else {
                        $UpdateSituation = "UPDATE pedido SET Situacao = 'Em movimentação' WHERE cod_pedido = '$idpedido' AND codTurma = '{$_SESSION['codTurma']}'";
                        $executeUpdate = $conexao -> query($UpdateSituation);

                        echo '<p>Esse pedido não possui itens ou itens já foram enviados para a movimentação</p>';
                    }
                } else {
                    echo '<p>Pedido não encontrado ou pedido não passou pela vistoria ainda</p>';
                }
            } else {
                echo '<p>Dados insuficientes, por favor clique para abrir o pedido que está nas docas</p>';
            }
        }

    $conexao->close();
    echo '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>';
}
?>
<script>    
$('.form-enviar-produtos').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);  // Verifique se os dados do formulário estão corretos
    $.ajax({
        type: 'POST',
        url: 'function/definirQTTposicao.php',
        data: formData,
        success: function(response) {
            console.log(response);  // Verifique a resposta do servidor
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                var inputEspera = document.getElementsByClassName('Quantidade_espera');
                for (var i = 0; i < inputEspera.length; i++) {
                    if (inputEspera[i].getAttribute('cod_itempedido') == jsonResponse.codItemPedido) {
                        if (jsonResponse.newqttdoca == 0) {
                            var row = inputEspera[i].closest('tr');
                            if (row) {
                                row.remove();
                            }
                        } else {
                            inputEspera[i].textContent = jsonResponse.newqttdoca;
                        }
                        break;
                    }
                }
                setTimeout(function() {
                    window.location.reload();
                }, 100);
            } else {
                alert(jsonResponse.message); 
            }       
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Erro ao enviar dados do formulário.');
        }
    });
});
</script>
</body>
</html>