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
    <link rel="stylesheet" href="../css/professor.css"/>
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
                            <li class="li-vertical"><a class="a-vertical" href="professor.php">MENU</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="perfilprofessor.php">PERFIL</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="ajudaprofessor.php">AJUDA</a></li>
                            <li class="li-vertical"><a class="a-vertical" href="sobrenosprofessor.php">SOBRE NÓS</a></li>
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
            echo '<h1>Projetos do usuário: ' . $_SESSION['nome'] . '</h1>';
            echo '<ul>';
            while ($row = $result_projetos->fetch_assoc()) {
                echo '<li>' . $row['nome'] . '</li>';
            }
            echo '</ul>';
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
</body>
</html>
