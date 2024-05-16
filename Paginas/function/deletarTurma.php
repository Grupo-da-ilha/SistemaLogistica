<?php
session_start();

// Verifica se o usuário está logado
if (empty($_SESSION['nome'])) {
    header('Location: ../sair.php');
    exit();
} else {
    // Verifica se o parâmetro codTurma foi passado
    if (isset($_POST['codTurma'])) {
        $codTurma = $_POST['codTurma']; 

        $hostname = "127.0.0.1";
        $user = "root";
        $password = "";
        $database = "logistica";

       
        $conn = new mysqli($hostname, $user, $password, $database);
        if ($conn->connect_error) {
            echo"Não foi possível conectar ao banco de dados: " . $conn->connect_error;
            exit();
        }else{
            $sql = "DELETE FROM `turmas` WHERE `codTurma`= $codTurma";

            $result = $conn->query($sql); 
        }
    } else {
        exit();
    }
        }

