

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

    .botao:hover {
        transition: transform 0.3s;
    }

    .botao:hover {
        animation: pulso 1s infinite;
        background-color: #002753;
    }


    label {
        display: flex;
        align-items: center;
        padding: 10px;
        color: white;


    }
</style>

<body>

    <nav>

        <div class="logo">
            <img src="../IMG/Logo.png" alt="" width="300px">
        </div>

    </nav>

    <main>
        <div class="conteudo">
            <h2>Seja bem vindo</h2>

           <form action="../Controller/usuarioControle.php" method="POST" class="conteudo">
                <input type="hidden" name="acao" value="login">

                <div class="campo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu Email" required>

                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>

                <a href="recuperar_senha.php">Recupere sua senha clicando aqui</a>
                <button type="submit" class="botao">Acessar</button>
            </form>

            <p><a href="Cadastro.php" class="cadastrar">Cadastre-se clicando aqui!</a></p>
        </div>
    </main>


</body>

</html>