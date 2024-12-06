<?php
// Configuração do banco
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "gapsi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Captura o e-mail
$email = $_POST['email'];

// Verifica se o e-mail está registrado
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $token = bin2hex(random_bytes(32)); // Gera um token seguro

    // Armazena o token no banco com validade de 1 hora
    $sql_token = "INSERT INTO redefinicoes_senha (user_id, token, expira_em) 
                  VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))";
    $stmt_token = $conn->prepare($sql_token);
    $stmt_token->bind_param("is", $usuario['id'], $token);
    $stmt_token->execute();

    // Envia o e-mail
    $link = "http://seusite.com/redefinir-senha.php?token=$token";
    $assunto = "Redefinição de senha - Gapsi Global";
    $mensagem = "Clique no link para redefinir sua senha: $link";
    mail($email, $assunto, $mensagem);

    echo "Um e-mail foi enviado com instruções para redefinir sua senha.";
} else {
    echo "E-mail não encontrado.";
}

$conn->close();
?>
