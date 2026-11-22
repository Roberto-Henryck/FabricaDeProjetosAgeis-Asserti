<?php
session_start();

// Bloqueia o acesso se o usuário não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para acessar esta página.'); window.location.href='login.php';</script>";
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início - Asserti</title>
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

        /* Barra Superior */
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
            transition: opacity 0.2s;
        }

        .topbar-acoes a:hover {
            opacity: 0.8;
        }

        .divisor-vertical {
            width: 1px;
            height: 30px;
            background-color: rgba(255, 255, 255, 0.4);
        }

        /* Layout Principal */
        .container-principal {
            display: flex;
            flex: 1;
        }

        /* Menu Lateral */
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
            background-color: rgba(255, 255, 255, 0.12);
        }

        .menu-divisor {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.6);
            margin: 15px 18px;
        }

        /* Área dos Cards */
        .conteudo-principal {
            flex: 1;
            padding: 30px 45px;
            background-color: #ffffff;
        }

        .grade-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px 45px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card a {
            text-decoration: none;
            color: #111111;
            display: block;
            transition: transform 0.2s;
        }

        .card a:hover {
            transform: translateY(-4px);
        }

        .card img {
            width: 100%;
            height: 145px;
            object-fit: cover;
            background-color: #0d1b2a;
            display: block;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 13px;
            font-weight: 700;
            font-style: italic;
            line-height: 1.3;
            color: #111111;
        }

        /* Ícones SVG */
        svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        /* Responsividade */
        @media (max-width: 900px) {
            .grade-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .container-principal {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
            }
            .grade-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- Barra Superior -->
    <header class="topbar">
        <div class="logo">
            <img src="../IMG/Logo.png" alt="Logo Asserti">
        </div>

        <div class="topbar-acoes">
            <a href="#notificacoes">
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

    <!-- Corpo Principal -->
    <div class="container-principal">

        <!-- Menu Lateral -->
        <aside class="sidebar">
            <nav class="menu-navegacao">
                <ul class="menu-lista">
                    <li>
                        <a href="home.php" class="ativo">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            <span>Início</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                            <span>Conteúdos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24">
                                <line x1="18" y1="20" x2="18" y2="10"/>
                                <line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6" y1="20" x2="6" y2="14"/>
                            </svg>
                            <span>Progresso</span>
                        </a>
                    </li>
                </ul>

                <hr class="menu-divisor">

                <ul class="menu-lista">
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                            <span>Exercícios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="menu-rodape">
                <a href="#">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                    </svg>
                    <span>configurações</span>
                </a>
            </div>
        </aside>

        <!-- Grade de Cursos / Conteúdos -->
        <main class="conteudo-principal">
            <section class="grade-cards">

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card1.jpg" alt="Aula Básica sobre computadores">
                        <h3>Aula Básica sobre computadores</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card2.jpg" alt="Comece a Programar do zero">
                        <h3>Comece a Programar do zero</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card3.jpg" alt="Navegando na Internet">
                        <h3>Navegando na Internet</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card4.jpg" alt="Uso de Periféricos">
                        <h3>Uso de Periféricos</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card5.jpg" alt="Entenda sobre a internet e Segurança Digital">
                        <h3>Entenda sobre a internet e Segurança Digital</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card6.jpg" alt="Informática Básica">
                        <h3>Informática Básica</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card7.jpg" alt="Exemplos de Softwares">
                        <h3>Exemplos de Softwares</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card8.jpg" alt="Software e Sistemas Operacionais">
                        <h3>Software e Sistemas Operacionais</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="#">
                        <img src="../IMG/card9.jpg" alt="Noções de Segurança">
                        <h3>Noções de Segurança</h3>
                    </a>
                </article>

            </section>
        </main>

    </div>

</body>

</html>