<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para acessar esta página.'); window.location.href='login.php';</script>";
    exit;
}

require_once __DIR__ . '/../Model/usuarioModel.php';

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Aluno Asserti';
$emailUsuario = $_SESSION['usuario_email'] ?? 'usuario@asserti.com.br';

$conclusoesUsuario = [];
try {
    $usuarioModel = new Usuario();
    $conclusoesUsuario = $usuarioModel->listarConclusoes($_SESSION['usuario_id']);
} catch (Exception $e) {
    $conclusoesUsuario = [];
}

$totalConteudos = 25;
$concluidos = min($totalConteudos, count($conclusoesUsuario));
$percentual = round(($concluidos / $totalConteudos) * 100);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Asserti</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #111111;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: #022147;
            color: #ffffff;
            height: 75px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 45px;
            width: auto;
            display: block;
        }

        .topbar-acoes {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .topbar-acoes a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .divisor-vertical {
            width: 1px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.4);
        }

        .container-principal {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 210px;
            background-color: #022147;
            color: #ffffff;
            padding: 25px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .menu-lista {
            list-style: none;
        }

        .menu-lista li a,
        .menu-rodape a {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 24px;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .menu-lista li a:hover,
        .menu-lista li a.ativo,
        .menu-rodape a:hover {
            background-color: rgba(255, 255, 255, 0.14);
        }

        .menu-divisor {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.6);
            margin: 15px 18px;
        }

        .conteudo-principal {
            flex: 1;
            padding: 32px 45px;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .cabecalho-perfil {
            margin-bottom: 20px;
        }

        .cabecalho-perfil h1 {
            font-size: 23px;
            font-weight: 800;
            font-style: italic;
            color: #022147;
            margin-bottom: 4px;
        }

        .cabecalho-perfil p {
            font-size: 13px;
            color: #365070;
        }

        .card-perfil {
            border: 1.5px solid #c5d6ea;
            border-radius: 16px;
            background-color: #f8fbff;
            padding: 26px;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .avatar-circulo {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background-color: #022147;
            color: #ffffff;
            font-size: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dados-usuario h2 {
            font-size: 20px;
            color: #022147;
            margin-bottom: 4px;
        }

        .dados-usuario p {
            font-size: 14px;
            color: #44586e;
            margin-bottom: 8px;
        }

        .tag-status {
            display: inline-block;
            background-color: #dbe8ff;
            color: #022147;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 12px;
        }

        .grade-resumo {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .card-estatistica {
            border: 1px solid #d8d8d8;
            border-radius: 14px;
            padding: 20px;
            background-color: #ffffff;
        }

        .card-estatistica span {
            font-size: 13px;
            color: #555555;
            display: block;
            margin-bottom: 6px;
        }

        .card-estatistica strong {
            font-size: 26px;
            color: #022147;
        }

        .acoes-perfil {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-perfil {
            padding: 11px 22px;
            border-radius: 22px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-primario {
            background-color: #022147;
            color: #ffffff;
        }

        .btn-secundario {
            background-color: #e6eef8;
            color: #022147;
        }

        svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }
    </style>
</head>

<body>

    <header class="topbar">
        <div class="logo">
            <img src="../IMG/Logo.png" alt="Logo Asserti">
        </div>

        <div class="topbar-acoes">
            <a href="progresso.php">
                <svg viewBox="0 0 24 24" fill="currentColor" stroke="none">
                    <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                </svg>
                <span>Notificações</span>
            </a>

            <span class="divisor-vertical"></span>

            <a href="../Controller/usuarioControle.php?acao=logout">
                <svg viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                <span>Sair</span>
            </a>
        </div>
    </header>

    <div class="container-principal">
        <aside class="sidebar">
            <nav class="menu-navegacao" aria-label="Menu principal">
                <ul class="menu-lista">
                    <li>
                        <a href="home.php">
                            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            <span>Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="conteudos.php">
                            <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            <span>Conteúdos</span>
                        </a>
                    </li>
                    <li>
                        <a href="progresso.php">
                            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                            <span>Progresso</span>
                        </a>
                    </li>
                </ul>

                <hr class="menu-divisor">

                <ul class="menu-lista">
                    <li>
                        <a href="exercicios.php">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <span>Exercícios</span>
                        </a>
                    </li>
                    <li>
                        <a href="perfil.php" class="ativo">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

          
        </aside>

        <main class="conteudo-principal">
            <header class="cabecalho-perfil">
                <h1>Meu Perfil</h1>
                <p>Informações da sua conta e resumo de aprendizagem na plataforma Asserti</p>
            </header>

            <section class="card-perfil">
                <div class="avatar-circulo">
                    <?php echo strtoupper(mb_substr($nomeUsuario, 0, 1)); ?>
                </div>
                <div class="dados-usuario">
                    <h2><?php echo htmlspecialchars($nomeUsuario); ?></h2>
                    <p><?php echo htmlspecialchars($emailUsuario); ?></p>
                    <span class="tag-status">Aluno Ativo • ID #<?php echo (int) $_SESSION['usuario_id']; ?></span>
                </div>
            </section>

            <section class="grade-resumo">
                <article class="card-estatistica">
                    <span>Conteúdos concluídos</span>
                    <strong><?php echo $concluidos; ?> de <?php echo $totalConteudos; ?></strong>
                </article>

                <article class="card-estatistica">
                    <span>Progresso geral</span>
                    <strong><?php echo $percentual; ?>%</strong>
                </article>
            </section>

            <nav class="acoes-perfil" aria-label="Ações da conta">
                <a href="progresso.php" class="btn-perfil btn-primario">Ver progresso completo</a>
                <a href="redefinir_senha.php" class="btn-perfil btn-secundario">Alterar senha</a>
            </nav>
        </main>
    </div>

</body>

</html>