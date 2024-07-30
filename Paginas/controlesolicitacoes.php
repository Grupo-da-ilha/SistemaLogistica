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
    <style>
        .overlay {
            position: absolute; /* Alterado de 'fixed' para 'absolute' */
            top: 100;
            left: 50;
            width: 55%;
            height: 60%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99; /* Certifique-se de que o overlay esteja acima de outros elementos */
        }

        .overlay-content {
            background: white;
            padding: 10px; /* Ajuste o padding conforme necessário */
            border-radius: 10px;
            width: 70%; /* Ajuste a largura conforme necessário */
            height: 50%;
            max-width: 300px; /* Ajuste a largura máxima conforme necessário */
        }
    </style>
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
                                <h5>SOLICITAÇÕES:</h5>
                                    <a href="recebimentosolicitacoes.php" class="button-pedidos">Recebimento das solicitações</a>
                                <h5>ESTOQUE:</h5>
                                    <a href="estoque.php" class="button-pedidos">Meu Estoque</a>
                                <h5>DOCAS:</h5>
                                    <a href="recebimentodoca.php" class="button-pedidos">Recebimento das docas</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PARA ONDE OS ITENS VÃO?</h4>';

            if (isset($_POST['id_solicitacao'])) {
                $id_solicitacao = $conexao->real_escape_string($_POST['id_solicitacao']);

                $sql = "SELECT cod_solicitacao FROM solicitacoes WHERE id_solicitacao = '$id_solicitacao' AND Situacao = 'Em processamento' AND codTurma = '{$_SESSION['codTurma']}'";
                $execute = $conexao->query($sql);

                if ($execute && $execute->num_rows > 0) {
                    $row = $execute->fetch_assoc();
                    $cod_solicitacao = $row['cod_solicitacao'];

                    echo '<div class="DivInicial" style="display:flex; margin-bottom: 50px">
                            <h6> Código da solicitação: ' . htmlspecialchars($cod_solicitacao) . '</h6>
                        </div>';

                    $sqlItensSolicitacao= "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}'";
                    $execute = $conexao->query($sqlItensSolicitacao);

                    if ($execute && $execute->num_rows > 0) {
                        echo '<div class="MainContainer">
                                <table class="tabela"> 
                                    <tr>
                                        <td>Produtos</td>
                                        <td>UN</td>
                                        <td>Quantidade à espera</td>
                                        <td>QTD para retirada</td>
                                        <td>Posição no Estoque</td>
                                        <td>Ações</td>
                                    </tr>';
                        while ($row = $execute->fetch_assoc()) {
                            $cod_produto = $row['cod_produto'];
                            $Quantidade = $row['Quantidade'];
                            $Quantidade_espera = $row['Quantidade_espera'];
                            $codItemSolicitacao = $row['cod_itemSolicitacao'];

                            $sqlProdutos= "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                            $executar = $conexao->query($sqlProdutos);

                            /*$SelectItensEstoque = "SELECT * FROM itensestoque WHERE cod_itenpedido = '$codItemPedido' AND Situacao = 'Em movimentação'";
                            $resultado = $conexao -> query($SelectItensEstoque);

                            if($resultado && $resultado -> num_rows > 0){
                                $rowItenEstoque = $resultado -> fetch_assoc();
                                $QuantidadeEstoque = $rowItenEstoque['Quantidade'];
                            } else{
                                $QuantidadeEstoque = 0;
                            }*/

                            if ($executar && $executar->num_rows > 0) {
                                while ($rowProdutos = $executar->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . htmlspecialchars($rowProdutos['Nome']) . '</td>
                                            <td>' . htmlspecialchars($rowProdutos['UN']) . '</td>
                                            <td class="Quantidade_espera" codItemSolicitacao="' . htmlspecialchars($codItemSolicitacao) . '">' . htmlspecialchars($Quantidade_espera) . '</td>
                                                <td>
                                                    <div class="main-overlay">             
                                                        <form class="form-verificacao" data-form-id="1">
                                                            <input type="hidden" name="cod_produto" value="' . htmlspecialchars($cod_produto) . '">
                                                            <input type="text" class="QTDEstoque" name="QTDEstoque" placeholder="Quantidade para retirada" style="display:block;">
                                                            <input type="submit" class="VerificarEstoque" name="VerificarEstoque" value="VerificarDisponibilidade" style="display:block;">
                                                        </form>
                                                    </div>
                                                </td>
                                                <form class="form-enviar-produtos" data-form-id="1">
                                                    <td>
                                                        <input type="text" class="PosicaoEstoque" name="PosicaoEstoque" placeholder="Posição" style="display:block;">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="id_solicitacao" value="' . htmlspecialchars($id_solicitacao) . '">
                                                        <input type="hidden" name="QTTespera" value="' . htmlspecialchars($Quantidade_espera) . '">
                                                        <input type="hidden" name="cod_itempSolicitacao" value="' . htmlspecialchars($codItemSolicitacao) . '">
                                                        <input type="hidden" class="hiddenQTDEstoque" name="hiddenQTDEstoque" value="">
                                                        <input type="submit" class="EnviarEstoque" name="EnviarEstoque" value="Enviar" style="display:block;">
                                                    </td>
                                                </form>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Produto no pedido não encontrado</td></tr>';
                            }
                        }
                        echo '</table>
                                </div>
                                    <div class="overlay" id="codigoOverlay" style="display:none;">
                                    <div class="overlay-content">
                                        <p>Posições onde se encontra esse produto:</p>
                                        <br>
                                        <div id="posicoesEstoque"></div>
                                        <button type="button" id="fecharOverlayBtn">Fechar</button>
                                </div>
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
                echo '<p>Dados insuficientes, por favor clique para abrir a solicitação que à espera</p>';
            }
        }

    $conexao->close();
    echo '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>';
}
?>
<script> 
$(document).ready(function() {
    $('.form-verificacao').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        console.log(formData);  // Verifique se os dados do formulário estão corretos
        $.ajax({
            type: 'POST',
            url: 'function/consulta_estoque.php',
            data: formData,
            dataType: 'json',  // Adicione esta linha
            success: function(response) {
                console.log(response);  // Verifique a resposta do servidor
                if (response.success) {
                    var overlay = $('#codigoOverlay');
                    var posicoesEstoque = $('#posicoesEstoque');
                    
                    posicoesEstoque.empty();  // Limpar conteúdo anterior

                    response.positions.forEach(function(posicao) {
                        var codEstoque = posicao.cod_estoque;
                        var color = posicao.color;
                        var quantidade = posicao.quantidade; // Assumindo que a quantidade também é retornada
                        posicoesEstoque.append(
                            '<div style="background-color:' + color + '; color:white; text-align: center;">' +
                            'Posição: ' + codEstoque + ' - Quantidade: ' + quantidade +
                            '</div>'  + '<br>' 
                        );
                    });

                    overlay.show();
                } else {
                    alert(response.message); 
                }       
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Erro ao enviar dados do formulário.');
            }
        });
    });

    $('#fecharOverlayBtn').click(function() {
        $('#codigoOverlay').hide();
    });
});

