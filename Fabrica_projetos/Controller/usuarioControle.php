<?php
session_start();
require_once '../Model/usuarioModel.php';

$usuarioModel = new Usuario();
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

// 1. FLUXO DE CADASTRO
if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');

    if ($senha !== $confirmarSenha) {
        echo "<script>alert('As senhas não coincidem!'); history.back();</script>";
        exit;
    }

    $sucesso = $usuarioModel->cadastrar($nome, $email, $senha, $telefone);

    if ($sucesso) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='../View/login.html';</script>";
    } else {
        echo "<script>alert('Erro: Este e-mail já está cadastrado.'); history.back();</script>";
    }
    exit;
}


if ($acao === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuario = $usuarioModel->buscarPorEmail($email);


    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];


        echo "<script>alert('Bem-vindo, " . addslashes($usuario['nome']) . "!'); window.location.href='../View/home.php';</script>";
    } else {
        echo "<script>alert('E-mail ou senha inválidos!'); history.back();</script>";
    }
    exit;
}


if ($acao === 'logout') {
    session_destroy();
    header('Location: ../View/login.php');
    exit;
}

// 4. SOLICITAR RECUPERAÇÃO DE SENHA (Chamado via fetch pelo JS)
if ($acao === 'solicitar_recuperacao' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $email = trim($_POST['user_email'] ?? '');

    // Gera um token único de 64 caracteres e define validade de 1 hora
    $token = bin2hex(random_bytes(32));
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

    if ($usuarioModel->salvarTokenRecuperacao($email, $token, $expiracao)) {
        // Monta o link completo apontando para a página protegida
        $link = "http://localhost/FabricaDeProjetosAgeis-Asserti/Fabrica_projetos/View/redefinir_senha.php?token=" . $token;
        echo json_encode(['sucesso' => true, 'link' => $link]);
    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'E-mail não encontrado no sistema.']);
    }
    exit;
}

// 5. SALVAR A NOVA SENHA (Enviado pelo formulário de redefinir_senha.php)
if ($acao === 'redefinir_senha' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($novaSenha !== $confirmarSenha) {
        echo "<script>alert('As senhas não coincidem!'); history.back();</script>";
        exit;
    }

    $usuario = $usuarioModel->buscarPorToken($token);

    if ($usuario) {
        $usuarioModel->atualizarSenha($usuario['id'], $novaSenha);
        echo "<script>alert('Senha alterada com sucesso!'); window.location.href='../View/login.php';</script>";
    } else {
        echo "<script>alert('Link inválido ou expirado!'); window.location.href='../View/recuperar_senha.php';</script>";
    }
    exit;
}

// 6. REGISTRAR CONTEÚDO CONCLUÍDO
if ($acao === 'registrar_conclusao' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../View/login.php');
        exit;
    }

    $usuarioId = $_SESSION['usuario_id'];
    $conteudo = trim($_POST['conteudo'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $dataConclusao = $_POST['data_conclusao'] ?? date('Y-m-d');
    $observacoes = trim($_POST['observacoes'] ?? '');

    if ($usuarioModel->registrarConclusao($usuarioId, $conteudo, $categoria, $dataConclusao, $observacoes)) {
        echo "<script>alert('Conteúdo registrado como concluído!'); window.location.href='../View/progresso.php';</script>";
    } else {
        echo "<script>alert('Erro ao registrar conclusão.'); history.back();</script>";
    }
    exit;
}