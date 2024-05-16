
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
session_start();
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "logistica";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['alterar_senha'])) {
        // Loop pelos dados enviados para alterar a senha de cada usuário
        foreach ($_POST['nova_senha'] as $idAluno => $novaSenha) {
            // Verifica se a senha enviada não está vazia
            if (!empty($novaSenha)) {
                // Aqui você deve implementar a lógica para atualizar a senha no banco de dados
                
                // Query SQL para atualizar a senha do aluno específico
                $sqlUpdate = "UPDATE cadastro SET senha = '$novaSenha' WHERE id = '$idAluno'";
                
                // Executa a query
                if ($conexao->query($sqlUpdate) === TRUE) {
                    echo "Senha atualizada com sucesso para o aluno com ID: " . $idAluno . "<br>";
                } else {
                    echo "Erro ao atualizar a senha: " . $conexao->error;
                }
            }
        }
    }
}

// Redireciona de volta para a página anterior após alterar as senhas
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
