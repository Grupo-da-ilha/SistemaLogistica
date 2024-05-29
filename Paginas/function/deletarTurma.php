<?php
session_start();

if (empty($_SESSION['nome'])) {
    header('Location: ../sair.php');
    exit();
} else {
    if (isset($_POST['codTurma'])) {
        $codTurma = $_POST['codTurma']; 

        $hostname = "127.0.0.1";
        $user = "root";
        $password = "";
        $database = "logistica";

        $conn = new mysqli($hostname, $user, $password, $database);

        if ($conn->connect_error) {
            echo "Não foi possível conectar ao banco de dados: " . $conn->connect_error;
            exit();
        }
        $stmt = "DELETE FROM projetos WHERE id = '".$_SESSION['id']."'";
        $executar = $conn -> query($stmt);

        if ($executar) {
            $stmt = $conn->prepare("DELETE FROM cadastro WHERE codTurma = ?");
            $stmt->bind_param("s", $codTurma);

            if ($stmt->execute()) {
                $stmt = $conn->prepare("DELETE FROM turmas WHERE codTurma = ?");
                $stmt->bind_param("s", $codTurma);
        
                if ($stmt->execute()) {
                    echo "Turma excluída com sucesso";
                } else {
                    echo "Erro ao excluir turma: " . $stmt->error;
                }
            } else {
                echo "Erro ao excluir cadastro: " . $stmt->error;
            }

        $stmt->close();
        $conn->close();
    } else {
        echo "Parâmetro codTurma não fornecido";
        exit();
    }
}
}
?>
