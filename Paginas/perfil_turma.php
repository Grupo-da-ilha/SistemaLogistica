<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI/PERFIL</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="SENAI Supply Chain Solutions">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/menuhorizontal.css"/>
    <link rel="stylesheet" href="../css/infoturma.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
    <?php
    // iniciar uma sessão
    session_start();
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";
        
    $conexao = new mysqli($hostname,$user,$password,$database);

    // Verifica se o código da turma está definido
    if(isset($_GET['codTurma'])) {
        $codTurma = $_GET['codTurma'];

        // Consulta SQL para selecionar os alunos da turma específica
        $sql="SELECT usuarios.id, usuarios.nome, usuarios.email, usuarios.senha 
              FROM usuarios
              WHERE usuarios.codTurma = '$codTurma'";

        $resultado = $conexao->query($sql);

        if($resultado->num_rows > 0) {
            // Turma encontrada, exibe os alunos
            echo '<header>
            <div class="container">
                <div class="main-horizontal">
                    <ul class="ul-main">
                        <li class="li-main">
                            <div class="teste">
                            <input id="main-button" type="checkbox" />
                                <label for="main-button">
                                    <div class="div-button-main">
                                        <span class="button-main"></span>
                                    </div>
                            </label>
                            <nav>
                                <ul class="ul-button">
                                <li class="li-vertical-menu"><a class="a-vertical-menu" href="">MENU</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="professor.php">MENU</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="perfilprofessor.php">PERFIL</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="ajudaprofessor.php">AJUDA</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">CONFIGURAÇÕES</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="sair.php">SAIR</a></li>
                                </ul>
                            </nav>
                                <div class="juntos">
                                    <img src="../css/cssimg/logo.png" style="max-width: 85px; max-height: 85px; margin-left: 20px; margin-top: 15px;">
                                    <h1>SENAI LOG</h1>
                                </div>
                                <h2>'.$_SESSION['nome'].'</h2>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
                <main>
                    <div class="container-prin">
                        <div class="alunos-turma">
                            <div class="titulo-turmas">
                                <h5>ALUNOS:</h5>
                            </div>
                            <form method="post" action="function/alterar_senha.php"> <!-- Formulário para enviar as novas senhas -->
                                <table class="table-alunos">
                                    <tr>
                                        <th>Nome:</th>
                                        <th>Email:</th>
                                        <th>Senha:</th>
                                        <th>Nova Senha:</th>
                                        <th>Ação:</th>
                                    </tr>';

            // Exibe as informações dos alunos da turma em uma tabela HTML
            while($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['senha'] . "</td>";
                // Adiciona campo de entrada para nova senha para cada usuário
                echo '<td><input id="novasenha" type="text" name="nova_senha['.$row['id'].']" placeholder="Nova Senha"></td>';
                // Adiciona botão para enviar alteração de senha para cada usuário
                echo '<td><button class="button-alterarsenha" type="submit" name="alterar_senha['.$row['id'].']">ALTERAR SENHA</button></td>';
                echo "</tr>";
            }

            echo '
                                </table>
                            </form>
                        </div>
                    </div>
                </main>';
        } else {
            // Não foram encontrados alunos para esta turma
            echo "Nenhum aluno encontrado para esta turma.";
        }
    } else {
        // Código da turma não definido
        echo "Código da turma não especificado.";
    }
?>
</body>
</html>
