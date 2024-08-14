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
    <link rel="stylesheet" href="../css/projeto.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
<body>
<?php
    // Iniciar uma sessão
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
                                <li class="li-vertical"><a class="a-vertical" href="aluno.php">MENU</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="perfil.php">PERFIL</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="sobrenos.php">SOBRE NÓS</a></li>
                                <li class="li-vertical"><a class="a-vertical" href="sair.php">SAIR</a></li>
                            </ul>
                        </nav>
                    </li>
                    <li class="li-main">
                        <h1>MOVESYS</h1>
                        <h2>'.$_SESSION['nome'].'</h2>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <div class="container-prin">
        <div class="container-prin">
            <div class="ajuda">
                <input type="submit" class="ajuda-button" value="Ajuda">
                <div class="ajuda-content">
                    <div class="ajuda-container" style="border-right:1px solid rgb(0, 119, 255);">
                        <div class="novo-projeto"></div>
                        <p>Ao clicar em "Novo Projeto" você poderá criar um novo projeto logístico, assim especificando para qual turma será direcionada o projeto pelo código da turma, você também pode definir um nome de sua escolha.</p>
                    </div>
                    <div class="ajuda-container">
                        <div class="continuar-projeto"></div>
                        <p>Ao clicar em "Continuar Projeto" você poderá retomar um projeto já iniciado, basta inserir o código da turma desejada para buscar os projetos salvos da determinada turma. </p>
                    </div>
                    <div class="ajuda-container" style="border-left:1px solid rgb(0, 119, 255);">
                        <div class="turmas-projeto"></div>
                        <p>Ao clicar em "Turmas" você poderá criar ou administrar as turmas desejadas, assim podendo atribuir nomes e códigos de sua preferência.</p>
                    </div>
                </div>
            </div>
            <div class="functions-logistica">
                <div class="card-function-log-recebimento">
                </div>
                <div class="card-function-log-movimentacao">
                </div>
                <div class="card-function-log-estoque">
                </div>
                <div class="card-function-log-picking">
                </div>
                <div class="card-function-log-expedicao">
                </div>
                <div class="card-function-log-relatorios">
                </div>
                <div class="card-function-log-controle">
                </div>
                <div class="card-function-log-cadas">
                </div>
            </div>
        </div>
    </main>'; } ?>
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
