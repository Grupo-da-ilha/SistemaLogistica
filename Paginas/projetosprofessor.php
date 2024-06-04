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
    <link rel="stylesheet" href="../css/projetos.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
<body>
<?php
// iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: ../sair.php');
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
                            <li class="li-vertical"><a class="a-vertical" href="ajudaprofessor.php">AJUDA</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="">CONFIGURAÇÕES</a></li>
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
</header>;'
    ?>
<main>
    <div class="container-prin">
    <?php
    include_once 'function/projcriados.php';

    if (isset($_GET['project_sala'])) {
        $codTurma = $_GET['project_sala'];

        // Obter os projetos do usuário com base no código da turma
        $projetos = getProjetosDoUsuario($codTurma);

        if (!empty($projetos)) {
            echo '<div class="projetos-do-usuario">';
            foreach ($projetos as $projeto) {
                echo '<div class="card-projetos" onclick="selectProject(' . $projeto['idprojeto'] . ')">';
                echo '<div class="apagar-projeto">';
                echo '<button type="button" class="button-apagar-projeto" data-projeto-id="' . $projeto['idprojeto'] . '">X</button>';
                echo '</div>';
                echo '<h4>' . $projeto['nome'] . '</h4>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>Nenhum projeto encontrado para esta turma.</p>';
        }

        echo '<form id="projectForm" action="projetoprofessor.php" method="POST" style="display: none;">
                <input type="hidden" name="project_id" id="project_id">
              </form>';
    } else {
        echo 'Erro: Código da turma não informado.';
    }
}
    ?>
    </div>
</main>

<script>
        function selectProject(projectId) {
            document.getElementById('project_id').value = projectId;
            document.getElementById('projectForm').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.button-apagar-projeto');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var projetoId = button.dataset.projetoId;
                    if (confirm('Tem certeza de que deseja apagar este projeto?')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'function/excluir_projeto.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    console.log('Projeto excluído com sucesso');
                                    window.location.reload();
                                } else {
                                    console.error('Erro ao excluir projeto');
                                }
                            }
                        };
                        xhr.send('projeto_id=' + projetoId);
                    }
                });
            });
        });
    </script>

</body>
</html>
