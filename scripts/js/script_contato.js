 document.querySelector(".form-contato").addEventListener("submit", function (event) {
        event.preventDefault(); // Previne o envio do formulário enquanto valida os campos

        // Seleciona os campos do formulário
        const nome = document.getElementById("nome");
        const email = document.getElementById("email");
        const assunto = document.getElementById("assunto");
        const mensagem = document.getElementById("mensagem");

        // Remove mensagens de erro antigas
        document.querySelectorAll(".erro").forEach(erro => erro.remove());

        let formValido = true;

        // Função para adicionar mensagem de erro
        const mostrarErro = (campo, mensagem) => {
            const erro = document.createElement("div");
            erro.className = "erro";
            erro.style.color = "red";
            erro.style.fontSize = "0.9rem";
            erro.textContent = mensagem;
            campo.parentNode.appendChild(erro);
        };

        // Valida os campos
        if (!nome.value.trim()) {
            mostrarErro(nome, "Por favor, preencha este campo.");
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
        }

        // Se todos os campos estiverem válidos, envia o formulário
        if (formValido) {
            this.action = "mailto:gapsiglobal@gmail.com"; // Configura o envio por e-mail
            this.submit();
        }
    });