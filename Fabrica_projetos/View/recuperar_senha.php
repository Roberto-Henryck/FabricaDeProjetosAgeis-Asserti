<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
</head>
<style>
    body {
        background-color: #031E27;
        font-family: Arial, Helvetica, sans-serif;
    }

    nav {
        display: flex;
        justify-content: space-between;
    }

    input {
        width: 300px;
        border-radius: 20px;
        align-items: center;
        display: flex;
        padding: 10px;
        border: none;
    }

    a {
        text-decoration: none;
        color: white;
        display: flex;
        font-size: 13px;
    }

    p {
        color: white;
        width: 400px;
        display: flex;
        justify-content: center;
        font-size: 13px;
    }

    .botao {
        width: 350px;
        height: 40px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        cursor: pointer;
    }

    label {
        display: flex;
        align-items: center;
        padding: 10px;
        color: white;
    }

    .conteudo {
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 0 auto;
        gap: 30px;
        align-items: center;
    }

    h1 {
        color: white;
    }

    main {
        margin-top: 100px;
    }
</style>

<body>

    <nav>
        <div class="logo">
            <img src="../IMG/Logo.png" alt="Logo" width="300px">
        </div>
    </nav>

    <main>
        <div class="conteudo">
            <h1>Recuperar senha</h1>

            <form id="form-recuperar" class="conteudo">
                <div class="campo">
                    <label for="user_email">E-mail</label>
                    <input type="email" id="user_email" name="user_email" placeholder="Digite seu e-mail" required>
                </div>

                <button type="submit" id="btn-enviar" class="botao">Enviar</button>
            </form>

            <p><a href="login.php" class="cadastrar">Voltar ao login</a></p>

            <p id="status"></p>
        </div>
    </main>

    <script>
        emailjs.init("3-D-sjMf2x4LduoPo");

        const form = document.getElementById('form-recuperar');
        const status = document.getElementById('status');
        const btn = document.getElementById('btn-enviar');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            btn.disabled = true;
            status.textContent = "Verificando e-mail...";

            const formData = new FormData(form);
            formData.append('acao', 'solicitar_recuperacao');

            try {
            
                const resposta = await fetch('../Controller/usuarioControle.php', {
                    method: 'POST',
                    body: formData
                });
                const dados = await resposta.json();

                if (!dados.sucesso) {
                    status.textContent = dados.mensagem;
                    btn.disabled = false;
                    return;
                }

              
                status.textContent = "Enviando e-mail...";
                await emailjs.send('service_3prpein', 'template_l0todu6', {
                    user_email: formData.get('user_email'),
                    link: dados.link
                });

                status.textContent = "Link de recuperação enviado! Verifique sua caixa de entrada.";
                form.reset();
            } catch (erro) {
                status.textContent = "Erro ao processar solicitação. Tente novamente.";
            } finally {
                btn.disabled = false;
            }
        });
    </script>

</body>

</html>