<html>    
    <body>
        <?php
            $hostname = "127.0.0.1";
            $user = "root";
            $password = "";
            $database = "logistica";
        
            $conexao = new mysqli($hostname, $user, $password, $database);

            if ($conexao->connect_errno) {
                echo "Failed to connect to MySQL: " . $conexao->connect_error;
                exit();
            } else {
                try {
                    // Evita caracteres especiais (SQL Injection)
                    $nome = $conexao->real_escape_string($_POST['nomeUsuario']);
                    $email = $conexao->real_escape_string($_POST['emailUsuario']);
                    $senha = $conexao->real_escape_string($_POST['senhaUsuario']);
                    $tipousuario = $conexao->real_escape_string($_POST['tipoUsuario']);
                    $turmausuario = $conexao->real_escape_string($_POST['turmaUsuario']);

                    // Definindo o fuso horário, para a função date buscar o horário correto
                    date_default_timezone_set('America/Sao_Paulo');
                    $data_entrada = date("Y-m-d H:i:s");

                    $sql = "INSERT INTO `logistica`.`usuarios`
                                (`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma`)
                            VALUES
                                ('".$nome."', '".$email."', '".$senha."', '".$data_entrada."', 's', '".$tipousuario."','".$turmausuario."');";

                    if ($conexao->query($sql) === TRUE) {
                        $conexao->close();
                        header('Location: ../Paginas/aluno.php', true, 301);
                        exit();
                    } else {
                        throw new Exception("Erro ao inserir dados: " . $conexao->error);
                    }
                } catch (Exception $e) {
                    if ($conexao->errno == 1452) { // Código de erro para falha de chave estrangeira
                        echo 'Turma inválida';
                    } else {
                        echo 'Erro: ';
                    }
                }

                $conexao->close();
            }
        ?>
    </body>
</html>
