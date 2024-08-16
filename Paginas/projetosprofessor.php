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
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname, $user, $password, $database);

    if ($conexao->connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao->connect_error;
        exit();
    }
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
</header>';
?>
<main>
    <div class="container-prin">
    <div class="ajuda" style="left:94.4vw; top:-35.7vh;">
                <input type="submit" class="ajuda-button" value="Ajuda">
                <div class="ajuda-content" style="width:25vw; left:-25vw;">
                    <div class="ajuda-container" style="border-right:0px solid rgb(0, 119, 255);">
                        <div class="continuar-projetos-ajuda"></div>
                        <p>Nesta tela está todos os projetos criados na determinada turma inserida, ao clicar no card, você será redirecionado para o projeto selecionado, se não houver nenhum card possivelmente não há nenhum projeto criado.</p>
                        <p>Ao clicar no ícone vermelho o determinado projeto será excluído permanentemente.</p>
                    </div>
                </div>
    </div>
    <?php
    include_once 'function/projcriados.php';

    if (isset($_GET['project_sala'])) {
        $codTurma = $_GET['project_sala'];

        $projetos = getProjetosDoUsuario($codTurma);

        if (!empty($projetos)) {
            echo '<div class="projetos-do-usuario">';
            foreach ($projetos as $projeto) {
                echo '<div class="card-projetos" onclick="selectProject(' . $projeto['idprojeto'] . ', \'' . $codTurma . '\')">';
                echo '<div class="apagar-projeto">';
                echo '<button type="button" class="button-apagar-projeto" data-projeto-id="' . $projeto['idprojeto'] . '">X</button>';
                echo '</div>';
                echo '<h4>' . htmlspecialchars($projeto['nome']) . '</h4>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            $SelectTurma = "SELECT * FROM turmas WHERE codTurma = '$codTurma'";
            $executeTurma = $conexao -> query($SelectTurma);

            if($executeTurma -> num_rows > 0){
                echo '<h5>Nenhum projeto encontrado para esta turma.</h5>';
            }else{
                echo '<h5>Turma inexistente</h5>';
            }
            
        }

        echo '<form id="projectForm" action="projetoprofessor.php" method="POST" style="display: none;">
                <input type="hidden" name="project_id" id="project_id">
                <input type="hidden" name="cod_turma" id="cod_turma" value="' . htmlspecialchars($codTurma) . '">
              </form>';
    } else {
        echo 'Erro: Código da turma não informado.';
    }
}
    ?>
    </div>
</main>

<script>
function selectProject(projectId, codTurma) {
    document.getElementById('project_id').value = projectId;
    document.getElementById('cod_turma').value = codTurma;
    document.getElementById('projectForm').submit();
}

document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.button-apagar-projeto');
    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Evita a propagação do clique para o card do projeto
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
</body>
</html>