<?php
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "login";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Falha na conexão com o MySQL: " . $conexao->connect_error;
    exit();
} else {

    if(isset($_POST['codAluno'])){

        $codAluno = $_POST['codAluno'];

        $new_password = $conexao->real_escape_string($_POST['nova_senha']);

        $sql="UPDATE alunos SET senha = '$new_password' WHERE alunos.codAluno = '$codAluno' ";

        $result = $conexao->query($sql);

        if ($conexao->query($sql) === TRUE) {
            header("Location: perfil_turma.php?codTurma=".$_SESSION['codigoTurma'], true, 301);
            $conexao ->close();
            exit();
        } else {
            echo "Erro ao executar o UPDATE: " . $conexao->error;
        }
        } else {
            echo "Dados inválidos recebidos.";
        }

    }
?>
