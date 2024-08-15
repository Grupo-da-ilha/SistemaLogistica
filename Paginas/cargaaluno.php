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
    <link rel="stylesheet" href="../css/menuhorizontal.css"/>
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
                                    <input type="submit" value="OK" style="display: block" name="enviar_doca" id="pedido-nota">
                                </form>
                            </div>
                        </div>';
                        if(!isset($id_pedido)){
                            echo '';
                        }else{
                            echo '';
                        }
                        if(isset($_POST['enviar-pedido']) && !empty($_POST['nota_fiscal']) && !empty($_POST['cod_pedido'])){
                            $_SESSION['nota_fiscal_doca'] = $_POST['nota_fiscal'];
                            $_SESSION['codigo_pedido_doca'] = $_POST['cod_pedido'];


                            $nota_fiscal = $conexao->real_escape_string($_POST['nota_fiscal']);
                            $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);

                            $sql = "SELECT id_pedido FROM pedido WHERE cod_pedido = '$cod_pedido' AND codTurma ='{$_SESSION['codTurma']}' AND Situacao = 'Em transporte'";
                            $execute = $conexao -> query($sql);

                            if($execute -> num_rows > 0){
                                $row = $execute -> fetch_assoc();
                                $id_pedido = $row['id_pedido'];
                                $_SESSION['Idpedido'] = $id_pedido;
                            }else{
                                $sqlSituacaoPedido = "SELECT Situacao, id_pedido FROM pedido WHERE  cod_pedido = '$cod_pedido' AND codTurma ='{$_SESSION['codTurma']}'";
                                $executar = $conexao -> query($sqlSituacaoPedido);

                                if($executar && $executar -> num_rows > 0){
                                    $row = $executar -> fetch_assoc();
                                    $Situacao = $row['Situacao'];
                                    $idPedido = $row['id_pedido'];

                                    if($Situacao == 'Em processamento'){
                                        echo 'O seu pedido não foi finalizado, ainda está em processamento';
                                        echo '<br>';
                                    } elseif($Situacao == 'Nas docas'){
                                        echo 'O seu pedido ja passou pela conferência e vistoria';
                                        echo '<br>';
                                    } elseif( empty($idPedido)){
                                        echo 'Esse pedido não existe';
                                    }
                                    else{
                                        echo 'O seu pedido não foi finalizado, ainda está em processamento ou ja passou pela conferência e vistoria';
                                    }
                                    }
                                }
                            } else{
                                echo '<p>Preencha os campos ao lado</p>';
                            }

                            if (!isset($id_pedido)) {
                                $id_pedido = 0;
                                echo ''; 
                            } else {
                            }
                            if (!isset($nota_fiscal)) {
                                $nota_fiscal = 0;
                                echo ''; 
                            } else {
                            }

                                $sqlnota = "SELECT * FROM nota_fiscal WHERE cod_nota = '".$nota_fiscal."' AND id_pedido = '".$id_pedido."'";
                                $executar = $conexao->query($sqlnota);

                                if($executar->num_rows > 0){
                                    $sql = "SELECT * FROM pedido WHERE id_pedido = '".$_SESSION['Idpedido']."' AND codTurma ='{$_SESSION['codTurma']}'";
                                    $executar = $conexao->query($sql);

                                    if($execute->num_rows > 0){
                                        $sql = "SELECT * FROM itenspedido WHERE cod_pedido = '".$_SESSION['Idpedido']."'";
                                        $execute = $conexao->query($sql);

                                        if($execute->num_rows > 0){ 
                                            $sql = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                            FROM produtos 
                                            LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                            WHERE itenspedido.cod_pedido = '".$_SESSION['Idpedido']."' ORDER BY produtos.Nome ASC";
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
                                                echo '<td>' . htmlspecialchars($row['UN']). '</td>';
                                                echo '<td>Quantidade: ' . htmlspecialchars($row['Quantidade']). '
                                                <form style="display: none; width: auto; height:50px;" class="form_quantidade">
                                                    <input type="hidden" name="codigoitem" value="'. htmlspecialchars($row['cod_itenPedido']) .'">
                                                    <input type="hidden" name="Clausula" class="clausula" value="">
                                                    <input type="text" class="quantidade_falta" name="Quantidade_falta" style="display: none;">
                                                    <input type="submit" class="update_qt" name="UpdateQt" value="Salvar" style="display: none; margin-left: 10px;">
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
                                                    <input type="submit" name="Confirmar_vistoria" value="Registrar" style="display: block; margin-left: 10px;" id="Registrar">
                                                </form>
                                                </td>';
                                                echo '<td>
                                                <form class="form-vistoria-completa">
                                                    <input type="hidden" name="coditem" value="'. htmlspecialchars($row['cod_itenPedido']) .'">
                                                    <input type="submit" name="Vistoria" style="display: block;" value="Vistoria Concluída"  id="Vistoria-Concluída" class="Vistoria-Concluída">
                                                </form>
                                            </td>';
                                            }
                                            echo'</tr>';
                                            echo '</table>';
                                            echo '
                                            <form style="margin-top: 40px" id="form-conferencia-completa">
                                                <input type="submit" name="Vistoria_recebimento" style="display: block;" value="Finalizar Vistoria e recebimento"  id="Finalizar">
                                            </form>';
                                            echo '</div>';
                                        } else {
                                            $sql = "UPDATE pedido SET Situacao = 'Em processamento' WHERE cod_pedido = '$cod_pedido' AND codTurma ='{$_SESSION['codTurma']}'";
                                            $execute = $conexao -> query($sql);

                                            if($execute){
                                                $sql = "UPDATE itenspedido SET VistoriaConcluida = '0', Faltando = '0', Avariado = '0' WHERE cod_pedido = '$id_pedido' AND codTurma ='{$_SESSION['codTurma']}'";
                                                $execute = $conexao -> query($sql);
                                            }
                                            echo 'Esse pedido não possui itens, por favor adicione itens';
                                        }
                                    } else {
                                        echo 'Código do pedido incorreto, verifique se ele foi criado e finalizado no projeto atual';
                                    }
                                } else {
                                    if($nota_fiscal == 0){
                                        echo '';
                                    }else{
                                    echo 'Código da nota fiscal e do pedido não correspondem, verifique os o codigo do pedido e da nota_fiscal para o seu projeto atual';
                                    }
                                }  
                    }
