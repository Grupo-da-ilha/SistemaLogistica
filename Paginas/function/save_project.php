<?php
session_start();

$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

if (isset($_POST['person_id']) && isset($_POST['project_name']) && isset($_POST['project_class'])) {
    $personId = $_POST['person_id'];
    $projectName = $_POST['project_name'];
    $projectClass = $_POST['project_class'];

    // Verificando o recebimento dos dados
    error_log("Dados recebidos: person_id=$personId, project_name=$projectName, project_class=$projectClass");

    $personId = $conexao->real_escape_string($personId);
    $projectName = $conexao->real_escape_string($projectName);
    $projectClass = $conexao->real_escape_string($projectClass);

    $checkQuery = "SELECT * FROM turmas WHERE codTurma = '$projectClass'";
    $checkResult = $conexao->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        $sql = "INSERT INTO projetos (codTurma, nome) VALUES ('$projectClass', '$projectName')";
        if ($conexao->query($sql) === TRUE) {
            $last_id = $conexao->insert_id;
            
            $sqlSelect = "SELECT codTurma FROM projetos WHERE idprojeto = '$last_id'";
            $result = $conexao->query($sqlSelect);

            if ($result && $result->num_rows > 0) {
                $rowProjeto = $result->fetch_assoc();
                $_SESSION['Idprojeto'] = $last_id;
                $_SESSION['codTurma'] = $rowProjeto['codTurma'];
                echo "Projeto salvo com sucesso!";
            } else {
                echo "Erro ao recuperar o projeto!";
            }
        } else {
            echo "Erro ao salvar o projeto: " . $conexao->error;
        }
    } else {
        http_response_code(400);
        echo "Erro: Código da turma inválido!";
    }
} else {
    http_response_code(400);
    echo "Erro: Dados incompletos!";
}

$conexao->close();
?>
