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
    <link rel="stylesheet" href="../css/professor.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
    <style>
        h3 {
            margin-top: 2vh;
            font-family: 'Poppins', sans-serif;
            font-size: 23px;
            text-shadow: 0 0 2px rgb(0, 119, 255);
            cursor: default;
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        #project_form {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300px;
            height: 300px;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 0 15px rgb(0, 119, 255);
            z-index: 1000;
            display: none;
        }
        #project_name_form {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #project_name_form:focus {
            border-color: #007bff;
            box-shadow: 0 0 15px rgb(0, 119, 255);
        }
        #project_class_form {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #project_class_form:focus {
            border-color: #007bff;
            box-shadow: 0 0 15px rgb(0, 119, 255);
        }
        #save_button {
            margin-top: 40px;
            cursor: pointer;
            width: 100%;
            height: 50px;
            border-radius: 20px;
            font-size: 15px;
            border: none;
            outline: none;
            background-color: rgb(0, 119, 255);
            transition: all 0.3s;
            box-shadow: 0 0 15px rgb(0, 119, 255);
        }
        #save_button:hover {
            transform: scale(1.05);
            animation: animate 1s linear infinite;
            background-color: hsl(212, 95%, 60%);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: rgb(0, 119, 255);
            text-decoration: none;
        }
    </style>
</head>
<body>
<?php
session_start();

if (empty($_SESSION['nome'])) {
    header('Location: sair.php');
    exit();
} else {
    function getProjetosDoUsuario($cadastro_id) {
        return array();
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
    </header>
    <main>
        <div class="container-prin">
            <div class="options-senai-new" onclick="toggleForm()"></div>
            <div class="options-senai-continue" onclick="getAndDisplayProjects()"></div>
            <div id="overlay"></div>
            <form id="project_form">
                <span class="close" onclick="toggleForm()">&times;</span>
                <h3>Nome:</h3>
                <input type="text" id="project_name_form" name="project_name" placeholder="Nome do Projeto" required>
                <input type="text" id="project_class_form" name="project_class" placeholder="Código Turma" style="display:block;" required>
                <button type="button" id="save_button" onclick="saveProject()">Criar Projeto</button>
            </form>
            <a href="turmas.php"><div class="options-senai-turma"></div></a>
        </div>
    </main>';
}
?>
<script>
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

function saveProject() {
    var projectName = document.getElementById('project_name_form').value;
    var projectClass = document.getElementById('project_class_form').value;
    var personId = '<?php echo $_SESSION['id']; ?>';
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function/save_project.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText);
            window.location.href = "projetoprofessor.php";
        }
    };
    xhr.send("person_id=" + personId + "&project_name=" + encodeURIComponent(projectName) + "&project_class=" + encodeURIComponent(projectClass));
}

function getAndDisplayProjects() {
    var cadastroId = '<?php echo $_SESSION['id']; ?>';
    window.location.href = "projetosprofessor.php?cadastro_id=" + cadastroId;
}
</script>
</body>
</html>