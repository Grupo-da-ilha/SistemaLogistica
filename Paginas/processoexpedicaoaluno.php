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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a href="projetoaluno.php" class="functions-menu">VOLTAR</a>
                    <a href="danfealuno.php" class="functions-menu">DANFE</a>
                    <a href="recebimentodocaaluno.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="controledocaaluno.php" class="functions-menu">CONTROLE</a>
                    <a href="estoquealuno.php" class="functions-menu">ESTOQUE</a>
                    <a href="movimentacaoaluno.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="operacaomovimentacaoaluno.php" class="functions-menu">OPERAÇÃO</a>
                    <a href="pickingaluno.php" class="functions-menu">PICKING</a>
                    <a href="expediçaoaluno.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="vistoriasolicitacoesaluno.php" class="functions-menu">CONFERÊNCIA SOLICITACAÇÕES</a>
                </li>
            </div>
            <div class="movimentacao-container">
                <div class="titulo-recebimento">
                    <h3>PROCESSO DE EXPEDIÇÃO</h3>    
                </div>
                <h7>Confira se os itens abaixo chegaram à expedição</h7>
                ';
                // Verificar se a pessoa clicou para abrir a solicitação
                if(isset($_POST['id_solicitacao_expedicao'])){
                    $id_solicitacao = $conexao->real_escape_string($_POST['id_solicitacao_expedicao']);

                    $SelectcodSolicitacao = "SELECT cod_solicitacao FROM solicitacoes WHERE id_solicitacao = '$id_solicitacao'";
                    $executecodsolicitacao = $conexao -> query($SelectcodSolicitacao);

                    if($executecodsolicitacao && $executecodsolicitacao -> num_rows > 0){
                        $row = $executecodsolicitacao -> fetch_assoc();

                        $cod_solicitcao = $row['cod_solicitacao'];
                    }
                    
                    $selectItens = "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '$id_solicitacao' AND codTurma ='{$_SESSION['codTurma']}'";
                    $execute = $conexao->query($selectItens);

                    if($execute && $execute->num_rows > 0){
                        echo '
                        <h7>Número da solicitação: ' . htmlspecialchars($cod_solicitcao) . '</h7>
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
                        while($row = $execute->fetch_assoc()){
                            
                            // Guardar código do item solicitacao
                            $cod_itemSolicitacao = $row['cod_itemSolicitacao'];
                            $cod_produto = $row['cod_produto'];

                            $selectPicking = "SELECT * FROM itenspicking WHERE cod_itemSolicitacao = '$cod_itemSolicitacao' AND codTurma ='{$_SESSION['codTurma']}' AND Situacao = 'Na expedição'"; 
                            $executar = $conexao->query($selectPicking);
                            

                            if($executar && $executar->num_rows > 0){
                                while($rowItens = $executar->fetch_assoc()){
                                    
                                    // Quandar cod_estoque
                                    $cod_estoque = $rowItens['cod_estoque'];
                                    $cod_itemPicking = $rowItens['cod_itemPicking'];
                                    $QuantidadeItemPicking = $rowItens['Quantidade'];

                                    // Pesquisar produtos
                                    $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                    $resultado = $conexao->query($selectProdutos);
                                    
                                    if($resultado && $resultado->num_rows > 0){
                                        while($rowProduto = $resultado->fetch_assoc()){
                                            $Nome = $rowProduto['Nome'];
                                            $UN = $rowProduto['UN'];
                                        }
                                    }
                                }
                            } else {
                                // Definindo variáveis padrão
                                $cod_estoque = "";
                                $cod_itemPicking = "";
                                $QuantidadeItemPicking = "";
                                $Nome = "";
                                $UN = "";
                                $andar = "";
                                $apartamento = "";
                            }

                            // Pesquisar a posição do item
                            $selectPosicao = "SELECT * FROM estoque WHERE cod_estoque = '$cod_estoque'";
                            $executePosicao = $conexao->query($selectPosicao);

                            if($executePosicao && $executePosicao->num_rows > 0){
                                while($rowEstoque = $executePosicao->fetch_assoc()){
                                    $andar = $rowEstoque['Andar'];
                                    $apartamento = $rowEstoque['Apartamento'];
                                }
                            } else {
                                // Definindo variáveis padrão caso não haja posição
                                $andar = "";
                                $apartamento = "";
                            }
                            
                            echo '<tr>
                                    <td>' . htmlspecialchars(isset($Nome) ? $Nome : '') . '</td>
                                    <td>' . htmlspecialchars(isset($UN) ? $UN : '') . '</td>
                                    <td>' . htmlspecialchars(isset($QuantidadeItemPicking) ? $QuantidadeItemPicking : '') . '</td>
                                    <td>' . htmlspecialchars(isset($andar) && isset($apartamento) ? $andar . $apartamento : '') . '</td>
                                    <td style="display: flex;">
                                        <form class="form-expedicao-finalizada">
                                            <input type="hidden" name="cod_item_picking" value="' . htmlspecialchars(isset($cod_itemPicking) ? $cod_itemPicking : '') . '" style="display: block;">
                                            <input type="submit" class="InputPego" name="PegarItem" value="OK" style="display: block;" cod_item_picking="' . htmlspecialchars(isset($cod_itemPicking) ? $cod_itemPicking : '') . '">
                                        </form>
                                    </td>
                                </tr>';
                        }
                        // Forms para enviar os produtos selecionados para a tela de operação
                        echo '
                            </table>
                            <br>
                            <form id="form-finalizar-expedicao" style="margin-left: 22vw;">
                                <div style="display: flex; flex-direction:row; justify-content:center; align-itens:center; margin-left: -23vw;"">
                                    <h7>PARA QUAL DOCA SERÁ ENVIADO OS ITENS?</h7>
                                    <input type="text" name="doca" class="doca-itens" style="display: block; margin-left: 10px;" placeholder="Doca:">
                                </div>
                                <input type="hidden" name="id_solicitacao" value="' . htmlspecialchars($id_solicitacao) . '" style="display: block;">
                                <input type="submit" id="EnviarExpedicao" name="EnviarExpedicao" value="Finalizar Expedição" style="display:block;" class="irparaoperacao">
                            </form>  
                        </div>
                        ';
                    } else {
                        echo 'Nenhuma operação em aberto';
                    }
echo '
            </div>
        </div>
    </main>';           
    }
    } 
    
}?>
<script>
$(document).ready(function() {
    $('.form-expedicao-finalizada').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        console.log(formData);  // Verifique se os dados do formulário estão corretos
        $.ajax({
            type: 'POST',
            url: 'function/verificarexpedicao.php',
            data: formData,
            success: function(response) {
                console.log(response);  // Verifique a resposta do servidor
                var jsonResponse = JSON.parse(response);
                console.log(jsonResponse);  
                if (jsonResponse.success) {
                    var inputPego = document.getElementsByClassName('InputPego');

                    for (var i = 0; i < inputPego.length; i++) {
                        if (jsonResponse.Docas == 1 && inputPego[i].getAttribute('cod_item_picking') == jsonResponse.cod_item_picking) {
                            inputPego[i].style.backgroundColor = 'green';
                            inputPego[i].style.color = 'white';
                        }
                    }
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
});

$(document).ready(function() {
    $('#form-finalizar-expedicao').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'function/FinalizarExpedicao.php',
            data: formData,
            success: function(response) {
                console.log(response);  // Verifique a resposta do servidor
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    window.location.href = 'vistoriasolicitacoesaluno.php'
                } else {
                    alert('Erro ao atualizar a situação: ' + jsonResponse.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Erro ao enviar dados do formulário.');
            }
        });
    });
});
</script>
</body>
</html>
