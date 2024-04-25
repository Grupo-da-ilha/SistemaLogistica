<html>	
    <body>
		<?php
			session_start();
			
			$hostname = "127.0.0.1";
			$user = "root";
			$password = "root";
			$database = "login";
		
			$conexao = new mysqli($hostname,$user,$password,$database);

			if ($conexao -> connect_errno) {
				echo "Failed to connect to MySQL: " . $conexao -> connect_error;
				exit();
			} else {
				// Evita caracteres epsciais (SQL Inject)
				$nome = $conexao -> real_escape_string($_POST['nomeUsuario']);
                $email = $conexao -> real_escape_string($_POST['emailUsuario']);
				$senha = $conexao -> real_escape_string($_POST['senhaUsuario']);
				$tipousuario = $conexao -> real_escape_string($_SESSION['tipoUsuario']);
				$turmausuario = $conexao -> real_escape_string($_POST['turmaUsuario']);

				if($tipousuario == "Aluno"){
					$sql = "INSERT INTO `login`.`alunos`
							(`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma` )
						VALUES
							('".$nome."', '".$email."', '".$senha."', '".date('Y-m-d')."', 's', '".$tipousuario."','".$turmausuario."');";

					$resultado = $conexao->query($sql);
				
					$conexao -> close();
					header('Location: ../Paginas/aluno.php', true, 301);

				} elseif($tipousuario == "Professor"){
					$sql = "INSERT INTO `login`.`professor`
							(`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma`)
					VALUES
							('".$nome."', '".$email."', '".$senha."', '".date('Y-m-d')."', 's', '".$tipousuario."', '".$turmausuario."');";

					$resultado = $conexao->query($sql);

					$conexao -> close();
					header('Location: ../Paginas/aluno.php', true, 301);
				}
			}
		?>
	</body>
</html>