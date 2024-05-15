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
    <link rel="stylesheet" href="../css/projetos.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
<?php
// iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: sair.php');
    exit();
} else {
?>
<header>
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
                    <h2><?php echo $_SESSION['nome']; ?></h2>
                </li>
            </ul>
        </div>
    </div>
</header>
<main>
    <div class="container-prin">
<?php
    // Construir o caminho do arquivo de inclusão de forma relativa
    $caminho_inclusao = __DIR__ . 'function/funcoes_banco.php';

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
            echo '<div class="titulo-projetos">';
            echo '<h3>Projetos de  ' . $_SESSION['nome'] . '</h3>';
            echo '</div>';
            echo '<div class="projetos-do-usuario">';
            while ($row = $result_projetos->fetch_assoc()) {
                echo '<div class="card-projetos">';
                echo '
                    <div class="apagar-projeto">
                        <button type="button" class="button-apagar-projeto" data-projeto-id="' . $row['idprojeto'] . '">X</button>
                    </div>';
                echo '<h4>' . $row['nome'] . '</h4>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>Nenhum projeto encontrado para este usuário.</p>';
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "Erro: Arquivo funcoes_banco.php não encontrado.";
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
    <link rel="stylesheet" href="../css/projetos.css"/>
    <link rel="shortcut icon" type="imagex/png" href="#"/>
</head>
<body>
<?php
// iniciar uma sessão
session_start();

if (empty($_SESSION['nome'])){
    header('Location: sair.php');
    exit();
} else {
?>
<header>
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
                    <h2><?php echo $_SESSION['nome']; ?></h2>
                </li>
            </ul>
        </div>
    </div>
</header>
<main>
    <div class="container-prin">
<?php
    // Construir o caminho do arquivo de inclusão de forma relativa
    $caminho_inclusao = __DIR__ . '/funcoes_banco.php';

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
            echo '<div class="titulo-projetos">';
            echo '<h3>Projetos de  ' . $_SESSION['nome'] . '</h3>';
            echo '</div>';
            echo '<div class="projetos-do-usuario">';
            while ($row = $result_projetos->fetch_assoc()) {
                echo '<div class="card-projetos">';
                echo '
                    <div class="apagar-projeto">
                        <button type="button" class="button-apagar-projeto" data-projeto-id="' . $row['idprojeto'] . '">X</button>
                    </div>';
                echo '<h4>' . $row['nome'] . '</h4>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>Nenhum projeto encontrado para este usuário.</p>';
        }

        // Fechar a conexão
        $conexao->close();
    } else {
        echo "Erro: Arquivo funcoes_banco.php não encontrado.";
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
                xhr.open('POST', 'excluir_projeto.php', true);
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
>>>>>>> fd667184b36f455bdcaefa5c8245afe403ad32ed
