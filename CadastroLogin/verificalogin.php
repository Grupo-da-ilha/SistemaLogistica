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

    // Escape de caracteres para evitar SQL Injection e criando as variáveis para armazenar as informações dos inputs
    $email = $conexao->real_escape_string($_POST['emailUsuario']);
    $senha = $conexao->real_escape_string($_POST['senhaUsuario']);
    $tipo_usuario = $conexao->real_escape_string($_POST['tipoUsuario']);

    //Criando if/else para fazer a consulta e verificar a senha e usuario na tabela correta
    if($tipo_usuario == "professor"){
      $sql = "SELECT `codProf`, `nome`, `email`, `data_entrada`, `tipousuario`, `ativo`, `senha` FROM " .$tipo_usuario. "
      WHERE `email` = '" . $email . "' 
      AND `senha` = '" . $senha . "' 
      AND ativo = 's';";

      $resultado = $conexao->query($sql);
          if ($resultado->num_rows === 1) {
            $row = $resultado->fetch_array();

            // Armazenar informações do usuário na sessão
            $_SESSION['id'] = $row['codProf'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['senha'] = $row['senha'];
            $_SESSION['data_entrada'] = $row['data_entrada'];
            $_SESSION['ativo'] = $row['ativo'];
            $_SESSION['tipousuario'] = $row['tipousuario'];
            $_SESSION['codTurma'] = $row['codTurma'];

            header('Location: ../Paginas/professor.php');
            exit();
            $conexao->close();
            
          }else{
            echo "Acesso negado. Tipo de usuário inválido.";
            header('Location: ../index.php', true, 301);
            exit();
          }
    }elseif($tipo_usuario == "alunos"){
      $sql = "SELECT `codAluno`, `nome`, `email`, `data_entrada`, `tipousuario`, `ativo`, `senha` FROM " .$tipo_usuario. "
      WHERE `email` = '" . $email . "' 
      AND `senha` = '" . $senha . "' 
      AND ativo = 's';";

      $resultado = $conexao->query($sql);
          if ($resultado->num_rows === 1) {
            $row = $resultado->fetch_array();

            // Armazenar informações do usuário na sessão
            $_SESSION['id'] = $row['codAluno'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['senha'] = $row['senha'];
            $_SESSION['data_entrada'] = $row['data_entrada'];
            $_SESSION['ativo'] = $row['ativo'];
            $_SESSION['tipousuario'] = $row['tipousuario'];
            $_SESSION['codTurma'] = $row['codTurma'];

            header('Location: ../Paginas/aluno.php');
            exit();
            $conexao->close();  
        }else {
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
