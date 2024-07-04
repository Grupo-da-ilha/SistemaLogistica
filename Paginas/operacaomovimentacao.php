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
    <link rel="stylesheet" href="../css/operacao.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
session_start();
if (isset($_POST['project_id'])) {
    $_SESSION['Idprojeto'] = $_POST['project_id'];
}

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
    } else {
        if (isset($_SESSION['Idprojeto'])) {
            $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
            $execute = $conexao->query($sql);
        
            if ($execute->num_rows > 0) {
                $row = $execute->fetch_assoc();
                $_SESSION['codTurma'] = $row['codTurma'];
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
                        <h2><?php echo htmlspecialchars($_SESSION['nome']); ?></h2>
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
                <a href="movimentacao.php" class="functions-menu">MOVIMENTAÇÃO</a>
                <a href="estoque.php" class="functions-menu">ESTOQUE</a>
                <a href="#" class="functions-menu">PICKING</a>
                <a href="#" class="functions-menu">EXPEDIÇÃO</a>
                <a href="#" class="functions-menu">RELATÓRIOS</a>
                <a href="#" class="functions-menu">CONTROLE</a>
            </li>
        </div>
        <div class="recebimentocontainer">
            <div class="titulo-recebimento">
                <h3>OPERAÇÃO DE MOVIMENTAÇÃO</h3>    
            </div>
            <div class="info-total">
                <h6> OPERAÇÕES EM ABERTO</h6>
<?php
    if (isset($_POST['itemselecionado']) && is_array($_POST['itemselecionado'])) {
        echo '<div class="MainContainer">
                <table class="tabela">
                    <tr>
                        <td>Produtos</td>
                        <td>UN</td>
                        <td>QTD</td>
                        <td>Posição</td>
                        <td>Ações</td>
                    </tr>';
        foreach ($_POST['itemselecionado'] as $cod_Itemestoque) {
            // Select código do item do pedido parado na movimentação
            $selectItem = "SELECT * FROM itensestoque WHERE cod_itenEstoque = '$cod_Itemestoque' AND codTurma ='{$_SESSION['codTurma']}' AND Situacao = 'Em movimentação'";
            $executar = $conexao->query($selectItem);

            if ($executar && $executar->num_rows > 0) {
                while ($rowItem = $executar->fetch_assoc()) {
                    $codItemEstoque = $rowItem['cod_itenEstoque'];
                    $codItem = $rowItem['cod_itenpedido'];
                    $cod_estoque = $rowItem['cod_estoque'];
                    $Quantidade = $rowItem['Quantidade'];

                    // Selecionar a posição através da busca no estoque 
                    $selectPosicao = "SELECT Andar, Apartamento FROM estoque WHERE cod_estoque = '$cod_estoque'";
                    $executeSelectPosicao = $conexao->query($selectPosicao);

                    if ($executeSelectPosicao && $executeSelectPosicao->num_rows > 0) {
                        while ($rowPosicao = $executeSelectPosicao->fetch_assoc()) {
                            $andar = $rowPosicao['Andar'];
                            $apartemento = $rowPosicao['Apartamento'];
                            $posicao = $andar . $apartemento;
                        }
                    }
                }

                // Selecionar o código do produto contido no item do pedido
                $selectProduct = "SELECT cod_produto FROM itenspedido WHERE cod_itenPedido = '$codItem' AND codTurma ='{$_SESSION['codTurma']}'";
                $executeProduct = $conexao->query($selectProduct);

                if ($executeProduct && $executeProduct->num_rows > 0) {
                    // Guardando o código do produto contido no item
                    $rowProduct = $executeProduct->fetch_assoc();
                    $codProduto = $rowProduct['cod_produto'];

                    // Selecionando o produto
                    $selectinfoProdutos = "SELECT * FROM produtos WHERE cod_produto='$codProduto'";
                    $executeInfoProduct = $conexao->query($selectinfoProdutos);

                    if ($executeInfoProduct && $executeInfoProduct->num_rows > 0) {
                        while ($rowProdutos = $executeInfoProduct->fetch_assoc()) {
                            echo '<tr>
                                    <td>' . htmlspecialchars($rowProdutos['Nome']) . '</td>
                                    <td>' . htmlspecialchars($rowProdutos['UN']) . '</td>
                                    <td>' . htmlspecialchars($Quantidade) . '</td>
                                    <td>' . htmlspecialchars($posicao) . '</td>
                                    <form class="form-finalizar-operacao">
                                        <td>
                                            <input type="hidden" class="CodigoItemEstoque" name="CodigoItemEstoque" value="' . htmlspecialchars($codItemEstoque) . '">
                                            <input type="submit" id="FinalizarEstoque" name="FinalizarEstoque" value="Finalizar" style="display:block;">
                                        </td>
                                    </form>
                                </tr>';
                        }   
                    } else {
                        echo 'Produto não encontrado';
                    }
                } else {
                    echo 'Erro ao buscar item';
                }  
            } else {
                echo 'Operações finalizadas com sucesso';
            }
        }
        echo '</table></div>';
    } else {
        echo "Nenhuma operação em aberto";
    }
}
?>
            </div>
        </div>
    </div>
</main>
<script>
$('.form-finalizar-operacao').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);  // Verifique se os dados do formulário estão corretos
    $.ajax({
        type: 'POST',
        url: 'function/EnviarEstoque.php',
        data: formData,
        success: function(response) {
            console.log(response);  // Verifique a resposta do servidor
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                var inputcoditem = document.getElementsByClassName('CodigoItemEstoque');
                for (var i = 0; i < inputcoditem.length; i++) {
                    if (inputcoditem[i].getAttribute('value') == jsonResponse.cod_itenestoque) {
                        if (jsonResponse.Situacao == 'No estoque') {
                            var row = inputcoditem[i].closest('tr');
                            if (row) {
                                row.remove();
                            }
                        } else {
                            inputcoditem[i].textContent = jsonResponse.cod_itenestoque;
                        }
                        break;
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
</script>
</body>
</html> 