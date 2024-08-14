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
    <link rel="stylesheet" href="../css/projeto.css"/>
    <link rel="shortcut icon" type="image/png" href="../css/cssimg/logo.png"/>
    <style>
        /* Estilo para o modal */

        h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 23px;
            text-shadow: 0 0 2px rgb(0, 119, 255);
            cursor: default;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            height: 300px;
            border-radius: 30px;
            display: flex;
            justify-content: first baseline;
            align-items: center;
            flex-direction: column;
            box-shadow: 0 0 15px rgb(0, 119, 255);
            
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color:rgb(0, 119, 255);
            text-decoration: none;
            cursor: pointer;
        }
        #carga, #container {
            cursor: pointer;
            width: 100%;
            height: 50px;
            margin: 15px;
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

        #carga:hover, #container:hover {
            -moz-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.05);
            animation: animate 1s linear infinite;
            background-color: hsl(212, 95%, 60%);
        }
    </style>
</head>
<body>
<?php
    // Iniciar uma sessão
    session_start();
    if (isset($_POST['project_id'])) {
        $_SESSION['Idprojeto'] = $_POST['project_id'];
    }
    if (empty($_SESSION['nome'])){
        header('Location: sair.php');
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
        <div class="ajuda" style="left:94.4vw; top:-37.5vh;">
                <input type="submit" class="ajuda-button" value="Ajuda">
                <div class="ajuda-content" style="width:25vw; left:-25vw;">
                    <div class="ajuda-container" style="border-right:0px solid rgb(0, 119, 255);">
                        <div class="projetos-ajuda" style="width:15vw;"></div>
                        <p>Nesta tela é aonde começa o processo logístico, aqui você pode observar e adentrar em diversos "setores" e funções de um meio logístico.</p>
                    </div>
                </div>
            </div>
            <div class="functions-logistica">
                <a href="criarpedido.php"><div class="card-function-log-pedido"></div></a>
                <a href="danfe.php"><div class="card-function-log-danfe"></div></a>
                <a href="carga.php"><div class="card-function-log-vistoria"></div></a>
                <a href="recebimentodoca.php"><div class="card-function-log-recebimento"></div></a>
                <a href="controledoca.php"><div class="card-function-log-controle"></div></a>
                <a href="movimentacao.php"><div class="card-function-log-movimentacao"></div></a>
                <a href="operacaomovimentacao.php"><div class="card-function-log-operacao"></div></a>
                <a href="estoque.php"><div class="card-function-log-estoque"></div></a>
                <a href="picking.php"><div class="card-function-log-picking"></div></a>
                <a href="expediçao.php"><div class="card-function-log-expedicao"></div></a>
                <a href="inventario.php"><div class="card-function-log-intervantario"></div></a>
                <a href="vistoriasolicitacoes.php"><div class="card-function-log-vistoria-carga"></div></a>
            </div>
        </div>
    </main>';
}
?>
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
