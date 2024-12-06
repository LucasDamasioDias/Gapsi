<?php
// Configuração da conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Altere conforme necessário
$password = "";
$dbname = "gapsi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Erro na conexão com o banco de dados: " . $conn->connect_error]));
}

// Criar a tabela se ela não existir
$sql_create_table = "
CREATE TABLE IF NOT EXISTS mensagens_contato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    assunto VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql_create_table)) {
    echo json_encode(["status" => "error", "message" => "Erro ao criar a tabela: " . $conn->error]);
    exit;
}

// Capturar e sanitizar os dados do formulário
$nome = filter_var(trim($_POST['nome']), FILTER_SANITIZE_STRING);
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$assunto = filter_var(trim($_POST['assunto']), FILTER_SANITIZE_STRING);
$mensagem = filter_var(trim($_POST['mensagem']), FILTER_SANITIZE_STRING);

// Validação dos campos
if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
    echo json_encode(["status" => "error", "message" => "Por favor, preencha todos os campos."]);
    exit;
}

if (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s]{1,100}$/', $nome)) {
    echo json_encode(["status" => "error", "message" => "O nome deve conter apenas letras e espaços, e não pode exceder 100 caracteres."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Por favor, insira um e-mail válido."]);
    exit;
}

if (strlen($assunto) > 150) {
    echo json_encode(["status" => "error", "message" => "O assunto não pode exceder 150 caracteres."]);
    exit;
}

if (strlen($mensagem) < 10 || strlen($mensagem) > 500) {
    echo json_encode(["status" => "error", "message" => "A mensagem deve conter entre 10 e 500 caracteres."]);
    exit;
}

// Inserir no banco de dados
$sql_insert = "INSERT INTO mensagens_contato (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Erro na preparação da consulta. Verifique a estrutura do banco de dados."]);
    exit;
}

$stmt->bind_param("ssss", $nome, $email, $assunto, $mensagem);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Mensagem enviada com sucesso!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Erro ao enviar a mensagem. Tente novamente mais tarde."]);
}

$stmt->close();
$conn->close();
?>
