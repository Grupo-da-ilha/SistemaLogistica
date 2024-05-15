<<<<<<< HEAD
<?php
// Iniciar a sessão
session_start();

$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

// Criar a conexão
$conexao = new mysqli($hostname, $user, $password, $database);

// Verificar a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Verificar se os dados foram recebidos corretamente
if (isset($_POST['person_id']) && isset($_POST['project_name'])) {
    $personId = $_POST['person_id'];
    $projectName = $_POST['project_name'];

    // Prevenir injeção de SQL
    $personId = $conexao->real_escape_string($personId);
    $projectName = $conexao->real_escape_string($projectName);

    // Verificar se o ID do aluno existe na tabela "cadastro"
    $checkQuery = "SELECT * FROM cadastro WHERE id = '$personId'";
    $checkResult = $conexao->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Inserir os dados no banco de dados
        $sql = "INSERT INTO projetos (Id, nome) VALUES ('$personId', '$projectName')";

        if ($conexao->query($sql) === TRUE) {
            echo "Projeto salvo com sucesso!";
        } else {
            echo "Erro ao salvar o projeto: " . $conexao->error;
        }
    } else {
        echo "Erro: ID de aluno inválido!";
    }
} else {
    echo "Erro: Dados incompletos!";
}

// Fechar a conexão
$conexao->close();
?>
=======
<?php
// Iniciar a sessão
session_start();

$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

// Criar a conexão
$conexao = new mysqli($hostname, $user, $password, $database);

// Verificar a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Verificar se os dados foram recebidos corretamente
if (isset($_POST['person_id']) && isset($_POST['project_name'])) {
    $personId = $_POST['person_id'];
    $projectName = $_POST['project_name'];

    // Prevenir injeção de SQL
    $personId = $conexao->real_escape_string($personId);
    $projectName = $conexao->real_escape_string($projectName);

    // Verificar se o ID do aluno existe na tabela "cadastro"
    $checkQuery = "SELECT * FROM cadastro WHERE id = '$personId'";
    $checkResult = $conexao->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Inserir os dados no banco de dados
        $sql = "INSERT INTO projetos (Id, nome) VALUES ('$personId', '$projectName')";

        if ($conexao->query($sql) === TRUE) {
            echo "Projeto salvo com sucesso!";
        } else {
            echo "Erro ao salvar o projeto: " . $conexao->error;
        }
    } else {
        echo "Erro: ID de aluno inválido!";
    }
} else {
    echo "Erro: Dados incompletos!";
}

// Fechar a conexão
$conexao->close();
?>
>>>>>>> fd667184b36f455bdcaefa5c8245afe403ad32ed
