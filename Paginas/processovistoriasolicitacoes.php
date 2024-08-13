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
    $tipousuario = $_SESSION['tipousuario'];

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
                    <a href="projetoprofessor.php" class="functions-menu">VOLTAR</a>
                    <a href="criarpedido.php" class="functions-menu">PEDIDO</a>
                    <a href="carga.php" class="functions-menu">RECEBIMENTO</a>
                    <a href="estoque.php" class="functions-menu">ESTOQUE</a>
                    <a href="picking.php" class="functions-menu">PICKING</a>
                    <a href="expediçao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="relatorios.php" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="movimentacao-container">
                <div class="titulo-recebimento">
                    <h3>PROCESSO DE VISTORIA E CONFERÊNCIA</h3>    
                </div>
                <h4> CONFIRA OS ITENS PARA A TRANSPORTADORA PEGÁ-LOS </h4>
                ';
                //Verificar se a pessoa clicou para abrir a solicitação
                if(isset($_POST['id_solicitacao_vistoria'])){
                $id_solicitacao = $conexao -> real_escape_string($_POST['id_solicitacao_vistoria']);

                $SelectcodSolicitacao = "SELECT cod_solicitacao FROM solicitacoes WHERE id_solicitacao = '$id_solicitacao' AND Situacao = 'Nas docas'";
                $executecodsolicitacao = $conexao -> query($SelectcodSolicitacao);

                if($executecodsolicitacao && $executecodsolicitacao -> num_rows > 0){
                    $row = $executecodsolicitacao -> fetch_assoc();

                    $cod_solicitcao = $row['cod_solicitacao'];
                }else{
                    $cod_solicitcao = "";
                }
                    
                $selectItens = "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '$id_solicitacao' AND codTurma ='{$_SESSION['codTurma']}'";
                $execute = $conexao -> query($selectItens);

                if($execute && $execute -> num_rows > 0){
                     
                    if($cod_solicitcao != ""){
                            echo '<h7>Número da solicitação: ' . htmlspecialchars($cod_solicitcao) . '</h7>';
                        } else{
                            echo '';
                        }
                        echo '
                        <div class="div-operacoes">
                            <table class="tabela" style="width:30vw;">
                                <tr>
                                    <td> Produtos </td>
                                    <td> UN </td>
                                    <td> QTD </td>
                                    <td> Observações </td>
                                    <td> Ações </td>
                                </tr>
                    ';
                    while($row = $execute -> fetch_assoc()){
                        
                        //guardar código do item solicitacao
                        $cod_itemSolicitacao = $row['cod_itemSolicitacao'];
                        $cod_produto = $row['cod_produto'];

                        $selectPicking = "SELECT * FROM itenspicking WHERE cod_itemSolicitacao = '$cod_itemSolicitacao' AND codTurma ='{$_SESSION['codTurma']}' AND Situacao = 'Nas docas'"; 
                        $executar = $conexao -> query($selectPicking);
                        

                        if($executar && $executar -> num_rows > 0){
                            while($rowItens = $executar -> fetch_assoc()){
                                
                                //Quandar cod_estoque
                                $cod_itemPicking = $rowItens['cod_itemPicking'];
                                $QuantidadeItemPicking = $rowItens['Quantidade'];

                                //Pesquisar produtos
                                $selectProdutos = "SELECT * FROM produtos WHERE cod_produto = '$cod_produto'";
                                $resultado = $conexao -> query($selectProdutos);
                                
                                if($resultado && $resultado -> num_rows > 0){
                                    while($rowPorduto = $resultado -> fetch_assoc()){
                                        $Nome = $rowPorduto['Nome'];
                                        $UN = $rowPorduto['UN'];
                                    }
                                }
                                $codigos_itens_picking[] = ['cod_item_picking' => $cod_itemPicking, 'observacao' => ''];
                            }
                        }else {
                            // Definindo variáveis padrão
                            $cod_itemPicking = "";
                            $QuantidadeItemPicking = "";
                            $Nome = "";
                            $UN = "";
                            $cod_solicitcao = "";
                        }
                        
                        echo '<tr>
                                <td>' . htmlspecialchars($Nome) . '</td>
                                <td>' . htmlspecialchars($UN) . '</td>
                                <td>' . htmlspecialchars($QuantidadeItemPicking) . '</td>
                                <td>
                                    <form class="form-observacao-solicitacao">
                                    <input type="text" name="observacao_solicitacao" style="display: block;" class="observacao">
                                </td>
                                <td style="display: flex;">
                                        <input type="hidden" name="cod_item_picking" value="'. htmlspecialchars($cod_itemPicking) . '" style="display: block;">
                                        <input type="submit" class="InputPego" name="PegarItem" value="OK" style="display: block;" cod_item_picking="' . $cod_itemPicking . '">
                                    </form>
                                </td>
                            </tr>';
                    }
                    //Forms para enviar os produtos selecionados para a tela de operação
                    echo '
                        </table>
                        <br>
                            <div style="display: flex; flex-direction:column; justify-content:center; align-itens:center;">
                                <form id="form-finalizar-solicitacao">
                                    <div style="display: flex;">
                                        <h7>QUAL A DOCA DE SAÍDA DESSES ITENS?</h7>
                                        <input type="text" name="doca_saida"class="doca-itens"  style="display: block; margin-left: 10px;" placeholder="Doca:">
                                        <form id="form-ok-geral">
                                            <input type="submit" id="okgeral" class="InputPego" name="okgeral" value="CONFERIR TUDO" style="width:300px; display:block; border-radius:5px; margin-left:5px;">
                                        <form>
                                    </div>
                                    <input type="hidden" name="id_solicitacao" value="' . htmlspecialchars($id_solicitacao) . '" style="display: block;">
                                    <input type="submit" id="EnviarExpedicao" name="EnviarExpedicao" value="Finalizar Expedição" style="display:block; margin-left:2vw;" class="irparaoperacao">
                                </form>
                            </div>
                    </div>
                    ';
                } else{
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
var tipousuario = "<?php echo $tipousuario; ?>";
var codigosItensPicking = <?php echo json_encode($codigos_itens_picking)?>;

$(document).ready(function() {
    $('.form-observacao-solicitacao').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 
        console.log(formData);  // Verifique se os dados do formulário estão corretos
        $.ajax({
            type: 'POST',
            url: 'function/vistoriaitemsolicitacao.php',
            data: formData,
            success: function(response) {
                console.log(response);
                var jsonResponse = JSON.parse(response);
                console.log(jsonResponse);  
                if (jsonResponse.success) {
                    alert(jsonResponse.message); 
                    var inputPego = document.getElementsByClassName('InputPego');

                    for (var i = 0; i < inputPego.length; i++) {
                        if (jsonResponse.Validacao == 1 && inputPego[i].getAttribute('cod_item_picking') == jsonResponse.cod_item_picking) {
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
    $('#form-finalizar-solicitacao').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'function/Finalizarsolicitacao.php',
            data: formData,
            success: function(response) {
                console.log(response);  // Verifique a resposta do servidor
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    alert(jsonResponse.message);
                    if(tipousuario == 'Professor'){
                        window.location.href = 'projetoprofessor.php';
                    }else{
                        window.location.href = 'projetoaluno.php';
                    }
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

// A função para lidar com o botão "OK para todos"
$(document).ready(function() {
    $('#form-ok-geral').submit(function(e) {
        e.preventDefault();

        // Atualize as observações dos itens na array
        $('.form-observacao-solicitacao input[name="observacao_solicitacao"]').each(function(index) {
            var observacao = $(this).val();
            if (observacao !== "") {
                codigosItensPicking[index]['observacao'] = observacao;
            }
        });

        // Envie a array atualizada para o servidor
        $.ajax({
            type: 'POST',
            url: 'function/okgeral.php',
            data: { codigosItensPicking: codigosItensPicking },
            dataType: 'json',
            success: function(response) {
                console.log(response);
                try {
                    if (response.success) {
                        alert(response.message);
                        var inputPego = document.getElementsByClassName('InputPego');

                        for (var i = 0; i < inputPego.length; i++) {
                                inputPego[i].style.backgroundColor = 'green';
                                inputPego[i].style.color = 'white';
                            }
                    } else {
                        alert('Erro ao atualizar a situação: ' + response.message);
                    }
                } catch (e) {
                    alert('Erro ao processar a resposta do servidor.');
                    console.error(e);
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