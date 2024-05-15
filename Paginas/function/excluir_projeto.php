<<<<<<< HEAD
<?php
// excluir_projeto.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o ID do projeto foi recebido
    if (isset($_POST['projeto_id'])) {
        // Obter o ID do projeto a partir dos dados recebidos
        $projetoId = $_POST['projeto_id'];

        // Realizar a exclusão do projeto no banco de dados
        $conexao = new mysqli("127.0.0.1", "root", "", "logistica");

        // Verificar a conexão
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Consulta SQL para excluir o projeto específico usando prepared statement
        $sql_excluir = "DELETE FROM projetos WHERE idprojeto = ?";

        // Preparar a declaração
        $stmt = $conexao->prepare($sql_excluir);

        // Verificar se a preparação da declaração foi bem-sucedida
        if ($stmt) {
            // Vincular o parâmetro e executar a declaração
            $stmt->bind_param("i", $projetoId);
            if ($stmt->execute()) {
                // Sucesso ao excluir o projeto
                echo "Projeto excluído com sucesso";
            } else {
                // Erro ao executar a declaração
                echo "Erro ao excluir projeto: " . $stmt->error;
            }
            // Fechar a declaração
            $stmt->close();
        } else {
            // Erro na preparação da declaração
            echo "Erro ao preparar declaração: " . $conexao->error;
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        // ID do projeto não foi recebido
        echo "ID do projeto não fornecido";
    }
} else {
    // Método de solicitação inválido
    echo "Método de solicitação inválido";
}
?>
=======
<?php
// excluir_projeto.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o ID do projeto foi recebido
    if (isset($_POST['projeto_id'])) {
        // Obter o ID do projeto a partir dos dados recebidos
        $projetoId = $_POST['projeto_id'];

        // Realizar a exclusão do projeto no banco de dados
        $conexao = new mysqli("127.0.0.1", "root", "", "logistica");

        // Verificar a conexão
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Consulta SQL para excluir o projeto específico usando prepared statement
        $sql_excluir = "DELETE FROM projetos WHERE idprojeto = ?";

        // Preparar a declaração
        $stmt = $conexao->prepare($sql_excluir);

        // Verificar se a preparação da declaração foi bem-sucedida
        if ($stmt) {
            // Vincular o parâmetro e executar a declaração
            $stmt->bind_param("i", $projetoId);
            if ($stmt->execute()) {
                // Sucesso ao excluir o projeto
                echo "Projeto excluído com sucesso";
            } else {
                // Erro ao executar a declaração
                echo "Erro ao excluir projeto: " . $stmt->error;
            }
            // Fechar a declaração
            $stmt->close();
        } else {
            // Erro na preparação da declaração
            echo "Erro ao preparar declaração: " . $conexao->error;
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        // ID do projeto não foi recebido
        echo "ID do projeto não fornecido";
    }
} else {
    // Método de solicitação inválido
    echo "Método de solicitação inválido";
}
?>
>>>>>>> fd667184b36f455bdcaefa5c8245afe403ad32ed
