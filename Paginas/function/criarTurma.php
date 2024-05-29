<html>	
    <body>
		<?php
			$hostname = "127.0.0.1";
			$user = "root";
			$password = "";
			$database = "logistica";
		
			$conexao = new mysqli($hostname,$user,$password,$database);

			if ($conexao -> connect_errno) {
				echo "Failed to connect to MySQL: " . $conexao -> connect_error;
				exit();
			} else {
				// Evita caracteres epsciais (SQL Inject)
				$nome = $conexao -> real_escape_string($_POST['nomeTurma']);
                $codigo = $conexao -> real_escape_string($_POST['codTurma']);

				date_default_timezone_set('America/Sao_Paulo'); 
				$datahoje = date("Y-m-d H:i:s");

				$sql = "INSERT INTO `logistica`.`turmas`
							(`nomeTurma`, `codTurma`, `data_turma`)
						VALUES
							('".$nome."', '".$codigo."', '".$datahoje."');";

				$resultado = $conexao->query($sql);
				
				$conexao -> close();
				header('Location: ../turmas.php', true, 301);
			}
		?>
	</body>
</html>