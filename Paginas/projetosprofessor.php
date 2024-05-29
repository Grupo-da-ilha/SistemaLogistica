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
    <link rel="stylesheet" href="../css/projetos.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
<?php
// iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: ../sair.php');
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
</header>;'
    ?>
<main>
    <div class="container-prin">
<?php
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname, $user, $password, $database);

    if ($conexao->connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao->connect_error;
        exit();
    }else{


    $caminho_inclusao = __DIR__ . '/function/projcriados.php';

    // Verificar se o arquivo existe antes de incluí-lo
    if (file_exists($caminho_inclusao)) {
        include_once $caminho_inclusao;

        // Recuperar o ID do usuário da sessão
        $cadastro_id = $_SESSION['id'];

        // Realizar a consulta ao banco de dados para obter os projetos do usuário
        $conexao = new mysqli("127.0.0.1", "root", "", "logistica");
        
        // Verificar a conexão
        if ($conexao->connect_error) {
            die("Conexão falhou: " . $conexao->connect_error);
        }

        // Consulta SQL para obter os projetos do usuário
        $sql_projetos = "SELECT * FROM projetos WHERE Id = $cadastro_id";
        $result_projetos = $conexao->query($sql_projetos);

        // Verificar se há resultados de projetos
        if ($result_projetos->num_rows > 0) {
            echo '<div class="projetos-do-usuario">';
            while ($row = $result_projetos->fetch_assoc()) {
                $_SESSION['Idprojeto'] = $row['idprojeto'];
                echo '<a href="projetoprofessor.php" style="text-decoration: none; cursor:pointer;">';
                echo '<div class="card-projetos">';
                echo '</a>';
                echo '
                        <div class="apagar-projeto">
                            <button type="button" class="button-apagar-projeto" data-projeto-id="' . $row['idprojeto'] . '">X</button>
                        </div>';
                echo '<a href="projetoprofessor.php" style="text-decoration: none">';
                echo '<h4>' . $row['nome'] . '</h4>';
                echo '</div>';
                echo '</a>';
            }
            echo '</div>';
        } else {
            echo '<p>Nenhum projeto encontrado para este usuário.</p>';
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "não deu";
    }
}
}

?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.button-apagar-projeto');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var projetoId = button.dataset.projetoId;
            if (confirm('Tem certeza de que deseja apagar este projeto?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'function/excluir_projeto.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            console.log('Projeto excluído com sucesso');
                            window.location.reload();
                        } else {
                            console.error('Erro ao excluir projeto');
                        }
                    }
                };
                xhr.send('projeto_id=' + projetoId);
            }
        });
    });
});
</script>

</body>
</html>
