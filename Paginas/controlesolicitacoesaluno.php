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
            width: 60%;
            height: 60%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            border-radius: 30px;
            display:flex;
            flex-direction: row;
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
        #fecharOverlayBtn {
            cursor: pointer;
            width: 90%;
            background-color: rgb(0, 119, 255);
            height: 50px;
            border:none;
            border-radius: 5px;
            color: white;
            transition: 1s;
        }
        #fecharOverlayBtn:hover {
            transition: 1s;
            transform: scale(1.05);
            cursor: pointer;
            width: 90%;
            background-color: #3691fa;
            height: 50px;
            border:none;
            border-radius: 5px;
            color: black;
            box-shadow: 0 0 5px rgb(0, 119, 255);
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
                                <li class="li-vertical"><a class="a-vertical" href="aluno.php">MENU</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="perfilaluno.php">PERFIL</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="sobrenosaluno.php">SOBRE NÓS</a></li>
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
                    <a href="projetoaluno.php" class="functions-menu">VOLTAR</a>
                    <a href="danfealuno.php" class="functions-menu">DANFE</a>
                    <a href="recebimentodocaaluno.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="estoquealuno.php" class="functions-menu">ESTOQUE</a>
                    <a href="movimentacaoaluno.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="operacaomovimentacaoaluno.php" class="functions-menu">OPERAÇÃO</a>
                    <a href="pickingaluno.php" class="functions-menu">PICKING</a>
                    <a href="expediçaoaluno.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="vistoriasolicitacoesaluno.php" class="functions-menu">CONFERÊNCIA SOLICITACAÇÕES</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>CONTROLE SOLICITAÇÕES</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>SOLICITAÇÕES:</h5>
                                    <a href="recebimentosolicitacoesaluno.php" class="button-pedidos">Recebimento das solicitações</a>
                                <h5>ESTOQUE:</h5>
                                    <a href="estoquealuno.php" class="button-pedidos">Meu Estoque</a>
                                <h5>DOCAS:</h5>
                                    <a href="recebimentodocaaluno.php" class="button-pedidos">Recebimento das docas</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>DE ONDE VAI SER RETIRADO?</h4>';

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

                    $sqlItensSolicitacao= "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}' AND Quantidade_espera != 0";
                    $execute = $conexao->query($sqlItensSolicitacao);

                    if ($execute && $execute->num_rows > 0) {
                        echo '<div class="MainContainer">
                                                    <div class="main-overlay">             
                                                        <form class="form-verificacao">
                                                            <input type="text" class="button-disponilidade" name="Nome_produto" placeholder="Nome do produto" style="display:block;">
                                                            <input type="text" class="button-disponilidade" name="QTDEstoqueDisponivel" placeholder="Quantidade para retirada" style="display:block;">
                                                            <input type="submit" class="VerificarEstoque" name="VerificarEstoque" value="VerificarDisponibilidade" style="display:block;">
                                                        </form>
                                                    </div>
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

                            $SelectItensPicking = "SELECT * FROM itenspicking WHERE cod_itemSolicitacao = '$codItemSolicitacao' AND Situacao = 'No processo de picking' AND codTurma = '{$_SESSION['codTurma']}'";
                            $resultado = $conexao -> query($SelectItensPicking);

                            if($resultado && $resultado -> num_rows > 0){
                                $rowItenPicking = $resultado -> fetch_assoc();
                                $QuantidadePicking = $rowItenPicking['Quantidade'];
                            } else{
                                $QuantidadePicking = 0;
                            }

                            if ($executar && $executar->num_rows > 0) {
                                while ($rowProdutos = $executar->fetch_assoc()) {
                                    echo '<tr>
                                            <td>' . htmlspecialchars($rowProdutos['Nome']) . '</td>
                                            <td>' . htmlspecialchars($rowProdutos['UN']) . '</td>
                                            <td class="Quantidade_esperar" codItemSolicitacao="' . htmlspecialchars($codItemSolicitacao) . '">' . htmlspecialchars($Quantidade_espera) . '</td>
                                            <form class="form-enviar-produtos">
                                                <td>
                                                    <input type="hidden" name="cod_produto" value="' . htmlspecialchars($cod_produto) . '">
                                                    <input type="text" class="QTDEstoque" name="QTDEstoque" placeholder="Quantidade para retirada" style="display:block;">
                                                </td>
                                                    <td>
                                                        <input type="text" class="PosicaoEstoque" name="PosicaoEstoque" placeholder="Posição" style="display:block;">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="id_solicitacao" value="' . htmlspecialchars($id_solicitacao) . '">
                                                        <input type="hidden" name="QTTespera" value="' . htmlspecialchars($Quantidade_espera) . '">
                                                        <input type="hidden" name="ItemPicking" value="' . htmlspecialchars($QuantidadePicking) . '">
                                                        <input type="hidden" name="cod_itempSolicitacao" value="' . htmlspecialchars($codItemSolicitacao) . '">
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
                        $UpdateSituation = "UPDATE solicitacoes SET Situacao = 'Em Processo de picking' WHERE id_solicitacao = '$id_solicitacao' AND codTurma = '{$_SESSION['codTurma']}'";
                        $executeUpdate = $conexao -> query($UpdateSituation);

                        echo '<p>Esta solicitação não possui itens ou itens já foram enviados para a movimentação</p>';
                    }
                } else {
                    echo '<p>Solicitação não encontrada ou solicitação não passou pela vistoria ainda</p>';
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
                    var inputEspera = document.getElementsByClassName('Quantidade_esperar');
                    for (var i = 0; i < inputEspera.length; i++) {
                        if (inputEspera[i].getAttribute('codItemSolicitacao') == jsonResponse.cod_itemSolicitacao) {
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
                    
                    // Verificar se a tabela está vazia
                    var table = document.querySelector('.tabela');
                    var rows = table.getElementsByTagName('tr');
                    // Descontar a primeira linha que é o cabeçalho
                    if (rows.length <= 1) {
                        // Atualizar a situação da solicitação aqui
                        $.ajax({
                            type: 'POST',
                            url: 'function/AtualizarSituacaoSolicitacao.php',
                            data: { solicitacaoId: <?php echo json_encode($id_solicitacao) ?>},
                            success: function(updateResponse) {
                                console.log(updateResponse);
                                var jsonUpdateResponse = JSON.parse(updateResponse);
                                if(jsonUpdateResponse.success){
                                    alert(jsonUpdateResponse.message);
                                } else{
                                    alert(jsonUpdateResponse.message);
                                }
                                
                            },
                            error: function(xhr, status, error) {
                                console.error('Erro ao atualizar a situação da solicitação:', error);
                            }
                        });
                    }

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