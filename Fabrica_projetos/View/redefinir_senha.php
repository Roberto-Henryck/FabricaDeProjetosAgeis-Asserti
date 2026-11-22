<?php
require_once __DIR__ . '/../Model/usuarioModel.php';

$token = $_GET['token'] ?? '';
$usuarioModel = new Usuario();
$usuario = !empty($token) ? $usuarioModel->buscarPorToken($token) : false;

// Bloqueia o acesso se não houver token na URL ou se ele já expirou / foi usado
if (!$usuario) {
    echo "<script>alert('Acesso negado: link inválido ou expirado.'); window.location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
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
        margin-top: 80px;
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
            <h1>Criar nova senha</h1>

            <form action="../Controller/usuarioControle.php" method="POST" class="conteudo">
                <input type="hidden" name="acao" value="redefinir_senha">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                <div class="campo">
                    <label for="nova_senha">Nova senha</label>
                    <input type="password" id="nova_senha" name="nova_senha" placeholder="Digite sua nova senha" required>

                    <label for="confirmar_senha">Confirmar nova senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua nova senha" required>
                </div>

                <button type="submit" class="botao">Salvar nova senha</button>
            </form>
        </div>
    </main>

</body>

</html>