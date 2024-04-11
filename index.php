<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>SENAI ESTOQUE</title>
    <meta charset="utf-8">
    <meta name="author" content="Iago Souza, Kauan Burguer, Jonas Frees, Elias Alves e Silvio">
    <meta name="publisher" content="Estoque Senai" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="description" content="Projeto gerenciamento de estoque para o Senai de Itajaí-SC">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Bem Vindo de Volta!</h2>
                <p class="description description-primary">Para se manter conectado conosco</p>
                <p class="description description-primary">por favor faça login com suas informações pessoais</p>
                <button id="signin" class="btn btn-primary">LOGIN</button>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Criar Conta</h2>
                <p class="description description-second">Use seu e-mail para cadastro:</p>
                <form class="form" method="post" action="CadastroLogin/cadastro.php" id="formlogin" name="formlogin">
                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" placeholder="Nome" id="nomeUsuario" name="nomeUsuario" required>
                    </label>
                    

                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <select id="tipoUsuario" name="tipoUsuario" required>
                            <option>Selecione:</option>
                            <option>Aluno</option>
                            <option>Professor</option>
                        </select>
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="turma" placeholder="Turma" id="turmaUsuario" name="turmaUsuario" required>
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" placeholder="Email" id="emailUsuario" name="emailUsuario" required>
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" placeholder="Senha" id="senhaUsuario" name="senhaUsuario" required>
                    </label>
                    
                    
                    <button class="btn btn-second">CADASTRAR</button>        
                </form>
            </div>
        </div>
        <div class="content second-content">
            <div class="first-column">
                <h2 class="title title-primary">Olá, amigo!</h2>
                <p class="description description-primary">Insira seus dados pessoais</p>
                <p class="description description-primary">e comece a jornada conosco</p>
                <button id="signup" class="btn btn-primary">CADASTRAR</button>
            </div>
            <div class="second-column">
                <h2 class="title title-second">Login</h2>
                <p class="description description-second">Use sua conta de e-mail:
                </p>
                <form class="form" method="post" action="CadastroLogin/verificalogin.php" id="formverifica" name="formverifica">
                
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" placeholder="Email" id="emailUsuario" name="emailUsuario" required>
                    </label>
                
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" placeholder="Senha" id="senhaUsuario" name="senhaUsuario" required>
                    </label>
                
                    <a class="password" href="RecuperarSenha/recuperarsenha.php">Esqueceu sua senha?</a>
                    <button class="btn btn-second">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/index.js"></script>
</body>
<?php
?>
</html>