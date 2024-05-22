<?php
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname,$user,$password,$database);

    if ($conexao -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao -> connect_error;
        exit();
    } else {
        // Evita caracteres epsciais (SQL Inject)
        $nome = $conexao -> real_escape_string($_POST['nome']);
        $preco = $conexao -> real_escape_string($_POST['preco']);
        $peso = $conexao -> real_escape_string($_POST['peso']);
        $UN = $conexao -> real_escape_string($_POST['UN']);
        $NCM = $conexao -> real_escape_string($_POST['NCM']);

        $sql = "INSERT INTO `produtos` (`Nome`, `PrecoUNI`, `PesoGramas`,
        `NCM`, `UN`)
        VALUES ('".$nome."', '".$preco."', '".$peso."', '".$NCM."', '".$UN."')";

        $resultado = $conexao->query($sql);
        $conexao -> close();
        header('Location: ../cadastrarprodutos.php', true, 301);

    }
?>