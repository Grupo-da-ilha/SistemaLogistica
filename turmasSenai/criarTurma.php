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

				$sql = "INSERT INTO `logistica`.`turmas`
							(`nomeTurma`, `codTurma`)
						VALUES
							('".$nome."', '".$codigo."');";

				$resultado = $conexao->query($sql);
				
				$conexao -> close();
				header('Location: ../Paginas/turmas.php', true, 301);
			}
		?>
	</body>
</html>