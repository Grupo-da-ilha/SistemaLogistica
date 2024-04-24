<?php
session_start();

// Verifica se o usuário está logado
if (empty($_SESSION['nome'])){
    header('Location: sair.php');
    exit();
} else {
    // Verifica se o parâmetro codTurma foi passado
    if (isset($_POST['codTurma'])) {
        $codTurma = $_POST['codTurma'];

        // Database connection (replace with your actual credentials)
        $hostname = "127.0.0.1";
        $user = "root";
        $password = "";
        $database = "logistica";

        // Create connection (with error handling)
        $conn = new mysqli($hostname, $user, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete cadastros from 'cadastro' table for the specified turma
        $sql = "DELETE FROM cadastro WHERE codTurma = '$codTurma'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error deleting record: " . $conn->error;
            exit();
        }

        // Delete turma from 'turmas' table
        $sql = "DELETE FROM turmas WHERE codTurma = '$codTurma'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error deleting record: " . $conn->error;
            exit();
        }

        // Close the connection
        $conn->close();

        // Send success response
        http_response_code(200);
        exit();
    } else {
        // Send error response if codTurma is not provided
        http_response_code(400);
        exit();
    }
}
?>
