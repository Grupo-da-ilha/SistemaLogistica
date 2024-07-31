<?php
session_start();
header('Content-Type: application/json');

$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";
$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Falha na conexão com o banco de dados: ' . htmlspecialchars($conexao->connect_error)]);
    exit();
}

if (isset($_SESSION['Idprojeto'])) {
    $sql = "SELECT codTurma FROM projetos WHERE idprojeto = '".$_SESSION['Idprojeto']."'";
    $execute = $conexao->query($sql);

    if ($execute->num_rows > 0) {
        $row = $execute->fetch_assoc();
        $_SESSION['codTurma'] = $row['codTurma'];
    } else {
        echo json_encode(['success' => false, 'message' => 'Projeto não encontrado']);
        exit();
    }
}

if (isset($_POST['QTDEstoqueDisponivel']) && isset($_POST['Nome_produto'])) {
    $Nome_produto = $conexao->real_escape_string($_POST['Nome_produto']);
    $qtde_estoque = intval($_POST['QTDEstoqueDisponivel']); 
    
    //Selecionar cod_produto pelo Nome Digitado pela pessoa
    $SelectCodProduto = "SELECT * FROM produtos WHERE Nome='$Nome_produto'";
    $executarCodProduto = $conexao -> query($SelectCodProduto);

    if($executarCodProduto && $executarCodProduto -> num_rows > 0){
        $rowProdutos = $executarCodProduto -> fetch_assoc();
        $cod_produto = $rowProdutos['cod_produto'];
    }else{
        echo json_encode(['success' => false, 'message' => 'Não foi possível encontrar este prodtuo, verifique a escrita por favor!!']);
        exit();
    }

    $SelectItenSolicitacaoEstoque = "SELECT itensestoque.cod_estoque, itensestoque.Quantidade
        FROM produtos
        INNER JOIN itenspedido ON produtos.cod_produto = itenspedido.cod_produto
        INNER JOIN itensestoque ON itenspedido.cod_itenPedido = itensestoque.cod_itenpedido
        WHERE produtos.cod_produto = '$cod_produto'
        AND itensestoque.Situacao = 'No estoque'
        AND itensestoque.codTurma = '".$_SESSION['codTurma']."'
        AND itensestoque.Quantidade IS NOT NULL";

    $resultado = $conexao->query($SelectItenSolicitacaoEstoque);

    if ($resultado->num_rows > 0) {
        $posicoes_estoque = [];
        while ($row = $resultado->fetch_assoc()) {
            $cod_estoque = $row['cod_estoque'];
            $QTD_estocada = intval($row['Quantidade']); // Converte a quantidade para inteiro

            if ($qtde_estoque > $QTD_estocada) {
                $color = 'red';
            } elseif ($qtde_estoque == $QTD_estocada) {
                $color = 'green';
            } else {
                $color = 'blue';
            }

            $SelectPosicaoEstoque = "SELECT * FROM estoque WHERE cod_estoque = '$cod_estoque'";
            $executar = $conexao->query($SelectPosicaoEstoque);
            
            if ($executar && $executar->num_rows > 0) {
                $row = $executar->fetch_assoc();
                $andar = $row['Andar'];  // Converta para inteiro se necessário
                $apartamento = $row['Apartamento'];  // Converta para inteiro se necessário
                
                // Combine Andar e Apartamento em uma única string com um delimitador
                $posicao = $andar . "" . $apartamento;  
            } else {
                $posicao = 'Desconhecido';  // Valor padrão se não for encontrada a posição
            }
            
            $posicoes_estoque[] = [
                'cod_estoque' => $posicao, 
                'color' => $color,
                'quantidade' => $QTD_estocada
            ];
        }

        echo json_encode(['success' => true, 'positions' => $posicoes_estoque]);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Este produto não se apresenta estocado']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados insuficientes']);
    exit();
}

$conexao->close();
?>
