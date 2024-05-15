<html>	
    <body>
		<?php
			session_start();
			
			$hostname = "127.0.0.1";
			$user = "root";
			$password = "";
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
				$tipousuario = $conexao -> real_escape_string($_POST['tipoUsuario']);
				$turmausuario = $conexao -> real_escape_string($_POST['turmaUsuario']);


				//Definindo o fuso horário, para a função date buscar o horário correto
				date_default_timezone_set('America/Sao_Paulo');
				$data_entrada = date("Y-m-d H:i:s");

				if($tipousuario == "alunos"){
					$sql = "INSERT INTO `login`.`alunos`
							(`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma`)
						VALUES
							('".$nome."', '".$email."', '".$senha."', '".$data_entrada."', 's', '".$tipousuario."', '".$turmausuario."');";

					$resultado = $conexao->query($sql);
				
					$conexao -> close();
					header('Location: ../index.php', true, 301);

				} elseif($tipousuario == "professor"){
					$sql = "INSERT INTO `login`.`professor`
							(`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma`)
					VALUES
							('".$nome."', '".$email."', '".$senha."', '".$data_entrada."', 's', '".$tipousuario."', '".$turmausuario."');";

					$resultado = $conexao->query($sql);

					$conexao -> close();
					header('Location: ../index.php', true, 301);
				}
			}
		?>
	</body>
</html>