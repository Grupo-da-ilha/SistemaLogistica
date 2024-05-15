<?php
session_start();

// Verifica se o usuário está logado
if (empty($_SESSION['nome'])) {
    header('Location: ../sair.php');
    exit();
} else {
    // Verifica se o parâmetro codTurma foi passado
    if (isset($_POST['codTurma'])) {
        $codTurma = intval($_POST['codTurma']); // Certifique-se de que o codTurma seja um inteiro

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

        // Begin transaction
        $conn->begin_transaction();

        try {
            // Delete projects from 'projetos' table for the specified turma and cadastros
            $sql = "DELETE FROM projetos WHERE Id IN (SELECT Id FROM cadastro WHERE codTurma = ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $codTurma);
            if (!$stmt->execute()) {
                throw new Exception("Error deleting projects: " . $stmt->error);
            }

            // Delete cadastros from 'cadastro' table for the specified turma
            $sql = "DELETE FROM cadastro WHERE codTurma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $codTurma);
            if (!$stmt->execute()) {
                throw new Exception("Error deleting cadastros: " . $stmt->error);
            }

            // Delete turma from 'turmas' table
            $sql = "DELETE FROM turmas WHERE codTurma = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $codTurma);
            if (!$stmt->execute()) {
                throw new Exception("Error deleting turma: " . $stmt->error);
            }

            // Commit transaction
            $conn->commit();

            // Close the connection
            $conn->close();

            // Send success response
            http_response_code(200);
            echo "Turma excluída com sucesso.";
            exit();
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            $conn->rollback();

            echo $e->getMessage();
            exit();
        }
    } else {
        // Send error response if codTurma is not provided
        http_response_code(400);
        exit();
    }
}
?>
