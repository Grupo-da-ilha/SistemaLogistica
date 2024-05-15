<<<<<<< HEAD
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
    <link rel="shortcut icon" type="imagex/png" href="#"/>
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
</html>
=======
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
    <link rel="shortcut icon" type="imagex/png" href="#"/>
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
</html>
>>>>>>> fd667184b36f455bdcaefa5c8245afe403ad32ed
