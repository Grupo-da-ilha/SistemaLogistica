<html>
    <body>
		
		<?php
session_start();

// Conexão com o banco de dados
$hostname = "127.0.0.1";
$user = "root";
$password = "root";
$database = "login";

$conexao = new mysqli($hostname, $user, $password, $database);

if ($conexao->connect_errno) {
    echo "Falha na conexão com o MySQL: " . $conexao->connect_error;
    exit();
} else {

    // Escape de caracteres para evitar SQL Injection
    $email = $conexao->real_escape_string($_POST['emailUsuario']);
    $senha = $conexao->real_escape_string($_POST['senhaUsuario']);


    if($tipousuario == "Aluno"){
      $sql = "SELECT `id`, `nome`, `email`, `tipousuario`, `data_entrada`, `ativo`, `senha` FROM `aluno` 
      WHERE `email` = '" . $email . "' 
      AND `senha` = '" . $senha . "' 
      AND ativo = 's';";

        $resultado = $conexao->query($sql);

        // Verificação de login
        if ($resultado->num_rows === 1) {
          $row = $resultado->fetch_array();

          // Armazenar informações do usuário na sessão
          $_SESSION['id'] = $row[0];
          $_SESSION['nome'] = $row[1];
          $_SESSION['email'] = $row[2];
          $_SESSION['senha'] = $row[3];
          $_SESSION['data_entrada'] = $row[4];
          $_SESSION['ativo'] = $row[5];
          $_SESSION['tipousuario'] = $row[6];
          $_SESSION['codTurma'] = $row[7];
          $conexao->close();

          // Redirecionar de acordo com o tipo de usuário
        if ($row['tipousuario'] === 'Aluno') {
              header('Location: ../Paginas/aluno.php', true, 301);
            } else {
              // Exibir alerta de login não autorizado
              echo "<script>alert('Acesso negado. Tipo de usuário inválido.');</script>";
              header('Location: ../index.php', true, 301);
            }
        } else{
          $conexao->close();

          // Mensagem de erro de login
          echo "<script>alert('Acesso negado, usuário inválido.');</script>";

          // Redirecionar após 10 segundos
          echo "<script>setTimeout(function() { window.location.href = '../index.php'; }, 100);</script>";
          exit();
        }
    } else{
      $sql = "SELECT `id`, `nome`, `email`, `tipousuario`, `data_entrada`, `ativo`, `senha` FROM `professor` 
      WHERE `email` = '" . $email . "' 
      AND `senha` = '" . $senha . "' 
      AND ativo = 's';";

        $resultado = $conexao->query($sql);

        // Verificação de login
        if ($resultado->num_rows === 1) {
          $row = $resultado->fetch_array();

          // Armazenar informações do usuário na sessão
          $_SESSION['id'] = $row[0];
          $_SESSION['nome'] = $row[1];
          $_SESSION['email'] = $row[2];
          $_SESSION['senha'] = $row[3];
          $_SESSION['data_entrada'] = $row[4];
          $_SESSION['ativo'] = $row[5];
          $_SESSION['tipousuario'] = $row[6];
          $_SESSION['codTurma'] = $row[7];
          $conexao->close();

          // Redirecionar de acordo com o tipo de usuário
          if ($row['tipousuario'] === 'Aluno') {
              header('Location: ../Paginas/aluno.php', true, 301);
            } else if ($row['tipousuario'] === 'Professor') {
              header('Location: ../Paginas/professor.php', true, 301);
            } else {
              // Exibir alerta de login não autorizado
              echo "<script>alert('Acesso negado. Tipo de usuário inválido.');</script>";
              header('Location: ../index.php', true, 301);
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
  }
		?>
	</body>
</html>