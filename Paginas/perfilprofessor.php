<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI/PERFIL</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="SENAI Supply Chain Solutions">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/menuhorizontal.css"/>
    <link rel="stylesheet" href="../css/perfil.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
</head>
<body>
<?php
	// iniciar uma sessão
	session_start();
    $hostname = "127.0.0.1";
	$user = "root";
	$password = "";
	$database = "logistica";
		
	$conexao = new mysqli($hostname,$user,$password,$database);

	$sql="SELECT `id`, `nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario`  FROM `usuarios`";
    
	$resultado = $conexao->query($sql);

		if (empty($_SESSION['nome'])){
		header('Location: sair.php');
		exit();
	    } else {
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
    </header>
                <main>
                    <div class="container-prin">
                        <div class="perfil-container">
                            <img class="fotoperfil" src="../css/cssimg/perfil.png">
                            <div class="info-dados-perfil">
                            <h5>'.$_SESSION['nome'].'</h5>
                            </div>
                        </div>
                        <div class="form-dados">
                            <div class="title-dados">
                                <h3>DADOS:</h2>
                            </div>
                            <div class="info-dados">
                                <h3>ID:</h3>
                                <h4>'.$_SESSION['id'].'</h4>
                            </div>
                            <div class="info-dados">
                                <h3>Email:</h3>
                                <h4>'.$_SESSION['email'].'</h4>
                            </div>
                            <div class="info-dados">
                                <h3>Aluno/Professor:</h3>
                                <h4>'.$_SESSION['senha'].'</h4>
                            </div>
                            <div class="info-dados-end">
                                <h3>Data de entrada:</h3>
                                <h4>'.$_SESSION['data_entrada'].'</h4>
                            </div>
                        </div>
                    </div>
                </main> ' 
        ; }?>
</body>
</html>