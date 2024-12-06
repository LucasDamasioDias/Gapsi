<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Altere conforme necessário
$password = "";
$dbname = "gapsi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Capturar os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verificar se os campos estão preenchidos
if (empty($email) || empty($senha)) {
    die("Por favor, preencha todos os campos.");
}

// Preparar a consulta para verificar o usuário
$sql = "SELECT id, nome, senha_hash FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Verifica a senha
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario['senha_hash'])) {
        // Inicia a sessão e salva informações do usuário
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        // Redireciona para a página inicial ou painel
        header("Location: ../dashboard.php");
        exit;
    } else {
        echo "Senha incorreta.";
    }
} else {
    echo "Usuário não encontrado.";
}

$stmt->close();
$conn->close();
?>
