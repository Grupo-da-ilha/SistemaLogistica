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
        
        if(isset($_POST['cod_produto'])){

            $cod_produto = $_POST['cod_produto'];

            $sql= "DELETE FROM `produtos` WHERE cod_produto = '".$cod_produto."' ";

            $result = $conexao->query($sql);

            header('Location: produtos.php', true, 301);
        } else{
            header('Location: produtos.php', true, 301);
        }
    }
?>