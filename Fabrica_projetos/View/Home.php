<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para acessar esta página.'); window.location.href='login.php';</script>";
    exit;
}

$nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';

function gerarCapaSvg($numero) {
    $capas = [
        1 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#022147"/><stop offset="100%" stop-color="#0d47a1"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g1)"/>
                <circle cx="340" cy="40" r="70" fill="#1976d2" opacity="0.22"/>
                <rect x="115" y="34" width="170" height="106" rx="10" fill="#08162b" stroke="#64b5f6" stroke-width="4"/>
                <rect x="127" y="46" width="146" height="82" rx="4" fill="#1e88e5"/>
                <rect x="140" y="60" width="65" height="10" rx="3" fill="#ffffff" opacity="0.9"/>
                <rect x="140" y="78" width="115" height="8" rx="3" fill="#bbdefb" opacity="0.8"/>
                <rect x="140" y="94" width="90" height="8" rx="3" fill="#bbdefb" opacity="0.6"/>
                <rect x="184" y="140" width="32" height="20" fill="#90caf9"/>
                <rect x="155" y="160" width="90" height="8" rx="4" fill="#e3f2fd"/>
                <rect x="125" y="178" width="115" height="14" rx="4" fill="#1565c0" stroke="#90caf9" stroke-width="2"/>
                <rect x="255" y="175" width="22" height="20" rx="9" fill="#42a5f5" stroke="#e3f2fd" stroke-width="2"/>
              </svg>',
        2 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g2" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#071930"/><stop offset="100%" stop-color="#0a3871"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g2)"/>
                <rect x="75" y="30" width="250" height="160" rx="12" fill="#0b132b" stroke="#3a86ff" stroke-width="3"/>
                <rect x="75" y="30" width="250" height="26" rx="12" fill="#1c2541"/>
                <circle cx="95" cy="43" r="5" fill="#ff5f56"/><circle cx="111" cy="43" r="5" fill="#ffbd2e"/><circle cx="127" cy="43" r="5" fill="#27c93f"/>
                <text x="155" y="122" fill="#4cc9f0" font-family="monospace" font-size="38" font-weight="bold">&lt;/&gt;</text>
                <rect x="100" y="75" width="85" height="8" rx="4" fill="#4895ef"/>
                <rect x="115" y="146" width="140" height="8" rx="4" fill="#4cc9f0" opacity="0.8"/>
                <rect x="100" y="164" width="105" height="8" rx="4" fill="#f72585" opacity="0.85"/>
              </svg>',
        3 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g3" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#012a4a"/><stop offset="100%" stop-color="#014f86"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g3)"/>
                <circle cx="200" cy="110" r="68" fill="#0a2540" stroke="#4cc9f0" stroke-width="4"/>
                <ellipse cx="200" cy="110" rx="34" ry="68" fill="none" stroke="#4cc9f0" stroke-width="3"/>
                <line x1="132" y1="110" x2="268" y2="110" stroke="#4cc9f0" stroke-width="3"/>
                <path d="M144 76 Q200 92 256 76" fill="none" stroke="#90e0ef" stroke-width="2.5"/>
                <path d="M144 144 Q200 128 256 144" fill="none" stroke="#90e0ef" stroke-width="2.5"/>
                <rect x="115" y="24" width="170" height="24" rx="12" fill="#ffffff"/>
                <circle cx="131" cy="36" r="5" fill="#2ec4b6"/>
                <text x="144" y="40" fill="#022147" font-family="sans-serif" font-size="11" font-weight="bold">https://www.asserti.br</text>
              </svg>',
        4 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g4" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#0d1b2a"/><stop offset="100%" stop-color="#1b263b"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g4)"/>
                <rect x="65" y="88" width="165" height="68" rx="10" fill="#1e6091" stroke="#90e0ef" stroke-width="3"/>
                <rect x="80" y="102" width="22" height="14" rx="3" fill="#caf0f8"/><rect x="108" y="102" width="22" height="14" rx="3" fill="#caf0f8"/>
                <rect x="136" y="102" width="22" height="14" rx="3" fill="#caf0f8"/><rect x="164" y="102" width="22" height="14" rx="3" fill="#caf0f8"/>
                <rect x="192" y="102" width="22" height="14" rx="3" fill="#caf0f8"/>
                <rect x="95" y="126" width="105" height="14" rx="4" fill="#ffffff"/>
                <rect x="268" y="72" width="54" height="88" rx="27" fill="#0077b6" stroke="#caf0f8" stroke-width="3"/>
                <line x1="295" y1="72" x2="295" y2="110" stroke="#caf0f8" stroke-width="2.5"/>
                <rect x="291" y="84" width="8" height="16" rx="4" fill="#ffffff"/>
              </svg>',
        5 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g5" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#022147"/><stop offset="100%" stop-color="#003566"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g5)"/>
                <circle cx="95" cy="65" r="14" fill="#00b4d8" opacity="0.5"/><circle cx="310" cy="60" r="18" fill="#00b4d8" opacity="0.4"/>
                <circle cx="85" cy="165" r="16" fill="#48cae4" opacity="0.4"/><circle cx="315" cy="160" r="14" fill="#48cae4" opacity="0.5"/>
                <line x1="95" y1="65" x2="200" y2="115" stroke="#48cae4" stroke-width="2" stroke-dasharray="5,5"/>
                <line x1="310" y1="60" x2="200" y2="115" stroke="#48cae4" stroke-width="2" stroke-dasharray="5,5"/>
                <line x1="85" y1="165" x2="200" y2="115" stroke="#48cae4" stroke-width="2" stroke-dasharray="5,5"/>
                <line x1="315" y1="160" x2="200" y2="115" stroke="#48cae4" stroke-width="2" stroke-dasharray="5,5"/>
                <rect x="162" y="96" width="76" height="64" rx="12" fill="#0096c7" stroke="#ffffff" stroke-width="3"/>
                <path d="M178 96 V76 A22 22 0 0 1 222 76 V96" fill="none" stroke="#ffffff" stroke-width="6" stroke-linecap="round"/>
                <circle cx="200" cy="124" r="7" fill="#022147"/>
                <rect x="197" y="128" width="6" height="14" rx="3" fill="#022147"/>
              </svg>',
        6 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g6" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#031d44"/><stop offset="100%" stop-color="#04395e"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g6)"/>
                <path d="M95 75 H155 L170 90 H230 V165 H95 Z" fill="#ffb703" stroke="#ffffff" stroke-width="2.5"/>
                <rect x="195" y="55" width="110" height="125" rx="8" fill="#ffffff" stroke="#90e0ef" stroke-width="3"/>
                <rect x="212" y="76" width="76" height="10" rx="4" fill="#023e8a"/>
                <rect x="212" y="96" width="62" height="8" rx="4" fill="#48cae4"/>
                <rect x="212" y="114" width="70" height="8" rx="4" fill="#48cae4"/>
                <rect x="212" y="132" width="50" height="8" rx="4" fill="#90e0ef"/>
              </svg>',
        7 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g7" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#0a192f"/><stop offset="100%" stop-color="#172a45"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g7)"/>
                <rect x="92" y="42" width="92" height="62" rx="12" fill="#1e88e5"/><text x="138" y="81" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="24" font-weight="bold">DOC</text>
                <rect x="216" y="42" width="92" height="62" rx="12" fill="#2e7d32"/><text x="262" y="81" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="24" font-weight="bold">XLS</text>
                <rect x="92" y="118" width="92" height="62" rx="12" fill="#ef6c00"/><text x="138" y="157" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="24" font-weight="bold">PDF</text>
                <rect x="216" y="118" width="92" height="62" rx="12" fill="#6a1b9a"/><text x="262" y="157" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="24" font-weight="bold">APP</text>
              </svg>',
        8 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g8" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#022147"/><stop offset="100%" stop-color="#144552"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g8)"/>
                <rect x="85" y="36" width="230" height="148" rx="10" fill="#0b2545" stroke="#64dfdf" stroke-width="3"/>
                <rect x="85" y="160" width="230" height="24" rx="4" fill="#134074"/>
                <rect x="95" y="165" width="14" height="14" rx="2" fill="#80ffdb"/>
                <rect x="115" y="56" width="52" height="52" rx="4" fill="#4ea8de"/>
                <rect x="175" y="56" width="52" height="52" rx="4" fill="#5390d9"/>
                <rect x="115" y="116" width="52" height="32" rx="4" fill="#64dfdf"/>
                <rect x="175" y="116" width="52" height="32" rx="4" fill="#72efdd"/>
                <circle cx="268" cy="102" r="24" fill="none" stroke="#80ffdb" stroke-width="6" stroke-dasharray="10,6"/>
              </svg>',
        9 => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 220">
                <defs><linearGradient id="g9" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#03045e"/><stop offset="100%" stop-color="#023e8a"/></linearGradient></defs>
                <rect width="400" height="220" fill="url(#g9)"/>
                <path d="M200 32 L272 62 V116 C272 162 200 190 200 190 C200 190 128 162 128 116 V62 Z" fill="#0077b6" stroke="#90e0ef" stroke-width="4"/>
                <path d="M200 48 L256 72 V114 C256 150 200 173 200 173 C200 173 144 150 144 114 V72 Z" fill="#022147"/>
                <polyline points="175,112 193,130 228,92" fill="none" stroke="#4cc9f0" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>'
    ];

    $svg = $capas[$numero] ?? $capas[1];
    return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
}
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

    <!-- Corpo Principal -->
    <div class="container-principal">

        <!-- Menu Lateral -->
        <aside class="sidebar">
            <nav class="menu-navegacao" aria-label="Menu principal">
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
                        <a href="conteudos.php">
                            <svg viewBox="0 0 24 24">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                            <span>Conteúdos</span>
                        </a>
                    </li>
                    <li>
                        <a href="progresso.php">
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
                        <a href="exercicios.php">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                <line x1="12" y1="17" x2="12.01" y2="17"/>
                            </svg>
                            <span>Exercícios</span>
                        </a>
                    </li>
                    <li>
                        <a href="perfil.php">
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
          
        </aside>

      
        <main class="conteudo-principal">
            <section class="grade-cards" aria-label="Conteúdos em destaque">

                <article class="card">
                    <a href="conteudos.php?modulo=computador_basico">
                        <img src="<?php echo gerarCapaSvg(1); ?>" alt="Aula Básica sobre computadores">
                        <h3>Aula Básica sobre computadores</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=computador_basico">
                        <img src="<?php echo gerarCapaSvg(2); ?>" alt="Comece a Programar do zero">
                        <h3>Comece a Programar do zero</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=navegadores">
                        <img src="<?php echo gerarCapaSvg(3); ?>" alt="Navegando na Internet">
                        <h3>Navegando na Internet</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=computador_basico">
                        <img src="<?php echo gerarCapaSvg(4); ?>" alt="Uso de Periféricos">
                        <h3>Uso de Periféricos</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=seguranca">
                        <img src="<?php echo gerarCapaSvg(5); ?>" alt="Entenda sobre a internet e Segurança Digital">
                        <h3>Entenda sobre a internet e Segurança Digital</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=computador_basico">
                        <img src="<?php echo gerarCapaSvg(6); ?>" alt="Informática Básica">
                        <h3>Informática Básica</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=email">
                        <img src="<?php echo gerarCapaSvg(7); ?>" alt="Exemplos de Softwares">
                        <h3>Exemplos de Softwares</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=servicos_publicos">
                        <img src="<?php echo gerarCapaSvg(8); ?>" alt="Software e Sistemas Operacionais">
                        <h3>Software e Sistemas Operacionais</h3>
                    </a>
                </article>

                <article class="card">
                    <a href="conteudos.php?modulo=seguranca">
                        <img src="<?php echo gerarCapaSvg(9); ?>" alt="Noções de Segurança">
                        <h3>Noções de Segurança</h3>
                    </a>
                </article>

            </section>
        </main>

    </div>

</body>

</html>