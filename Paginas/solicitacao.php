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
    <link rel="stylesheet" href="../css/pedido.css"/>
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
    }else{
        if (isset($_POST['enviar_cod']) && !empty($_POST['cod_solicitacao'])) {
            $cod_solicitacao = $conexao->real_escape_string($_POST['cod_solicitacao']);
            $_SESSION['cod_solicitacao'] = $cod_solicitacao;
        }
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
            <div class="criar-pedido-container" style="height:68vh;">
                <div class="titulo-pedido">
                    <h3>CRIAR SOLICITAÇÃO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos" style="height:68vh; border-radius:20px 0 0 20px;">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>PEDIDO:</h5>
                                    <a href="criarpedido.php" class="button-pedidos">Criar Pedidos</a>
                                    <a href="meuspedidos.php" class="button-pedidos">Meus Pedidos</a>
                                <h5>SOLICITAÇÕES:</h5>
                                    <a href="minhassolicitacoes.php" class="button-pedidos">Minhas Solicitações</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container" style="height:68vh; width:70vw;">
                            <form action="" method="POST" class="criarpedidos">
                                    <h4>CRIAR:</h4>
                            <div class="options-criarpedido" style="height:53vh;">
                                <h5>CÓDIGO DA SOLICITAÇÃO:</h5>
                                <input type="text" name="codSolicitacao" style="display: block;" class="input-options-criar-pedido">
                                <h5>DESTINATÁRIO:</h5>
                                    <label class="label-input" for="">
                                        <i class="far fa-envelope icon-modify"></i>
                                        <select name="Destinatario" required style="display: block;" class="input-options-criar-pedido-select">
                                            <option class="options-label">Selecione:</option>
                                            <option class="options-label">BIC</option>
                                            <option class="options-label">Samsung</option>
                                            <option class="options-label">Quanta coisa</option>
                                        </select>
                                    </label>
                                        <h5>TRANSPORTADORA:</h5>
                                            <label class="label-input" for="">
                                                <i class="far fa-envelope icon-modify"></i>
                                                <select name="Transportadora" required style="display: block;" class="input-options-criar-pedido-select" id="Transp">
                                                    <option>Selecione:</option>
                                                    <option>Tac Transportes</option>
                                                    <option>Graédi Transportes</option>
                                                    <option>NSL Brasil</option>
                                                </select>
                                            </label>
                                    <div class="options-criarpedido-input">
                                        <input type="submit" name="enviar_solicitacao" value="CONFIRMAR SOLICITAÇÃO" style="display: block;" class="input-function-criar-pedido"> 
                                    </div> 
                                        <h5>NOME DO PRODUTO:</h5>
                                        <div style="display:flex; justify-content: space-between;">
                                            <input type="text" name="NomeProduto" id="NomeProduto" style="display: block;" class="input-options-consulta"> 
                                            <input type="text" name="NomeProdutoEstoque" id="NomeProdutoEstoque" style="display: block;" class="input-options-consulta"> 
                                        </div>
                                    <input type="submit" name="enviar_produto" value="ADICIONAR PRODUTO" style="display: block;" class="input-function-criar-pedido">
                                    <br>
                                    <a class="ahrefcadastrar" href="inventario.php"><input type="button" value="VER PRODUTOS ESTOCADOS" style="display:block"  id="verprodutoscadastrados" class="verprodutoscadastrados"></a>
                                </form>
                            </div>
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PRODUTOS:</h4>';?>
                                    <?php   

                                if (!isset($_SESSION['cod_solicitacao']) || empty($_SESSION['cod_solicitacao'])) {
                                    $_SESSION['cod_solicitacao'] = "";
                                } else {
                                    echo '';
                                }

                                if (empty($_SESSION['id_solicitacao'])) {
                                    $_SESSION['id_solicitacao'] = "";
                                } else {
                                    echo '';
                                }
                                
                                //Definindo data e horário atuais
                                date_default_timezone_set('America/Sao_Paulo');
                                $datahoje = date("Y-m-d H:i:s");

                                if (isset($_POST['enviar_solicitacao']) && !empty($_POST['codSolicitacao'])) {
                                    $cod_solicitacao = $conexao->real_escape_string($_POST['codSolicitacao']);
                                    $_SESSION['cod_solicitacao'] = $cod_solicitacao;

                                    $selectSolicitacoes = "SELECT * FROM solicitacoes WHERE cod_solicitacao= '$cod_solicitacao' AND codTurma ='{$_SESSION['codTurma']}'";
                                    $executar = $conexao->query($selectSolicitacoes);

                                    if ($executar->num_rows > 0) {
                                        $row = $executar->fetch_assoc();
                                        $codigo_solicitacao = $row['cod_solicitacao'];
                                        $idsolicitacao = $row['id_solicitacao'];
                                        $_SESSION['id_solicitacao'] = $idsolicitacao;
                                        echo "<h6>Alterando a solicitação com o seguinte código: " . htmlspecialchars($codigo_solicitacao) . "</h6>";

                                        $sql = "UPDATE solicitacoes SET Observacao = '', Situacao = 'Em criação', Doca = NULL, Doca_saida = NULL WHERE cod_solicitacao = '{$_SESSION['cod_solicitacao']}' AND codTurma = '{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
                                        $execute = $conexao->query($sql);
                                        
                                        if($execute){
                                            $selectItensSolicitacao = "SELECT * FROM itenssolicitacao WHERE cod_solicitacao = '$idsolicitacao'";
                                            $executar = $conexao -> query($selectItensSolicitacao);

                                            if($executar -> num_rows > 0){
                                                while($rowItem = $executar -> fetch_assoc()){
                                                    $Quantidade_espera = $rowItem['Quantidade_espera'];
                                                    $cod_itemSolicitacao = $rowItem['cod_itemSolicitacao'];
                                                    $sql = "UPDATE itenssolicitacao SET Quantidade = '0', Quantidade_espera = '$Quantidade_espera' WHERE cod_solicitacao = '$idsolicitacao' 
                                                    AND codTurma ='{$_SESSION['codTurma']}' AND cod_itemSolicitacao = '$cod_itemSolicitacao'";
                                                    $execute = $conexao -> query($sql);
                                                    if($execute){
                                                        $sql = "DELETE FROM nota_fiscal WHERE id_solicitacao = '$idsolicitacao'";
                                                        $execute = $conexao -> query($sql);

                                                        if($execute){
                                                            $sql = "DELETE FROM docas WHERE id_pedido = '$idpedido'";
                                                            $execute = $conexao -> query($sql);
                                                        }
                                                    }
                                                }
                                            }                 
                                        }
                                    } else {
                                        $Nome_destinatario = $conexao -> real_escape_string($_POST['Destinatario']);

                                        $selectCNPJDestinatario = "SELECT CNPJ FROM clientes WHERE Nome= '$Nome_destinatario'";
                                        $excuteDestinatario = $conexao -> query($selectCNPJDestinatario);

                                        if($excuteDestinatario && $excuteDestinatario -> num_rows > 0){
                                            $row = $excuteDestinatario->fetch_assoc();
                                            $_SESSION['CNPJCliente'] = $row['CNPJ'];

                                            $nomeTransp = $conexao->real_escape_string($_POST['Transportadora']);
                            
                                            $selectCNPJTransportadora = "SELECT CNPJ FROM transportadoras WHERE Nome = '$nomeTransp'";
                                            $execute = $conexao->query($selectCNPJTransportadora);

                                            if ($execute && $execute->num_rows > 0) {
                                                $row = $execute->fetch_assoc();
                                                $_SESSION['CNPJTransp'] = $row['CNPJ'];
                                                $sql = "INSERT INTO solicitacoes (cod_solicitacao, Observacao, Situacao, CNPJEmitente, CNPJ_Destinatario, CNPJ_Transportadora, Data_criacao, codTurma) 
                                                VALUES ('$cod_solicitacao', '', 'Em processamento', '03.774.819/0001-02', '{$_SESSION['CNPJCliente']}', '{$_SESSION['CNPJTransp']}', '$datahoje', '{$_SESSION['codTurma']}')";
                                                $conexao->query($sql);
                                                echo "<h6>Solicitacao criado com sucesso com o código: " . htmlspecialchars($cod_solicitacao) . "</h6>";
                                            } else {
                                                echo "<h6>Por favor, selecione a Transportadora</h6>";
                                            }

                                        }else {
                                            echo "<h6>Por favor, selecione o Fornecedor</h6>";
                                        }

                                    }
                                } elseif(!isset($_POST['enviar_solicitacao']) && empty($_POST['codSolicitacao'])) {

                                } else {
                                    echo 'Por favor preencha os campos ao lado'; 
                                }

                                // Adicionar o produto desejado na solicitação e adicionando no itenssolicitacao
                                if (isset($_POST['enviar_produto']) && !empty($_POST['NomeProduto'])) {
                                    $Nome_produto = $conexao->real_escape_string($_POST['NomeProduto']);

                                    $sql = "SELECT cod_produto FROM produtos WHERE Nome = '$Nome_produto'";
                                    $resultado = $conexao->query($sql);

                                    if ($resultado && $resultado->num_rows > 0) {
                                        $row = $resultado->fetch_assoc();
                                        $COD_produto = $row['cod_produto']; 

                                        $sql2 = "INSERT INTO itenssolicitacao (cod_produto, cod_solicitacao , Quantidade, Quantidade_espera, codTurma) VALUES ('$COD_produto', '{$_SESSION['id_solicitacao']}', 0, 0, '".$_SESSION['codTurma']."')";
                                        $resultado = $conexao->query($sql2);

                                        if (!$resultado) {
                                            echo "<h6>Erro ao adicionar produto ao pedido: " . htmlspecialchars($conexao->error) . "</h6>";
                                        }
                                    } else {
                                        echo "<h6>Produto não encontrado</h6>";
                                    }
                                }

                                $selectidSolicitacao = "SELECT * FROM solicitacoes WHERE cod_solicitacao = '".$_SESSION['cod_solicitacao']."' AND codTurma ='{$_SESSION['codTurma']}'";
                                $executar = $conexao->query($selectidSolicitacao);
                                
                                if ($executar->num_rows > 0) {
                                    $row = $executar->fetch_assoc();
                                    $_SESSION['id_solicitacao'] = $row['id_solicitacao'];
                                }

                                // Selecionando a solicitação pelo id, código da turma e código da solicitação
                                $selectSolicitacao = "SELECT * FROM solicitacoes WHERE cod_solicitacao = '{$_SESSION['cod_solicitacao']}' AND codTurma ='{$_SESSION['codTurma']}' AND id_solicitacao = '{$_SESSION['id_solicitacao']}'";
                                $executar = $conexao->query($selectSolicitacao);

                                if ($executar && $executar->num_rows > 0) {
                                    $Selectprodutos = "SELECT produtos.cod_produto, produtos.Nome, produtos.UN, itenssolicitacao.cod_itemSolicitacao, itenssolicitacao.Quantidade
                                        FROM produtos 
                                        LEFT JOIN itenssolicitacao ON produtos.cod_produto = itenssolicitacao.cod_produto 
                                        WHERE itenssolicitacao.cod_solicitacao = '{$_SESSION['id_solicitacao']}' ORDER BY produtos.Nome ASC";
                                    $resul = $conexao->query($Selectprodutos);

                                    if ($resul && $resul->num_rows > 0) {
                                        echo "<div class='main'>
                                                <div class='tablebox'>
                                                    <h7>Confira os produtos já adicionados à solicitação:</h7>
                                                    <table class='tabela'>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>UN</th>
                                                            <th>QTD</th>
                                                            <th>Delete</th>
                                                        </tr>";
                                        while ($row = $resul->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['Nome']) . "</td>
                                                    <td>" . htmlspecialchars($row['UN']) . "</td>
                                                    <td>
                                                        <form action=\"function/processoItensSolicitacao.php\" method=\"POST\">
                                                            <input type=\"hidden\" name=\"codigoItemSolicitacao\" value=\"" . $row['cod_itemSolicitacao'] . "\" style=\"display: block;\">
                                                            <input type=\"text\" name=\"QTD\" placeholder=\"" . $row['Quantidade'] . "\" style=\"display: block;\" class=\"input-informacao\">
                                                            <input type=\"submit\" name=\"AtualizarQTD\" value=\"ATUALIZAR\" style=\"display: block;\" class=\"input-informacao-atualizar\">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action=\"function/processoItensSolicitacao.php\" method=\"POST\" class=\"deletebox\">
                                                            <input type=\"hidden\" name=\"codigoItemSolicitacao\" value=\"" . $row['cod_itemSolicitacao'] . "\" style=\"display: block;\">
                                                            <input type=\"submit\" name=\"Excluir\" value=\"Delete\" style=\"display: block;\" class=\"input-informacao-delete\">
                                                        </form>
                                                    </td>
                                                </tr>";
                                        }
                                        echo "</table>";
                                        echo "<form action=\"function/processoItensSolicitacao.php\" method=\"POST\">
                                                <div class=\"input-finalizar-pedido\">
                                                    <input type=\"hidden\" name=\"codigoSolicitacao\" value=\"" . $_SESSION['id_solicitacao'] . "\" style=\"display: block;\">
                                                    <input type='hidden' value=\"Solicitação\" name=\"Tipo_nota\">
                                                    <textarea id=\"texto\" name=\"texto\" placeholder=\"Observações para a solicitação\" style=\"margin-top:15px;\"></textarea><br>
                                                    <input type=\"submit\" name=\"UpdateValor\" onclick=\"FinalizarPedido()\" value=\"Finalizar Solicitacao\" style=\"display: block;\" class=\"input-finalizar-pedido-button\">
                                                </div>
                                            </form>
                                        </div>
                                        </div>";
                                    } else {
                                        echo 'Nenhum produto adicionado ainda';
                                    }

                                    $conexao->close();
                                } else {
                                }
                            }
                        }
                                ?>                                          

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>'; 
                    ?>
<script>
    document.getElementById('NomeProduto').addEventListener('input', function() {
      var NomeProduto = this.value;

      if (NomeProduto.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'function/buscarProdutoEstoque.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('NomeProdutoEstoque').value = xhr.responseText;
          }
        };
        xhr.send('NomeProduto=' + encodeURIComponent(NomeProduto));
      } else {
        document.getElementById('NomeProdutoEstoque').value = '';
      }
    });
  </script>              
</body>
</html>