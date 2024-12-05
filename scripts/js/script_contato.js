document.querySelector(".form-contato").addEventListener("submit", function (event) {
    event.preventDefault(); // Previne o envio do formulário enquanto valida os campos

    // Seleciona os campos do formulário
    const nome = document.getElementById("nome");
    const email = document.getElementById("email");
    const assunto = document.getElementById("assunto");
    const mensagem = document.getElementById("mensagem");

    // Remove mensagens de erro antigas
    document.querySelectorAll(".erro").forEach(erro => erro.remove());
    [nome, email, assunto, mensagem].forEach(campo => campo.classList.remove("erro-campo"));

    let formValido = true;

    // Função para adicionar mensagem de erro
    const mostrarErro = (campo, mensagem) => {
        const erro = document.createElement("div");
        erro.className = "erro";
        erro.textContent = mensagem;
        campo.parentNode.appendChild(erro);
        campo.classList.add("erro-campo");
    };

    // Valida os campos
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

    if (!assunto.value.trim()) {
        mostrarErro(assunto, "Por favor, preencha este campo.");
        formValido = false;
    }

    if (!mensagem.value.trim()) {
        mostrarErro(mensagem, "Por favor, preencha este campo.");
        formValido = false;
    } else if (mensagem.value.length > 500) {
        mostrarErro(mensagem, "A mensagem não pode exceder 500 caracteres.");
        formValido = false;
    }

    // Se o formulário for válido, pode ser enviado
    if (formValido) {
        alert("Formulário enviado com sucesso!");
        event.target.submit();
    }
});

// Atualiza contador de caracteres
document.getElementById("mensagem").addEventListener("input", function () {
    const maxLength = 500;
    const restante = maxLength - this.value.length;
    const contador = document.getElementById("contador");
    contador.textContent = `${restante} caracteres restantes`;
    contador.style.color = restante < 0 ? "red" : "black";
});
