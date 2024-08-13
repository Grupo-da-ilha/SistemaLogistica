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
        if (isset($_POST['enviar_cod']) && !empty($_POST['cod_pedido'])) {
            $cod_pedido = $conexao->real_escape_string($_POST['cod_pedido']);
            $_SESSION['cod_pedido'] = $cod_pedido;
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
                    <a href="picking.php" class="functions-menu">PICKING</a>
                    <a href="expediçao.php" class="functions-menu">EXPEDIÇÃO</a>
                    <a href="relatorios.php" class="functions-menu">RELATÓRIOS</a>
                </li>
            </div>
            <div class="criar-pedido-container">
                <div class="titulo-pedido">
                    <h3>CRIAÇÃO DO PEDIDO</h3>    
                </div>
                <div class="info-total">
                    <div class="criar-pedido">
                        <div class="submenus-pedidos">
                            <h4> INFORMAÇÕES </h4>
                            <div class="info-pedido">
                                <h5>PEDIDOS:</h5>
                                    <a href="meuspedidos.php" class="button-pedidos">Meus Pedidos</a>
                                <h5>NOTA FISCAL:</h5>
                                    <a href="danfe.php" class="button-pedidos">Minhas DANFE</a>
                                <h5>SOLICITAÇÕES:</h5>
                                    <a href="solicitacao.php" class="button-pedidos">Cria Solicitacao</a>
                                    <a href="minhassolicitacoes.php" class="button-pedidos">Minhas Solicitações</a>
                            </div>
                        </div>
                        <div class="criar-pedidos-container">
                            <form action="criarpedido.php" method="POST" class="criarpedidos">
                                    <h4>CRIAR:</h4>
                            <div class="options-criarpedido">
                                <h5>COD PEDIDO:</h5>
                                <input type="text" name="codPedido" style="display: block;" class="input-options-criar-pedido">
                                <h5>FORNECEDOR:</h5>
                                    <label class="label-input" for="">
                                        <i class="far fa-envelope icon-modify"></i>
                                        <select name="Fabricante" required style="display: block;" class="input-options-criar-pedido-select">
                                            <option class="options-label">Selecione:</option>
                                            <option class="options-label">CIS</option>
                                            <option class="options-label">WEG</option>
                                            <option class="options-label">Tilibra</option>
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
                                        <input type="submit" name="enviar_pedido" value="CONFIRMAR PEDIDO" style="display: block;" class="input-function-criar-pedido"> 
                                    </div>

                                        <h5>COD PRODUTO:</h5>
                                        <div style="display:flex; justify-content: space-between;">
                                            <input type="text" name="codProduto" id="codProduto" style="display: block;" class="input-options-consulta"> 
                                            <input type="text" name="NomeProduto" id="NomeProduto" style="display: block;" class="input-options-consulta"> 
                                        </div>
                                    <input type="submit" name="enviar_produto" value="ADICIONAR PRODUTO" style="display: block;" class="input-function-criar-pedido"> 
                                    <a class="ahrefcadastrar" href="cadastrarprodutos.php"><input type="button" id="verprodutoscadastrados" class="verprodutoscadastrados" value="VER CADASTRAR PRODUTOS"></a>
                                </form>
                            </div>
                            <div class="options-pedido">
                                <div class="produtos-pedido">
                                    <h4>PRODUTOS:</h4>';?>
                                    <?php
                                            $hostname = "127.0.0.1";
                                            $user = "root";
                                            $password = "";
                                            $database = "logistica";

                                            $conexao = new mysqli($hostname, $user, $password, $database);

                                            if ($conexao->connect_errno) {
                                                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                                                exit();
                                            }else{    
                                                if (!isset($_SESSION['cod_pedido']) || empty($_SESSION['cod_pedido'])) {
                                                    $_SESSION['cod_pedido'] = "";
                                                } else {
                                                    echo '';
                                                }
                                            
                                                if (empty($_SESSION['idpedido'])) {
                                                    $_SESSION['idpedido'] = "";
                                                } else {
                                                    echo '';
                                                }

                                                    if (isset($_POST['enviar_pedido']) && !empty($_POST['codPedido'])) {
                                                        $cod_pedido = $conexao->real_escape_string($_POST['codPedido']);
                                                        $_SESSION['cod_pedido'] = $cod_pedido;
                                                        date_default_timezone_set('America/Sao_Paulo');
                                                        $datahoje = date("Y-m-d H:i:s");
                                                
                                                        $selectPedido = "SELECT * FROM pedido WHERE cod_pedido = '$cod_pedido' AND codTurma ='{$_SESSION['codTurma']}'";
                                                        $executar = $conexao->query($selectPedido);
                                                
                                                        if ($executar->num_rows > 0) {
                                                            $row = $executar->fetch_assoc();
                                                            $codigo_pedido = $row['cod_pedido'];
                                                            $idpedido = $row['id_pedido'];
                                                            $_SESSION['idpedido'] = $idpedido;
                                                            echo "<h6>Alterando o pedido com o seguinte código: " . htmlspecialchars($codigo_pedido) . "</h6>";
                                                
                                                            $sql = "UPDATE pedido SET Situacao = 'Em processamento', InformacaoAdicional = '', DataVenda = NULL WHERE cod_pedido = '{$_SESSION['cod_pedido']}' AND codTurma = '{$_SESSION['codTurma']}' 
                                                            AND id_pedido = '{$_SESSION['idpedido']}'";
                                                            $execute = $conexao->query($sql);
                                                            if($execute){
                                                                $selectItensPedido = "SELECT * FROM itenspedido WHERE cod_pedido = '$idpedido'";
                                                                $executar = $conexao -> query($selectItensPedido);

                                                                if($executar -> num_rows > 0){
                                                                    while($rowItem = $executar -> fetch_assoc()){
                                                                        $Quantidade_doca = $rowItem['Quantidade'];
                                                                        $coditempedido = $rowItem['cod_itenPedido'];
                                                                        $sql = "UPDATE itenspedido SET VistoriaConcluida = '0', Faltando = '0', Avariado = '0', Quantidade_doca = '$Quantidade_doca' WHERE cod_pedido = '$idpedido' 
                                                                        AND codTurma ='{$_SESSION['codTurma']}' AND cod_itenPedido = '$coditempedido'";
                                                                        $execute = $conexao -> query($sql);
                                                                        if($execute){
                                                                            $sql = "DELETE FROM nota_fiscal WHERE id_pedido = '$idpedido'";
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
                                                            $nomeFabri = $conexao->real_escape_string($_POST['Fabricante']);
                                                            $selectCNPJFabricante = "SELECT CNPJ FROM fabricantes WHERE Nome = '$nomeFabri'";
                                                            $execute = $conexao->query($selectCNPJFabricante);
                                                
                                                            if ($execute && $execute->num_rows > 0) {
                                                                $row = $execute->fetch_assoc();
                                                                $_SESSION['CNPJFabri'] = $row['CNPJ'];
                                                                $nomeTransp = $conexao->real_escape_string($_POST['Transportadora']);
                                                
                                                                $selectCNPJTransportadora = "SELECT CNPJ FROM transportadoras WHERE Nome = '$nomeTransp'";
                                                                $execute = $conexao->query($selectCNPJTransportadora);
                                                
                                                                if ($execute && $execute->num_rows > 0) {
                                                                    $row = $execute->fetch_assoc();
                                                                    $_SESSION['CNPJTransp'] = $row['CNPJ'];
                                                                    $sql = "INSERT INTO pedido (cod_pedido, DataVenda, ValorTotal, CNPJEmitente, CNPJ_Destinatario, CNPJ_Transportadora, Situacao, InformacaoAdicional, codTurma) 
                                                                            VALUES ('$cod_pedido', '$datahoje', 0.0, '{$_SESSION['CNPJFabri']}', '03.774.819/0001-02', '{$_SESSION['CNPJTransp']}', 'Em Processamento', '', '{$_SESSION['codTurma']}')";
                                                                    $conexao->query($sql);
                                                                    echo "<h6>Pedido criado com sucesso com o código: " . htmlspecialchars($cod_pedido) . "</h6>";
                                                                } else {
                                                                    echo "<h6>Por favor, selecione a Transportadora</h6>";
                                                                }
                                                            } else {
                                                                echo "<h6>Por favor, selecione o Fornecedor</h6>";
                                                            }
                                                        }
                                                    } elseif(!isset($_POST['enviar_pedido']) && empty($_POST['codPedido'])) {
                                                    }else{
                                                        echo 'Por favor preencha os campos ao lado'; 
                                                    }

                                            if (isset($_POST['enviar_produto']) && !empty($_POST['codProduto'])) {

                                                $cod_produto = $conexao->real_escape_string($_POST['codProduto']);
                                                $sql = "SELECT Nome, PrecoUNI, UN, NCM, PesoGramas, SKU FROM produtos WHERE cod_produto = '$cod_produto'";
                                                $result = $conexao->query($sql);

                                                if ($result && $result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $_SESSION['Nome'] = $row['Nome'];
                                                    $_SESSION['PrecoUnitario'] = $row['PrecoUNI'];
                                                    $_SESSION['Peso'] = $row['PesoGramas'];
                                                    $_SESSION['UN'] = $row['UN'];
                                                    $_SESSION['NCM'] = $row['NCM'];
                                                    $_SESSION['SKU'] = $row['SKU'];

                                                    $sql2 = "INSERT INTO itenspedido (cod_produto, cod_pedido, Quantidade, ValorUnitario, ValorTotal, codTurma) 
                                                            VALUES ('$cod_produto', '{$_SESSION['idpedido']}', 0, '{$_SESSION['PrecoUnitario']}', 0.0, '".$_SESSION['codTurma']."')";
                                                    $resultado = $conexao->query($sql2);

                                                    if (!$resultado) {
                                                        echo "<h6>Erro ao adicionar produto ao pedido: " . htmlspecialchars($conexao->error) . "</h6>";
                                                    }
                                                } else {
                                                    echo "<h6>Produto não encontrado.</h6>";
                                                }
                                            }
                                            
                                            $selectidPedido = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}'";
                                            $executar = $conexao->query($selectidPedido);
                                            
                                            if ($executar->num_rows > 0) {
                                                $row = $executar->fetch_assoc();
                                                $_SESSION['idpedido'] = $row['id_pedido'];
                                            }
                                            
                                            $selectPedido = "SELECT * FROM pedido WHERE cod_pedido = '".$_SESSION['cod_pedido']."' AND codTurma ='{$_SESSION['codTurma']}' AND id_pedido = '{$_SESSION['idpedido']}'";
                                            $executar = $conexao->query($selectPedido);

                                            if ($executar && $executar->num_rows > 0) {
                                            $sql3 = "SELECT produtos.cod_produto, produtos.Nome, produtos.PrecoUNI, produtos.UN, produtos.SKU, produtos.NCM, produtos.PesoGramas, itenspedido.Quantidade, itenspedido.cod_itenPedido, itenspedido.ValorTotal
                                                    FROM produtos 
                                                    LEFT JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto 
                                                    WHERE itenspedido.cod_pedido = '{$_SESSION['idpedido']}' ORDER BY produtos.Nome ASC";
                                            $resul = $conexao->query($sql3);

                                            if ($resul && $resul->num_rows > 0) {
                                                $valorTotalPedido = 0;
                                                echo "<div class='main'>
                                                        <div class='tablebox'>
                                                            <h7>Confira os produtos já adicionados ao pedido:</h7>
                                                            <table class='tabela'>
                                                                <tr>
                                                                    <th>Nome</th>
                                                                    <th>UN</th>
                                                                    <th>QTD</th>
                                                                    <th>R$/unit</th>
                                                                    <th>NCM</th>
                                                                    <th>SKU</th>
                                                                    <th>Valor total</th>
                                                                    <th>Delete</th>
                                                                </tr>";
                                                while ($row = $resul->fetch_assoc()) {
                                                    $valorTotalItem = $row['Quantidade'] * $row['PrecoUNI'];
                                                    $valorTotalPedido += $valorTotalItem;
                                                    $_SESSION['ValorTotalPedido'] = $valorTotalPedido;

                                                    $sql = "UPDATE `pedido` SET ValorTotal = '" . $valorTotalPedido . "' WHERE id_pedido = '" . $_SESSION['idpedido'] . "'";
                                                    $resultado = $conexao->query($sql);
                                                    echo "<tr>
                                                            <td>" . htmlspecialchars($row['Nome']) . "</td>
                                                            <td>" . htmlspecialchars($row['UN']) . "</td>
                                                            <td>
                                                                <form action=\"function/processoItens.php\" method=\"POST\">
                                                                    <input type=\"hidden\" name=\"codigoItemPedido\" value=\"" . $row['cod_itenPedido'] . "\" style=\"display: block;\">
                                                                    <input type=\"hidden\" name=\"valorUnitario\" value=\"". $row['PrecoUNI'] ."\" style=\"display: block;\">
                                                                    <input type=\"text\" name=\"QTD\" placeholder=\"" . $row['Quantidade'] . "\" style=\"display: block;\" class=\"input-informacao\">
                                                                    <input type=\"submit\" name=\"AtualizarQTD\" value=\"ATUALIZAR\" style=\"display: block;\" class=\"input-informacao-atualizar\">
                                                                </form>
                                                            </td>
                                                            <td>" . htmlspecialchars($row['PrecoUNI']) . "</td>
                                                            <td>" . htmlspecialchars($row['NCM']) . "</td>
                                                            <td>" . htmlspecialchars($row['SKU']) . "</td>
                                                            <td><h8>".$valorTotalItem."</h8></td>
                                                            <td>
                                                                <form action=\"function/processoItens.php\" method=\"POST\" class=\"deletebox\">
                                                                    <input type=\"hidden\" name=\"codigoItemPedido\" value=\"" . $row['cod_itenPedido'] . "\" style=\"display: block;\">
                                                                    <input type=\"submit\" name=\"Excluir\" value=\"Delete\"  style=\"display: block;\" class=\"input-informacao-delete\">
                                                                </form>
                                                            </td>
                                                        </tr>";
                                                }

                                                echo "</table> 
                                                <h6 style=\"margin-top:10px\">Valor Total: " . htmlspecialchars($valorTotalPedido)."</h6>";
                                                echo"
                                                        <form action=\"function/processoItens.php\" method=\"POST\">
                                                            <div class=\"input-finalizar-pedido\">
                                                                <input type=\"hidden\" name=\"codigoPedido\" value=\"" .$_SESSION['cod_pedido']. "\" style=\"display: block;\">
                                                                <input type='hidden' value=\"Pedido\" name=\"Tipo_nota\">
                                                                <textarea id=\"texto\" name=\"texto\" placeholder=\"Informações adicionais para sua DANFE\"></textarea><br>
                                                                <input type=\"datetime-local\" id=\"texto\" name=\"DataEntrega\" placeholder=\"Data de Entrega:\" style=\"display: block;\">
                                                                <input type=\"submit\" name=\"UpdateValor\" onclick=\"FinalizarPedido()\" value=\"Finalizar Pedido\" style=\"display: block;\" class=\"input-finalizar-pedido-button\">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>";
                                            } else {
                                                echo'Nenhum produto adicionado ainda';
                                            }

                                            $conexao->close();
                                    } else{
                                        echo 'Pedido ainda não criado nessa turma';
                                    }
                                }
                                    
                            }
                        }
echo'

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
    document.getElementById('codProduto').addEventListener('input', function() {
      var codProduto = this.value;

      if (codProduto.length > 0) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'function/buscarProduto.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('NomeProduto').value = xhr.responseText;
          }
        };
        xhr.send('codProduto=' + encodeURIComponent(codProduto));
      } else {
        document.getElementById('NomeProduto').value = '';
      }
    });
  </script>              
</body>
</html>