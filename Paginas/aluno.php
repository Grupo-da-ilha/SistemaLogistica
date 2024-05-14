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
    <link rel="stylesheet" href="../css/aluno.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
    <style>
        /* Estilos para o formulário */
        #project_form {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300px;
            height: 160px;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 7px rgb(0, 119, 255);
        }
        /* Estilo personalizado para o input project_name */
        #project_name_form {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            display: block;
        }

        #project_name_form:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Estilo para o botão Criar Projeto */
        #save_button {
            margin-top: 10px;
            margin-left: 25%;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        #save_button:hover {
            transform: scale(1.05);
            animation: animate 1s linear infinite;
            background-color: #0056b3;
        }
    </style>
</head>
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

    echo '<header>
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
                            <li class="li-vertical"><a class="a-vertical" href="aluno.php">MENU</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="perfil.php">PERFIL</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="ajuda.php">AJUDA</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sobrenos.php">SOBRE NÓS</a></li>
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
        <div class="options-senai-new" onclick="toggleForm()">
        </div>
        <div class="options-senai-continue" onclick="getAndDisplayProjects()">
        </div>
        <form id="project_form" style="display: none;">
        <h3>Nome:</h3>
            <input type="text" id="project_name_form" placeholder="Nome do Projeto" required>
            <button type="button" id="save_button" onclick="saveProject()">Criar Projeto</button>
        </form>
    </div>
</main>'; 
} ?>

<script>
function toggleForm() {
    var form = document.getElementById('project_form');
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
}

function saveProject() {
    var projectName = document.getElementById('project_name_form').value;
    var personId = '<?php echo $_SESSION['id']; ?>'; // Pegando o ID do usuário da sessão

    // Enviar os dados para o PHP usando AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_project.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Manipular a resposta do servidor, se necessário
            alert(xhr.responseText);
            // Redirecionar após salvar o projeto com sucesso
            window.location.href = "projeto.php";
        }
    };
    xhr.send("person_id=" + personId + "&project_name=" + projectName);
}

function getAndDisplayProjects() {
    var cadastroId = '<?php echo $_SESSION['id']; ?>';
    window.location.href = "projetos.php?cadastro_id=" + cadastroId;
}
</script>

</body>
</html>
