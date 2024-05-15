<html>
    <body>
		
		<?php
			// iniciar uma sessão
			session_start();
			
			$hostname = "127.0.0.1";
			$user = "root";
			$password = "";
			$database = "bancosenai";
		
			$conexao = new mysqli($hostname,$user,$password,$database);

			if ($conexao->connect_errno) {
				echo "Failed to connect to MySQL: " . $conexao->connect_error;
				exit();
			  } else {
			  
				// Escape user input to prevent SQL Injection
				$email = $conexao->real_escape_string($_POST['emailUsuario']);
				$senha = $conexao->real_escape_string($_POST['senhaUsuario']);
			  

				$sql = "SELECT `email`, `senha`, `tipousuario` FROM `cadastro` 
						WHERE `email` = '" . $email . "' 
						AND `senha` = '" . hash('sha256', $senha) . "' 
						AND ativo = 's';";
				$resultado = $conexao->query($sql);
			  
				if ($resultado->num_rows === 1) {
				  $row = $resultado->fetch_array();
				  $_SESSION['id'] = $row[0];
				  $_SESSION['nome'] = $row[1];
				  $_SESSION['tipousuario'] = $row[2];
				  $conexao->close();
			  
				  if ($row['tipousuario'] === 'Aluno') {
					header('Location: site.php', true, 301);
				  } else if ($row['tipousuario'] === 'Professor') {
					header('Location: site2.php', true, 301);
				  } else {
					echo "<p>Tipo de usuário inválido.</p>";
				  }
			  
				  exit();
				} else {
				  $conexao->close();
				  header('Location: index.php', true, 301);
				  exit();
				}
			  }
			  
		?>
	</body>
</html>