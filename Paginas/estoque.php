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
                    <a href="estoque.php" class="functions-menu">ESTOQUE</a>
                    <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                    <a href="#" class="functions-menu">PICKING</a>
                    <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="#" class="functions-menu">RELATÓRIOS</a>
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
                                    <form class="form-estoque-posicao">
                                        <input type="text" name="nome_produto" style="display: block;" class="input-options-criar-pedido" placeholder="Produto:">
                                        <input type="text" name="UN_produto" style="display: block;" class="input-options-criar-pedido" placeholder="UN">
                                        <input type="text" name="Quantidade_produto" style="display: block;" class="input-options-criar-pedido" placeholder="Quantidade:">
                                        <input type="submit" value="CONSULTAR" style="display: block;" class="input-function-criar-pedido">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="locais-estoque">
                        <div class="posicao">
                            <div class="posicao-container">A1</div>
                            <div class="posicao-container">A2</div>
                            <div class="posicao-container">A3</div>
                            <div class="posicao-container">A4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container">B1</div>
                            <div class="posicao-container">B2</div>
                            <div class="posicao-container">B3</div>
                            <div class="posicao-container">B4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container">C1</div>
                            <div class="posicao-container">C2</div>
                            <div class="posicao-container">C3</div>
                            <div class="posicao-container">C4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container">D1</div>
                            <div class="posicao-container">D2</div>
                            <div class="posicao-container">D3</div>
                            <div class="posicao-container">D4</div>
                        </div>
                        <div class="posicao">
                            <div class="posicao-container">E1</div>
                            <div class="posicao-container">E2</div>
                            <div class="posicao-container">E3</div>
                            <div class="posicao-container">E4</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    $('.form-estoque-posicao').submit(function(e) {
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
            if (jsonResponse.success) {
                alert(jsonResponse.message); 
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

