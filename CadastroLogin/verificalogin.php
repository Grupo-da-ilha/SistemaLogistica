<?php
session_start();

// Conexão com o banco de dados
$hostname = "127.0.0.1";
$user = "root";
$password = "";
$database = "login";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Falha na conexão com o MySQL: " . $conexao->connect_error;
    exit();
} else {

    // Escape de caracteres para evitar SQL Injection
    $email = $conexao->real_escape_string($_POST['emailUsuario']);
    $senha = $conexao->real_escape_string($_POST['senhaUsuario']);

    $sql = "SELECT `codProf`, `nome`, `email`, `tipousuario`, `data_entrada`, `ativo`, `senha` FROM " .$_SESSION['usertype']. "
      WHERE `email` = '" . $email . "' 
      AND `senha` = '" . $senha . "' 
      AND ativo = 's';";

    $resultado = $conexao->query($sql);
        if ($resultado->num_rows === 1) {
          $row = $resultado->fetch_array();

          // Armazenar informações do usuário na sessão
          $_SESSION['id'] = $row['id'];
          $_SESSION['nome'] = $row['nome'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['senha'] = $row['senha'];
          $_SESSION['data_entrada'] = $row['data_entrada'];
          $_SESSION['ativo'] = $row['ativo'];
          $_SESSION['tipousuario'] = $row['tipousuario'];
          $_SESSION['codTurma'] = $row['codTurma'];

          $conexao->close();

          // Redirecionar de acordo com o tipo de usuário
          if ($_SESSION['tipousuario'] === 'alunos') {
              header('Location: ../Paginas/aluno.php', true, 301);
              exit();
          } elseif ($_SESSION['tipousuario'] === 'professor') {
              header('Location: ../Paginas/professor.php', true, 301);
              exit();
          } else {
              // Exibir alerta de login não autorizado
              echo "Acesso negado. Tipo de usuário inválido.";
              header('Location: ../index.php', true, 301);
              exit();
          }
      } else{
        $conexao->close();

        // Mensagem de erro de login
        echo "<script>alert('Acesso negado, usuário inválido.');</script>";

        // Redirecionar após 10 segundos
        echo "<script>setTimeout(function() { window.location.href = '../index.php'; }, 100);</script>";
        exit();
      }
  }
?>
