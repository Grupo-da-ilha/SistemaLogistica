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
    <link rel="stylesheet" href="../css/estoque.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
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
    }
    
    if (isset($_SESSION['Idprojeto'])) {
        $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
        $execute = $conexao->query($sql);
    
        if ($execute->num_rows > 0) {
            $row = $execute->fetch_assoc();
            $cod_turma = $row['codTurma'];
        }
    } else {
        echo ''.$_SESSION['Idprojeto']. '';
    }

    if (isset($_POST['VerProdutos']) && !empty($_POST['cod_pedido'])) {
        $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
        $selectPedido = "SELECT id_pedido FROM pedido WHERE cod_pedido = '$cod_pedido' AND codTurma = '$cod_turma'";
        $executar = $conexao->query($selectPedido);

        if ($executar->num_rows > 0) {
            $row = $executar->fetch_assoc();
            $_SESSION['id_pedido'] = $row['id_pedido'];
        }
    }
}
?>
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
                            <h2><?php echo $_SESSION['nome']; ?></h2>
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
                    <a href="carga.php" class="functions-menu">VISTORIA</a>
                    <a href="recebimentodoca.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="controledoca.php" class="functions-menu">CONTROLE</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="picking.php" class="functions-menu">PICKING</a>
                    <a href="expedicao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="relatorios.php" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>ESTOQUE</h3>
                </div>
                <div class="orientar-card">
                    <div class="info-total">
                        <div class="criar-pedido">
                            <div class="submenus-pedidos">
                                <h4> FILTRO:</h4>
                                <div class="info-pedido">
                                    <form id="form-estoque-posicao"> 
                                        <input type="text" name="nome_produto" style="display: block;" class="input-options-criar-pedido" placeholder="Produto:">
                                        <input type="text" name="UN_produto" style="display: block;" class="input-options-criar-pedido" placeholder="UN">
                                        <input type="text" name="Quantidade_produto" style="display: block;" class="input-options-criar-pedido" placeholder="Quantidade:">
                                        <input type="submit" value="CONSULTAR" style="display: block;" class="input-function-criar-pedido">
                                    </form>
                                    <div class="legenda">
                                        <p>LEGENDA:</p>
                                        <div class="legenda-sub">
                                            <div class="vermelho"></div>
                                            <p>NÃO HÁ QUANTIDADE SOLICITADA</p>
                                        </div>
                                        <div class="legenda-sub">
                                            <div class="azul"></div>
                                            <p>MAIS DA QUANTIDADE SOLICITADA</p>
                                        </div>
                                        <div class="legenda-sub">
                                            <div class="verde"></div>
                                            <p>EXATAMENTE A QUANTIDADE SOLICITADA</p>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                            <div class="submenus-pedidos">
                                <h4> QUANTIDADE:</h4>
                                <div class="info-posicao">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="locais-estoque">
                        <div class="posicao">
                            <div class="posicao-container" cod-estoque="1">A1</div>
                            <div class="posicao-container" cod-estoque="2">A2</div>
                            <div class="posicao-container" cod-estoque="3">A3</div>
                            <div class="posicao-container" cod-estoque="4">A4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container" cod-estoque="5">B1</div>
                            <div class="posicao-container" cod-estoque="6">B2</div>
                            <div class="posicao-container" cod-estoque="7">B3</div>
                            <div class="posicao-container" cod-estoque="8">B4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container" cod-estoque="9">C1</div>
                            <div class="posicao-container" cod-estoque="10">C2</div>
                            <div class="posicao-container" cod-estoque="11">C3</div>
                            <div class="posicao-container" cod-estoque="12">C4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container" cod-estoque="13">D1</div>
                            <div class="posicao-container" cod-estoque="14">D2</div>
                            <div class="posicao-container" cod-estoque="15">D3</div>
                            <div class="posicao-container" cod-estoque="16">D4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container" cod-estoque="17">E1</div>
                            <div class="posicao-container" cod-estoque="18">E2</div>
                            <div class="posicao-container" cod-estoque="19">E3</div>
                            <div class="posicao-container" cod-estoque="20">E4</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
$('#form-estoque-posicao').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);  // Verifique se os dados do formulário estão corretos
    $.ajax({
        type: 'POST',
        url: 'function/VerificarEstoque.php',
        data: formData,
        success: function(response) {
            console.log(response);  // Verifique a resposta do servidor
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {  // Verifique jsonResponse.success em vez de response.success
                var inputposicao = document.getElementsByClassName('posicao-container');

                for (var i = 0; i < inputposicao.length; i++) {
                    inputposicao[i].style.backgroundColor = '';  // Resetar cor de fundo
                    inputposicao[i].style.color = '';  // Resetar cor do texto
                }

                for (var i = 0; i < jsonResponse.positions.length; i++) {
                    var codEstoque = jsonResponse.positions[i].cod_estoque;
                    var color = jsonResponse.positions[i].color;
                    for (var j = 0; j < inputposicao.length; j++) {
                        if (inputposicao[j].getAttribute('cod-estoque') == codEstoque) {
                            inputposicao[j].style.backgroundColor = color;
                            inputposicao[j].style.color = 'white';  // Defina a cor como string válida
                        }
                    }
                }
                var containers = document.getElementsByClassName('info-posicao');
                
                // Limpa o conteúdo da div antes de adicionar novos elementos
                containers[0].innerHTML = ''; // Remove qualquer conteúdo existente na primeira div com a classe 'info-posicao'

                // Cria novos elementos para cada item da lista
                for (var i = 0; i < jsonResponse.positions.length; i++) {
                    var p_container = document.createElement('div');
                    p_container.className = 'info-pedido-item';
                    
                    var p_quantidade = document.createElement('p');
                    p_quantidade.className = 'paragrafo-quantidade';
                    p_quantidade.textContent = 'Quantidade: ' + jsonResponse.positions[i].Quantidade;
                    
                    var p_posicao = document.createElement('p');
                    p_posicao.className = 'paragrafo-posicao';
                    p_posicao.textContent = 'Posição: ' + jsonResponse.positions[i].Posicoes;
                    
                    p_container.append(p_quantidade);
                    p_container.append(p_posicao);
                    
                    containers[0].append(p_container);
                }
            } else {
                alert(jsonResponse.message);  // Mostra mensagem apenas quando success é false
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
