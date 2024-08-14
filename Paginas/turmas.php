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
    <link rel="stylesheet" href="../css/menuhorizontal.css"/>
    <link rel="stylesheet" href="../css/turmas.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
    <script>
        function verMais(codTurma) {
            window.location.href = "perfil_turma.php?codTurma=" + codTurma;
        }

        function deletarTurma(codTurma) {
        if (confirm("Tem certeza que deseja excluir esta turma e todos os seus cadastros?")) {
            console.log("Excluindo turma com codTurma:", codTurma);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "function/deletarTurma.php", true);
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
            xhr.send("codTurma=" + encodeURIComponent(codTurma));
        }
    }
    </script>
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
                                <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="sair.php">SAIR</a></li>
                            </ul>
                        </nav>
                            <div class="juntos">
                                <img src="../css/cssimg/logo.png" style="max-width: 85px; max-height: 85px; margin-left: 20px; margin-top: 15px;">
                                <h1>MOVESYS</h1>
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
            <div class="ajuda" style="left:92.4vw; top:-35.7vh;">
                <input type="submit" class="ajuda-button" value="Ajuda">
                <div class="ajuda-content" style="width:25vw; left:-25vw;">
                    <div class="ajuda-container" style="border-right:0px solid rgb(0, 119, 255);">
                        <div class="turma-ajuda-ajuda"></div>
                        <p>Nesta tela, você conseguirá desde criar turmas, definir o código de entrada desta turma, e excluir turmas ao clicar no ícone vermelho, além disso é possivel visualizar os dados das turmas já criadas, como a quantidade de alunos e o código da turma.</p>
                    </div>
                </div>
            </div>
                <div class="container-turmas" style="margin-left:-4vw;">
                    <div class="criar-turmas">
                        <form class="form" method="post" action="function/criarTurma.php" id="formturma" name="formturma">
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

                // Database connection (replace with your actual credentials)
                $hostname = "127.0.0.1";
                $user = "root";
                $password = "";
                $database = "logistica";

                // Create connection (with error handling)
                $conn = new mysqli($hostname, $user, $password, $database);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and execute the query (assuming table name is 'turmas')
                $sql = "SELECT turmas.nomeTurma, turmas.codTurma, turmas.data_turma, COUNT(usuarios.id) AS total_alunos 
                        FROM turmas 
                        LEFT JOIN usuarios ON turmas.codTurma = usuarios.codTurma 
                        GROUP BY turmas.codTurma";

                $result = $conn->query($sql);

                // Check for query execution errors
                if (!$result) {
                    echo "Error: " . $conn->error;
                } else {
                    // Loop through results and display information
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "
                                <div class=\"card-turmas\">
                                    <div class=\"delete-div\">
                                        <button class=\"delete-input\" onclick=\"deletarTurma('".$row["codTurma"]."')\">X</button>
                                    </div>
                                    <div class=\"nome-turmas\">
                                        <h5>". $row["nomeTurma"] ."</h5>
                                    </div>
                                    <div class=\"info-turmas\">
                                        <h6>Código: ". $row["codTurma"] ."</h6>
                                        <h6>Alunos matriculados: ". $row["total_alunos"] ."</h6>
                                        <h6>Data: ". $row["data_turma"] ."</h6>
                                        <div class=\"vermaisdiv\">
                                            <button class=\"vermais\" onclick=\"verMais('".$row["codTurma"]."')\">VER MAIS</button>
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
                $conn->close();

            echo '</div>
                </div>
            </div>
        </main>'; 
    }
?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.ajuda-button').addEventListener('click', function() {
            const content = document.querySelector('.ajuda-content');
            if (content.style.display === "flex") {
                content.style.display = "none";
            } else {
                content.style.display = "flex";
            }
        });
    });

function toggleForm() {
    var overlay = document.getElementById('overlay');
    var form = document.getElementById('project_form');
    if (overlay.style.display === 'block') {
        overlay.style.display = 'none';
        form.style.display = 'none';
    } else {
        overlay.style.display = 'block';
        form.style.display = 'block';
    }
}
</script>
</html>
