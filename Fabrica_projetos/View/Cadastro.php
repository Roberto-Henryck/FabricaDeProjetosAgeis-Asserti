<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>

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

    .conteudo {

        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 0 auto;
        gap: 30px;
        align-items: center;
    }

    h2 {
        display: flex;
        color: white;
        font-size: 30px;


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
        font: 10px;
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
    }

    label {
        display: flex;
        align-items: center;
        padding: 10px;
        color: white;


    }

    .cadastrar {
        transition: transform 0.5s;

    }

    .cadastrar:hover {
        animation: pulso 1s infinite;
    }

    @keyframes pulso {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }

    }

    .pulsar {
        transition: transform 0.5s;
    }

    .pulsar:hover {
        animation: pulso 1s infinite;
    }

    @keyframes pulso {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<body>
    <nav>

        <div class="logo">
            <img src="../IMG/Logo.png" alt="" width="300px">
        </div>

    </nav>


    <div class="conteudo">
        <h2>Cadastrar</h2>

        <form action="../Controller/usuarioControle.php" method="POST" class="conteudo">
            <input type="hidden" name="acao" value="cadastrar">

            <div class="campo">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu Email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

                <label for="confirmar_senha">Confirmar senha</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha"
                    required>

                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Digite seu telefone" required>
            </div>

            <button type="submit" class="botao">Cadastrar</button>
        </form>

        <p><a href="login.php" class="cadastrar">Já possui conta? Faça login clicando aqui</a></p>
    </div>
</body>

</html>