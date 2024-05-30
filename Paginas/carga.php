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
        if (isset($_POST['enviar-pedido']) && !empty($_POST['cod_pedido'])) {
            $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
            $_SESSION['cod_pedido'] = $cod_pedido;
        }
    }

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
                        <h1>SENAI SCP</h1>';
                        if (isset($_SESSION['Idprojeto'])) {
                            echo '<p>Projeto selecionado: ' . htmlspecialchars($_SESSION['Idprojeto']) . '</p>';
                            echo '<p>Código pedido selecionado: ' . htmlspecialchars($_SESSION['cod_pedido']) . '</p>';
                        } else {
                            echo '<p>Nenhum projeto selecionado.</p>';

                        }
                        echo '
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
                        <div class="notafiscal" >
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-recebimento">
                                <form action="" method="POST" id="form-nota-pedido">
                                    <h5>NOTA FISCAL:</h5>
                                    <input type="text" id="idnotafiscal" class="idnotafiscal" name="nota_fiscal" placeholder="N° Nota fiscal:" >
                                    <h5>PEDIDO DE COMPRA:</h5>
                                    <input type="text" id="pedidodecompra" class="pedidodecompra" name="cod_pedido" placeholder="Pedido de compra:">
                                    <input type="submit" id="pedido-nota" name="enviar-pedido" value="ENVIAR" style="display:block; margin-top: 5px;">
                                </form>
                                <form method="POST" id="form-doca">
                                    <h5>DOCA:</h5>
                                    <input type="text" id="doca" class="doca" placeholder="Doca:" name="doca">
                                    <input type="submit" value="OK" style="display: block" name="enviar_doca">
                                </form>
                            </div>
                        </div>';
                        if(isset($_POST['enviar-pedido']) && !empty($_POST['nota_fiscal']) && !empty($_POST['cod_pedido'])){
                            $_SESSION['nota_fiscal_doca'] = $_POST['nota_fiscal'];
                            $_SESSION['codigo_pedido_doca'] = $_POST['cod_pedido'];

                            $nota_fiscal = $conexao->real_escape_string($_POST['nota_fiscal']);
                            $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);

                            $sql = "SELECT * FROM nota_fiscal WHERE cod_nota = '".$_SESSION['nota_fiscal_doca']."' AND cod_pedido = '".$_SESSION['codigo_pedido_doca']."'";
                            $execute = $conexao->query($sql);

                            if($execute->num_rows > 0){
                                $sql = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['codigo_pedido_doca']."' AND codprojeto = '".$_SESSION['Idprojeto']."'";
                                $execute = $conexao->query($sql);

                                if($execute->num_rows > 0){
                                    $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['codigo_pedido_doca']."'";
                                    $execute = $conexao->query($sql);

                                    if($execute->num_rows > 0){ 
                                        $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                        FROM produtos 
                                        LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                        WHERE itenspedido.cod_pedido = '".$_SESSION['codigo_pedido_doca']."' ORDER BY produtos.Nome ASC";
                                        $resultado = $conexao->query($sql);  
                                        
                                        echo '<div class="produtos" style="overflow-y: auto;">';
                                        echo '<table class="tabela">
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>UN</th>
                                                    <th>QTD</th>
                                                    <th>R$/unit</th>
                                                    <th>Valor total</th>
                                                    <th>Ações</th>
                                                    <th>Finalização</th>
                                                </tr>';
                                                
                                        while ($row = $resultado->fetch_assoc()){
                                            echo'<tr>';
                                            echo '<td>' . htmlspecialchars($row['Nome']). '</td>';
                                            echo '<td>UN: ' . htmlspecialchars($row['UN']). '</td>';
                                            echo '<td>Quantidade: ' . htmlspecialchars($row['Quantidade']). '
                                            <form style="display: none;" class="form_quantidade">
                                                <input type="text" name="Quantidade falta">
                                                <input type="submit" name="UpdateQt" value="Salvar" margin-left: 10px;">
                                            </form>
                                            </td>';
                                            echo '<td>Preço Unitário: ' . htmlspecialchars($row['PrecoUNI']). '</td>';
                                            echo '<td>Valor Total: ' . htmlspecialchars($row['ValorTotal']). '</td>';
                                            echo '<td>
                                            <form style="display: flex" class="form-conferencia">
                                                Avariado?
                                                <input type="checkbox" class="avariado-produto" name="avariado" value="1">
                                                Faltando?
                                                <input type="checkbox" class="avariado-produto" name="faltando" value="1">
                                                <input type="hidden" name="codigoitem" value="'. htmlspecialchars($row['cod_itenPedido']) .'">
                                                <input type="submit" name="Confirmar_vistoria" value="Registrar" style="display: block; margin-left: 10px;">
                                            </form>
                                            </td>';
                                            echo '<td>
                                            <form class="form-vistoria-completa">
                                                <input type="hidden" name="coditem" value="'. htmlspecialchars($row['cod_itenPedido']) .'">
                                                <input type="submit" name="Vistoria" style="display: block;" value="Vistoria Concluída">
                                            </form>
                                        </td>';
                                        }
                                        echo'</tr>';
                                        echo '</table>';
                                        echo '
                                        <form action="function/Finalizarvistoria.php" method="POST" style="margin-top: 40px">
                                            <input type="submit" name="Vistoria_recebimento" style="display: block;" value="Finalizar Vistoria e recebimento">
                                        </form>';
                                        echo '</div>';
                                    } else {
                                        echo 'Esse pedido não possui itens';
                                    }
                                } else {
                                    echo 'Código do pedido incorreto, verifique se ele foi criado e finalizado no projeto atual';
                                }
                            } else {
                                echo 'Código da nota fiscal e do pedido não correspondem, verifique os o codigo do pedido e da nota_fiscal para o seu projeto atual';
                            }  
                        }
echo '            </div>
                </div>
            </div>
        </div>
    </main>';
                    }
?>
</body>
<script>
$('#form-doca').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    $.ajax({
        type: 'POST',
        url: 'function/inserirdoca.php',
        data: formData,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                alert('Doca inserida com sucesso!');
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

$('.form-conferencia').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: 'function/processorecebimento.php',
        data: formData,
        success: function(response) {
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

$('.form-vistoria-completa').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    $.ajax({
        type: 'POST',
        url: 'function/vistoriaconcluida.php',
        data: formData,
        success: function(response) {
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
</html>
