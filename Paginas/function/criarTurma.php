<html>	
    <body>
		<?php
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
				$nome = $conexao -> real_escape_string($_POST['nomeTurma']);
                $codigo = $conexao -> real_escape_string($_POST['codTurma']);

				//Definindo o fuso horário, para a função date buscar o horário correto
				date_default_timezone_set('America/Sao_Paulo');
				$data_entrada = date("Y-m-d H:i:s");

				$sql = "INSERT INTO `login`.`turma`
							(`codTurma`, `nome`, `data_criacao`)
						VALUES
							('".$codigo."', '".$nome."', '".$data_entrada."');";

				$resultado = $conexao->query($sql);
				
				$conexao -> close();
				header('Location: ../Paginas/turmas.php', true, 301);
			}
		?>
	</body>
<html>	
