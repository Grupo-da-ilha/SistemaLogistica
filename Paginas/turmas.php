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
            $sql = "SELECT turmas.nomeTurma, turmas.codTurma, COUNT(cadastro.id) AS total_alunos 
                    FROM turmas 
                    LEFT JOIN cadastro ON turmas.codTurma = cadastro.codTurma 
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
                      <div class=\"nome-turmas\">
                        <h5>". $row["nomeTurma"] ."</h5>
                      </div>
                      <div class=\"info-turmas\">
                        <h6>Código: ". $row["codTurma"] ."</h6>
                        <h6>Alunos matriculados: ". $row["total_alunos"] ."</h6>
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
    </main>'; } ?>
</body>
</html>