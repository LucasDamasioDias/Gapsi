document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita o envio do formulário enquanto valida os campos

    const email = document.getElementById("email");
    const senha = document.getElementById("senha");

    // Remove mensagens de erro antigas
    document.querySelectorAll(".erro").forEach((erro) => erro.remove());
    [email, senha].forEach((campo) => campo.classList.remove("erro-campo"));

    let formValido = true;

    // Função para exibir mensagem de erro
    const mostrarErro = (campo, mensagem) => {
        const erro = document.createElement("div");
        erro.className = "erro";
        erro.textContent = mensagem;
        campo.parentNode.appendChild(erro);
        campo.classList.add("erro-campo");
    };

    // Validação do e-mail
    if (!email.value.trim()) {
        mostrarErro(email, "Por favor, preencha este campo.");
        formValido = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        mostrarErro(email, "Por favor, insira um e-mail válido.");
        formValido = false;
    }

    // Validação da senha
    if (!senha.value.trim()) {
        mostrarErro(senha, "Por favor, preencha este campo.");
        formValido = false;
    }

    // Se o formulário for válido, envia os dados
    if (formValido) {
        this.submit();
    }
});
