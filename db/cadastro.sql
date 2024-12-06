CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Identificador único
    nome VARCHAR(100) NOT NULL,                -- Nome completo
    email VARCHAR(100) NOT NULL UNIQUE,        -- E-mail (único)
    telefone VARCHAR(15) NOT NULL,             -- Telefone
    senha_hash VARCHAR(255) NOT NULL,          -- Hash da senha
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data e hora do cadastro
);