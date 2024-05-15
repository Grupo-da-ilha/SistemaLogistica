<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI/MENU</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="SENAI Supply Chain Solutions">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/turmas.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
    <!--<script>
        function verMais(codTurma) {
            window.location.href = "perfil_turma.php?codTurma=" + codTurma;
        }

        function deletarTurma(codTurma) {
        if (confirm("Tem certeza que deseja excluir esta turma e todos os seus cadastros?")) {
            console.log("Excluindo turma com codTurma:", codTurma);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deletarTurma.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    console.log("Resposta do servidor:", xhr.responseText);
                    if (xhr.status === 200) {
                        // Atualize a página após a exclusão
                        window.location.reload();
                    } else {
                        alert('Erro ao excluir turma');
                    }
                }
            };
            xhr.send("codTurma=" + codTurma);
        }
    }
    </script>-->
</head>
<body>
<?php
    // iniciar uma sessão
    session_start();

    if (empty($_SESSION['nome'])){
        header('Location: sair.php');
        exit();
    } else {

        echo ' <header>
            <div class="container">
                <div class="main-horizontal">
                    <ul class="ul-main">
                        <li class="li-main">
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
                        </li>
                        <li class="li-main">
                            <h1>SENAI SCP</h1>
                            <h2>'.$_SESSION['nome'].'</h2>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main>
            <div class="container-prin">
                <div class="container-turmas">
                    <div class="criar-turmas">
                        <form class="form" method="post" action="../turmasSenai/criarTurma.php" id="formturma" name="formturma">
                            <div class="titulo-criar-turmas">
                                <h3>CRIAR TURMA</h3>
                            </div>
                            <div class="form-criar-turma">
                                <div class="inpu-criar-turma">
                                    <h4>Nome da Turma:</h4>
                                    <input type="text" placeholder="Nome:" id="nomeTurma" name="nomeTurma" required>
                                </div>
                                <div class="inpu-criar-turma">
                                    <h4>Código da Turma:</h4>
                                    <input type="text" placeholder="Código:" id="codTurma" name="codTurma" required>
                                </div>
                                <div class="inpu-criar-turma">
                                    <button class="button-criar-turma">CRIAR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="turmas-criadas">';

                //Conexão com a database
                $hostname = "127.0.0.1";
                $user = "root";
                $password = "";
                $database = "login";

                //criando conexão com o banco de dados
                $conexao = new mysqli($hostname, $user, $password, $database);

                if ($conexao->connect_errno) {
                    echo "Falha na conexão com o MySQL: " . $conexao->connect_error;
                    exit();
                }else
                //criando a consulta para puxar as informações da turma, contar a quantidade de alunos e juntar as tabelas
                $sql = "SELECT turma.codTurma, turma.nome, COUNT(alunos.codAluno) AS total_alunos, turma.data_criacao
                        FROM turma
                        INNER JOIN alunos ON turma.codTurma = alunos.codTurma
                        GROUP BY turma.codTurma, turma.nome, turma.data_criacao";

                $result = $conexao->query($sql);

                if (!$result) {
                    echo "Error: " . $conexao->error;
                } else {
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                                <div class=\"card-turmas\">
                                    <div class=\"delete-div\">
                                        <button class=\"delete-input\" onclick=\"deletarTurma('".$row["codTurma"]."')\">X</button>
                                    </div>
                                    <div class=\"nome-turmas\">
                                        <h5>". $row["nome"] ."</h5>
                                    </div>
                                    <div class=\"info-turmas\">
                                        <h6>Código: ". $row["codTurma"] ."</h6>
                                        <h6>Alunos matriculados: ". $row["total_alunos"] ."</h6>
                                        <h6>Data: ". $row["data_criacao"] ."</h6>
                                        <div class=\"vermaisdiv\">
                                            <form action=\"perfil_turma.php\" method=\"POST\" >
                                                <button class=\"vermais\">
                                                    <input type=\"submit\" name=\"Enviar\" value=\"VER MAIS\">
                                                    <input type=\"hidden\" name=\"codTurma\" value=\"" . $row['codTurma'] . "\">
                                                    VER MAIS
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    } else {
                        echo "<p>Nenhuma turma encontrada.</p>";
                    }
                }

                // Close the connection
                $conexao->close();

            echo '</div>
                </div>
            </div>
        </main>'; 
    }
?>
</body>
</html>
