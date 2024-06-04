<?php
// Função para obter os projetos do usuário com base no código da turma
function getProjetosDoUsuario($codTurma) {
    $hostname = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "logistica";

    $conexao = new mysqli($hostname, $user, $password, $database);

    if ($conexao->connect_errno) {
        echo "Failed to connect to MySQL: " . $conexao->connect_error;
        return array();
    }

    $stmt = $conexao->prepare("SELECT * FROM projetos WHERE codTurma = ?");
    $stmt->bind_param("s", $codTurma);
    $stmt->execute();
    $result = $stmt->get_result();

    $projetos = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projetos[] = $row;
        }
    }

    $stmt->close();
    $conexao->close();

    return $projetos;
}
?>
