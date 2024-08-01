<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI ESTOQUE</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Projeto gerenciamento de estoque para o Senai de Itajaí-SC">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="shortcut icon" type="imagex/png" href="css/cssimg/logo.png"/>
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Bem Vindo de Volta!</h2>
                <p class="description description-primary">Para se manter conectado conosco</p>
                <p class="description description-primary">por favor faça login com suas informações pessoais</p>
                <button id="signin" class="btn btn-primary">LOGIN</button>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Criar Conta</h2>
                <p class="description description-second">Use seu e-mail para cadastro:</p>
                
                <?php
                    $error_message = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                                // Verifica se o email já está cadastrado
                                $SelectUsuarios = "SELECT * FROM usuarios WHERE email = '$email'";
                                $executeUsers = $conexao->query($SelectUsuarios);

                                if ($executeUsers && $executeUsers->num_rows > 0) {
                                    $error_message = "ESTE EMAIL JÁ ESTÁ SENDO UTILIZADO";
                                } else {
                                    // Verifica se a turma existe
                                    $SelectTurma = "SELECT * FROM turmas WHERE codTurma = '$turmausuario'";
                                    $executeTurma = $conexao->query($SelectTurma);

                                    if ($executeTurma && $executeTurma->num_rows == 0) {
                                        $error_message = "ESSA TURMA NÃO EXISTE";
                                    } else {
                                        $sql = "INSERT INTO `logistica`.`usuarios` (`nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`, `codTurma`)
                                                VALUES ('$nome', '$email', '$senha', '$data_entrada', 's', '$tipousuario', '$turmausuario')";

                                        if ($conexao->query($sql) === TRUE) {
                                            $conexao->close();
                                            header('Location: ../Paginas/aluno.php', true, 301);
                                            exit();
                                        } else {
                                            throw new Exception("Erro ao inserir dados: " . $conexao->error);
                                        }
                                    }
                                }
                            } catch (Exception $e) {
                                if ($conexao->errno == 1452) { // Código de erro para falha de chave estrangeira
                                    $error_message = 'Turma inválida';
                                } else {
                                    $error_message = 'Erro: ' . $e->getMessage();
                                }
                            }
                            $conexao->close();
                        }
                    }
                ?>

                <?php if (!empty($error_message)): ?>
                    <div class="error-message" style="color: red; font-size: 18px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form class="form" method="post" action="" id="formlogin" name="formlogin">
                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" placeholder="Nome" id="nomeUsuario" name="nomeUsuario" required>
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <select id="tipoUsuario" name="tipoUsuario" required>
                            <option>Selecione:</option>
                            <option>Aluno</option>
                            <option>Professor</option>
                        </select>
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="text" placeholder="Turma" id="turmaUsuario" name="turmaUsuario" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" placeholder="Email" id="emailUsuario" name="emailUsuario" required>
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" placeholder="Senha" id="senhaUsuario" name="senhaUsuario" required>
                    </label>
                    
                    <button class="btn btn-second">CADASTRAR</button>        
                </form>
            </div>
        </div>
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">Olá, amigo!</h2>
                <p class="description description-primary">Insira seus dados pessoais</p>
                <p class="description description-primary">e comece a jornada conosco</p>
                <button id="signup" class="btn btn-primary">CADASTRAR</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second">Login</h2>
                <p class="description description-second">Use sua conta de e-mail:
                </p>
                <form class="form" method="post" action="CadastroLogin/verificalogin.php" id="formverifica" name="formverifica">
                
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" placeholder="Email" id="emailUsuario" name="emailUsuario" required>
                    </label>
                
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" placeholder="Senha" id="senhaUsuario" name="senhaUsuario" required>
                    </label>
                    <button class="btn btn-second">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/index.js"></script>
</body>
</html>