document.querySelectorAll('.form-enviar-produtos').forEach(function(formEnviar) {
        formEnviar.addEventListener('submit', function() {
            var formId = formEnviar.getAttribute('data-form-id');
            
            // Encontra o formulário de verificação correspondente
            var formVerificacao = document.querySelector('.form-verificacao[data-form-id="' + formId + '"]');
            
            if (formVerificacao) {
                var qtdeEstoque = formVerificacao.querySelector('.QTDEstoque').value;
                console.log('QTDEstoque:', qtdeEstoque);  // Debug
                formEnviar.querySelector('.hiddenQTDEstoque').value = qtdeEstoque;
            }
        });
    });

    // Envio do formulário com AJAX
    $('.form-enviar-produtos').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        console.log(formData);  // Verifique se os dados do formulário estão corretos
        $.ajax({
            type: 'POST',
            url: 'function/DefinirPickingSolicitacao.php',
            data: formData,
            success: function(response) {
                console.log('Resposta do servidor:', response);  // Debug
                try {
                    var jsonResponse = JSON.parse(response);
                    console.log(jsonResponse);
                    if (jsonResponse.success) {
                        var inputEspera = document.getElementsByClassName('Quantidade_espera');
                        for (var i = 0; i < inputEspera.length; i++) {
                            if (inputEspera[i].getAttribute('codItemSolicitacao') == jsonResponse.codItemSolicitacao) {
                                if (jsonResponse.newqttespera == 0) {
                                    var row = inputEspera[i].closest('tr');
                                    if (row) {
                                        row.remove();
                                    }
                                } else {
                                    inputEspera[i].textContent = jsonResponse.newqttespera;
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
                } catch (e) {
                    console.error('Erro ao analisar JSON:', e);
                    alert('Erro na resposta do servidor.');
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