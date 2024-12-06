document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); // Previne o envio do formulário enquanto valida os campos

    // Seleção dos campos do formulário
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const telefone = document.getElementById("telefone");
    const senha = document.getElementById("senha");
    const confirmarSenha = document.getElementById("confirmar-senha");

    // Remove mensagens de erro antigas
    document.querySelectorAll(".erro").forEach(erro => erro.remove());
    [nome, email, telefone, senha, confirmarSenha].forEach(campo => campo.classList.remove("erro-campo"));

    let formValido = true;

    // Função para adicionar mensagem de erro
    const mostrarErro = (campo, mensagem) => {
        const erro = document.createElement("div");
        erro.className = "erro";
        erro.textContent = mensagem;
        campo.parentNode.appendChild(erro);
        campo.classList.add("erro-campo");
    };

    // Validações
    if (!nome.value.trim()) {
        mostrarErro(nome, "Por favor, preencha este campo.");
        formValido = false;
    } else if (!/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/.test(nome.value)) {
        mostrarErro(nome, "O nome deve conter apenas letras.");
        formValido = false;
    }

    if (!email.value.trim()) {
        mostrarErro(email, "Por favor, preencha este campo.");
        formValido = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        mostrarErro(email, "Por favor, insira um e-mail válido.");
        formValido = false;
    }

    if (!telefone.value.trim()) {
        mostrarErro(telefone, "Por favor, preencha este campo.");
        formValido = false;
    } else if (!/^\d{10,11}$/.test(telefone.value)) {
        mostrarErro(telefone, "O telefone deve conter apenas números, com 10 ou 11 dígitos.");
        formValido = false;
    }

    if (!senha.value.trim()) {
        mostrarErro(senha, "Por favor, preencha este campo.");
        formValido = false;
    } else if (senha.value.length < 6) {
        mostrarErro(senha, "A senha deve ter pelo menos 6 caracteres.");
        formValido = false;
    }

    if (senha.value !== confirmarSenha.value) {
        mostrarErro(confirmarSenha, "As senhas não coincidem.");
        formValido = false;
    }

    // Se o formulário for válido, submete os dados
    if (formValido) {
        event.target.submit();
    }
});
