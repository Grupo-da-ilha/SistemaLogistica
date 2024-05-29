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
    <link rel="shortcut icon" type="imagex/png" href="../css/cssimg/logo.png"/>
</head>
<style>

        h3 {
            margin-top: 2vh;
            font-family: 'Poppins', sans-serif;
            font-size: 23px;
            text-shadow: 0 0 2px rgb(0, 119, 255);
            cursor: default;
        }
        /* Estilos para o formulário */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fundo escuro semi-transparente */
            z-index: 999; /* Certifique-se de que o overlay esteja sobre todos os outros elementos */
            display: none; /* Ocultar inicialmente */
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
            z-index: 1000; /* Certifique-se de que o formulário esteja acima do overlay */
            display: none; /* Ocultar inicialmente */
        }

        /* Estilo personalizado para o input project_name */
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

        /* Estilo para o botão Criar Projeto */
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
            -moz-transition: all 0.3s;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgb(0, 119, 255);
        }

        #save_button:hover {
            -moz-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.05);
            animation: animate 1s linear infinite;
            background-color: hsl(212, 95%, 60%);
        }

        /* Estilos para o botão de fechar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color:rgb(0, 119, 255);
            text-decoration: none;
        }
    </style>
<body>
<?php
// Iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: sair.php');
    exit();
} else {
    // Função para obter os projetos do usuário com base no ID do cadastro
    function getProjetosDoUsuario($cadastro_id) {
        // Conectar ao banco de dados e realizar a consulta dos projetos
        // Substitua esta parte com a lógica de consulta real ao banco de dados
        return array(); // Aqui, retornamos um array vazio como exemplo
    }
    
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
                <div class="options-senai-new" onclick="toggleForm()">
                </div>
                <div class="options-senai-continue" onclick="getAndDisplayProjects()">
                </div>
                <!-- Overlay para o fundo escuro -->
                <div id="overlay"></div>
                <form id="project_form">
                    <!-- Botão de fechar -->
                    <span class="close" onclick="toggleForm()">&times;</span>
                    <h3>Nome:</h3>
                    <input type="text" id="project_name_form" placeholder="Nome do Projeto" required>
                    <input type="text" id="project_name_form" placeholder="Código Turma" required>
                    <button type="button" id="save_button" onclick="saveProject()">Criar Projeto</button>
                </form>
                <a href="turmas.php"><div class="options-senai-turma">
            </div></a>
        </div>
    </main>'; } ?>

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
    var personId = '<?php echo $_SESSION['id']; ?>'; // Pegando o ID do usuário da sessão

    // Enviar os dados para o PHP usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "function/save_project.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipular a resposta do servidor, se necessário
            alert(xhr.responseText);
            // Redirecionar após salvar o projeto com sucesso
            window.location.href = "projetoprofessor.php";
            
        }
    };
    xhr.send("person_id=" + personId + "&project_name=" + projectName);
}

function getAndDisplayProjects() {
    var cadastroId = '<?php echo $_SESSION['id']; ?>';
    window.location.href = "projetosprofessor.php?cadastro_id=" + cadastroId;
}
</script>
</body>
</html>

