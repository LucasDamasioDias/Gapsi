<?php
// Conexão com o banco
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "gapsi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Dados do formulário
$token = $_POST['token'];
$nova_senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar-senha'];

// Verifica se as senhas coincidem
if ($nova_senha !== $confirmar_senha) {
    die("As senhas não coincidem.");
}

// Verifica o token
$sql = "SELECT user_id FROM redefinicoes_senha WHERE token = ? AND expira_em > NOW()";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    // Atualiza a senha do usuário
    $sql_update = "UPDATE usuarios SET senha_hash = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $senha_hash, $user['user_id']);
    $stmt_update->execute();

    echo "Senha redefinida com sucesso.";
} else {
    echo "Token inválido ou expirado.";
}

$conn->close();
?>
