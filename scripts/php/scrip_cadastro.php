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
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha'];

// Criar tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(15) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql)) {
    die("Erro ao criar tabela: " . $conn->error);
}

// Verificar se o e-mail já está cadastrado
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Erro: Este e-mail já está cadastrado.";
    exit;
}

// Inserir os dados do usuário
$sql = "INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Criptografar a senha
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
$stmt->bind_param("ssss", $nome, $email, $telefone, $senhaCriptografada);

if ($stmt->execute()) {
    echo "Usuário cadastrado com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
