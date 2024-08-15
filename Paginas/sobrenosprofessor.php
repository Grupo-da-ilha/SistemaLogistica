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
    <link rel="stylesheet" href="../css/sobrenos.css"/>
    <link rel="stylesheet" href="css/unpkg.com_swiper@8.1.6_swiper-bundle.min.css">
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
                            <h2>'.htmlspecialchars($_SESSION['nome']).'</h2>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
                <main>
                    <div class="container-prin">
                    <div class="caixaria">
                    <div class="caixaslider">
                       <div class="img-slider">
                                        <div class="slide active">
                                        <img src="../css/imgsobrenos/6.png" alt="">
                                        <div class="information">
                                            <h4>MOVESYS</h4>
                                        </div>
                                    </div>
                                   <div class="slide">
                                       <img src="../css/imgsobrenos/2.png" alt="">
                                       <div class="information">
                                           <h4>Iago Souza</h4>
                                           <p>Meu nome é Iago e gostaria de expressar minha sincera gratidão pela oportunidade de fazer parte deste projeto. Agradeço pela confiança da equipe SENAI e estou à disposição para o que precisar.</p>
                                       </div>
                                   </div>
                                   <div class="slide">
                                       <img src="../css/imgsobrenos/1.png"" alt="">
                                       <div class="information">
                                           <h4>Elias Alves</h4>
                                           <p>Sou o Elias e estou muito entusiasmado por ter participado deste projeto. Quero agradecer pela oportunidade de colaborar com equipe SENAI. Muito obrigado pela confiança!</p>
                                       </div>
                                   </div>
                                   <div class="slide">
                                    <img src="../css/imgsobrenos/4.png"" alt="">
                                    <div class="information">
                                        <h4>Kauan Burguer</h4>
                                        <p>Meu nome é Kauan e quero expressar minha gratidão pela oportunidade dada pelo SENAI. Espero que todos os alunos possam ter um bom aprendizado com nosso software.</p>
                                    </div>
                                </div>
                                <div class="slide">
                                    <img src="../css/imgsobrenos/5.png"" alt="">
                                    <div class="information">
                                        <h4>Jonas Frees</h4>
                                        <p>Aqui é o Jonas. Agradeço sinceramente pela chance de participar deste projeto. Fiz o meu melhor para desenvolver este software. Obrigado pela confiança e espero que você possa ter um bom aprendizado.!</p>
                                    </div>
                                </div>
                                <div class="slide">
                                    <img src="../css/imgsobrenos/3.png"" alt="">
                                    <div class="information">
                                        <h4>Silvio</h4>
                                        <p>Sou o Silvio e gostaria de agradecer pela oportunidade de fazer parte deste projeto. Muito obrigado pela confiança e eu desejo para vocês um bom aprendizado.</p>
                                    </div>
                                </div>
                                   
                                   <div class="navigationslider">
                                       <div class="btn active"></div>
                                       <div class="btn"></div>
                                       <div class="btn"></div>
                                       <div class="btn"></div>
                                       <div class="btn"></div>
                                       <div class="btn"></div>
                                   </div>
                       </div>
                   </div>
                    </div>
                    </div>
                </main> ' 
        ; }?>
</body>
<script src="../js/unpkg.com_swiper@8.1.6_swiper-bundle.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/modal.js"></script>
<script src="../js/slider.js"></script>
</html>