echo '            </div>
                </div>
            </div>
        </div>
    </main>';
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

$(document).ready(function() {
    $('.form-conferencia').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);

        $.ajax({
            type: 'POST',
            url: 'function/processorecebimento.php',
            data: formData,
            success: function(response) {
                console.log(response);
                var jsonResponse = JSON.parse(response);
                console.log(jsonResponse);

                if (jsonResponse.success) {
                    // Encontrar o formulário 'form_quantidade' mais próximo do formulário atual
                    var form_quantidade = $(e.target).closest('tr').find('.form_quantidade')[0];
                    var form_quantidade_input_text = $(e.target).closest('tr').find('.quantidade_falta')[0];
                    var form_quantidade_input_hidden = $(e.target).closest('tr').find('.clausula')[0];
                    var form_quantidade_input_submit = $(e.target).closest('tr').find('.update_qt')[0];

                    if (jsonResponse.avariado === true && jsonResponse.faltando === false) {
                        alert(jsonResponse.message);
                        form_quantidade.style.display = 'block';
                        form_quantidade_input_text.style.display = 'block';
                        form_quantidade_input_submit.style.display = 'block';
                        form_quantidade_input_hidden.value = 'Avariado';

                    } else if (jsonResponse.avariado === false && jsonResponse.faltando === true) {
                        alert(jsonResponse.message);
                        form_quantidade.style.display = 'block';
                        form_quantidade_input_text.style.display = 'block';
                        form_quantidade_input_submit.style.display = 'block';
                        form_quantidade_input_hidden.value = 'Faltando';

                    } else {
                        alert(jsonResponse.message);
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

$('.form_quantidade').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: 'function/SalvarNovaQTT.php',
        data: formData,
        success: function(response) {
            console.log(response);
            var jsonResponse = JSON.parse(response);
            console.log(jsonResponse);
            if (jsonResponse.success) {
                // Atualizar a página para mudar a quantidade
                location.reload();
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

$('#form-conferencia-completa').submit(function(e) {
    e.preventDefault(); 
    var formData = $(this).serialize(); 
    console.log(formData);
    $.ajax({
        type: 'POST',
        url: 'function/Finalizarvistoria.php',
        data: formData,
        success: function(response) {
            console.log(response);
            var jsonResponse = JSON.parse(response);
            console.log(jsonResponse);
            if (jsonResponse.success) {
                window.location.href = "recebimentodocaaluno.php";
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
<script>
const buttons = document.querySelectorAll('.Vistoria-Concluída'); // Select buttons with class 'Vistoria-Concluída'

for (const button of buttons) {
  button.addEventListener('click', function() {
    this.style.backgroundColor = 'lightgreen'; // Change to your desired light green color
    this.dataset.clicked = 'true'; // Store the clicked state in a data attribute
  });
}
</script>
</html>
