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
    <link rel="stylesheet" href="../css/ajuda.css"/>
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

	$sql="SELECT `id`, `nome`, `email`, `senha`, `data_entrada`, `ativo`, `tipousuario` FROM `usuarios`";

	$resultado = $conexao->query($sql);

		if (empty($_SESSION['nome'])){
		header('Location: ../CadastroLogin/sair.php');
		exit();
	    } else {
        echo '  <header>
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
                            <li class="li-vertical"><a class="a-vertical" href="aluno.php">MENU</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="perfilaluno.php">PERFIL</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="ajudaaluno.php">AJUDA</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sobrenosaluno.php">SOBRE NÓS</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="">CONFIGURAÇÕES</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sair.php">SAIR</a></li>
                        </ul>
                        </nav>
                            <div class="juntos">
                                <img src="../css/cssimg/logo.png" style="max-width: 85px; max-height: 85px; margin-left: 20px; margin-top: 15px;">
                                <h1>MOVESSSSSYS</h1>
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
                        <div class="ajuda-container">
                            <div class="tipos-ajuda">
                                <ul class="ul-button">
                                    <li class="li-vertical-menu"><a class="a-vertical-menu" href="">AJUDA</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">NOVO PROJETO</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">CONTINUAR PROJETO</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">ADICIONAR PRODUTO</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">RETIRAR PRODUTO</a></li>
                                    <li class="li-vertical"><a class="a-vertical" href="">CRIAR PRATELEIRA</a></li>
                                </ul>
                            </div>
                                <div class="ajuda">
                                    <div class="card-ajuda">
                                        <div class="titulo-ajuda">
                                            <h4>AJUDA-1</h4>
                                        </div>
                                        <div class="conteudo-ajuda"></div>
                                    </div>
                                    <div class="card-ajuda">
                                        <div class="titulo-ajuda">
                                            <h4>AJUDA-1</h4>
                                        </div>
                                        <div class="conteudo-ajuda"></div>
                                    </div>
                                    <div class="card-ajuda">
                                        <div class="titulo-ajuda">
                                            <h4>AJUDA-2</h4>
                                        </div>
                                        <div class="conteudo-ajuda"></div>
                                    </div>
                                    <div class="card-ajuda">
                                        <div class="titulo-ajuda">
                                            <h4>AJUDA-3</h4>
                                        </div>
                                        <div class="conteudo-ajuda"></div>
                                    </div>
                                    <div class="card-ajuda">
                                        <div class="titulo-ajuda">
                                            <h4>AJUDA-4</h4>
                                        </div>
                                        <div class="conteudo-ajuda"></div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </main> ' 
        ; }?>
</body>
</html>