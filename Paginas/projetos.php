<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Projetos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
    // Iniciar uma sessão
    session_start();

    // Verificar se o usuário está logado
    if (empty($_SESSION['nome'])) {
        header('Location: sair.php');
        exit();
    } else {
        // Recuperar o ID do usuário da sessão
        $cadastro_id = $_SESSION['id'];
        
        // Aqui você deve fazer a consulta ao banco de dados para obter os projetos do usuário com o ID $cadastro_id
        // Suponha que você tenha uma função getProjetosDoUsuario() que retorna os projetos do usuário com base no ID do cadastro
        // Substitua isso pela lógica real de consulta ao banco de dados
        $projetos = getProjetosDoUsuario($cadastro_id);

        // Agora vamos exibir os projetos na página
        if ($projetos) {
            echo '<h1>Projetos do usuário: ' . $_SESSION['nome'] . '</h1>';
            echo '<ul>';
            foreach ($projetos as $projeto) {
                echo '<li>' . $projeto['nome'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Nenhum projeto encontrado para este usuário.</p>';
        }
    }
?>

<a href="aluno.php">Voltar</a>

</body>
</html>
