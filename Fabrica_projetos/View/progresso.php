<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para acessar esta página.'); window.location.href='login.php';</script>";
    exit;
}

require_once __DIR__ . '/../Model/usuarioModel.php';

$conclusoesUsuario = [];
try {
    $usuarioModel = new Usuario();
    $conclusoesUsuario = $usuarioModel->listarConclusoes($_SESSION['usuario_id']);
} catch (Exception $e) {
    $conclusoesUsuario = [];
}

// Começa em 0 para contas novas e soma conforme os registros no banco
$totalConteudos = 25;
$concluidos = min($totalConteudos, count($conclusoesUsuario));
$restantes = $totalConteudos - $concluidos;
$percentualGeral = $totalConteudos > 0 ? round(($concluidos / $totalConteudos) * 100) : 0;

// Contagem dinâmica por categoria (todas iniciam em 0)
$contagemCategorias = [
    'Computador' => 0,
    'Internet' => 0,
    'E-mail' => 0,
    'Ferramentas de produtividade' => 0,
    'Segurança' => 0,
    'Serviços Públicos' => 0,
    'Outros' => 0,
];

foreach ($conclusoesUsuario as $item) {
    $cat = $item['categoria'] ?? 'Outros';
    if (isset($contagemCategorias[$cat])) {
        $contagemCategorias[$cat]++;
    } else {
        $contagemCategorias['Outros']++;
    }
}

function calcularProgressoTema($feitos, $total) {
    $feitosLimitado = min($total, $feitos);
    $pct = $total > 0 ? round(($feitosLimitado / $total) * 100) : 0;
    return ['feitos' => $feitosLimitado, 'total' => $total, 'pct' => $pct];
}

$temaComputador = calcularProgressoTema($contagemCategorias['Computador'], 5);
$temaInternet = calcularProgressoTema($contagemCategorias['Internet'], 5);
$temaEmail = calcularProgressoTema($contagemCategorias['E-mail'], 4);
$temaProdutividade = calcularProgressoTema($contagemCategorias['Ferramentas de produtividade'], 3);
$temaSeguranca = calcularProgressoTema($contagemCategorias['Segurança'], 4);
$temaServicos = calcularProgressoTema($contagemCategorias['Serviços Públicos'], 2);
$temaOutros = calcularProgressoTema($contagemCategorias['Outros'], 2);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progresso - Asserti</title>
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
            background-color: rgba(255, 255, 255, 0.14);
        }

        .menu-divisor {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.6);
            margin: 15px 18px;
        }

        /* Área Principal */
        .conteudo-principal {
            flex: 1;
            padding: 25px 45px;
            max-width: 1050px;
            margin: 0 auto;
            width: 100%;
        }

        .cabecalho-pagina {
            text-align: center;
            margin-bottom: 10px;
        }

        .cabecalho-pagina h1 {
            font-size: 23px;
            font-weight: 800;
            font-style: italic;
            color: #022147;
            margin-bottom: 4px;
        }

        .cabecalho-pagina p {
            font-size: 13px;
            color: #365070;
        }

        .linha-topo {
            border: none;
            border-top: 1px solid #8ea6c1;
            margin-bottom: 18px;
        }

        /* Card Resumo Superior */
        .card-box {
            border: 1px solid #d8d8d8;
            border-radius: 12px;
            background-color: #ffffff;
            padding: 18px 28px;
            margin-bottom: 18px;
        }

        .resumo-grid {
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Gráfico Circular */
        .grafico-donut {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: conic-gradient(#0044cc <?php echo $percentualGeral; ?>%, #dcdcdc 0);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .grafico-centro {
            width: 102px;
            height: 102px;
            border-radius: 50%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .grafico-centro strong {
            font-size: 20px;
            color: #111;
        }

        .grafico-centro span {
            font-size: 11px;
            color: #444;
        }

        .divisor-resumo {
            width: 1px;
            height: 135px;
            background-color: #d8d8d8;
        }

        .resumo-metricas {
            flex: 1;
            min-width: 260px;
            max-width: 480px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .metrica-bloco small {
            display: block;
            font-size: 13px;
            color: #222;
            margin-bottom: 6px;
        }

        .metrica-linha {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .icone-quadrado {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bg-azul { background-color: #dbe8ff; color: #0044cc; border: 1px solid #b6d0ff; }
        .bg-verde { background-color: #dcf7e3; color: #1f9d45; border: 1px solid #b5ebc4; }
        .bg-roxo { background-color: #eadfff; color: #6a28d9; border: 1px solid #d3beff; }
        .bg-laranja { background-color: #ffedd5; color: #d97706; border: 1px solid #fed7aa; }
        .bg-rosa { background-color: #ffe2e8; color: #d62856; border: 1px solid #ffc2cf; }
        .bg-ciano { background-color: #d8f3f8; color: #0e7490; border: 1px solid #b2e5ef; }

        .metrica-texto strong {
            font-size: 20px;
            display: block;
            color: #111;
        }

        .metrica-texto span {
            font-size: 11px;
            color: #555;
        }

        .divisor-metrica {
            border: none;
            border-top: 1px solid #e0e0e0;
        }

        /* Seção Progresso por Temas */
        .secao-titulo {
            font-size: 15px;
            font-weight: 700;
            color: #022147;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lista-temas {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tema-linha {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .tema-icone {
            width: 34px;
            height: 34px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .barra-fundo {
            flex: 1;
            height: 7px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .barra-preenchida {
            height: 100%;
            background-color: #0044cc;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .tema-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 92px;
            justify-content: flex-end;
            font-size: 11px;
        }

        .tema-stats strong {
            color: #111;
            font-size: 12px;
        }

        .tema-stats span {
            color: #555;
        }

        /* Atividades Recentes */
        .link-acao {
            font-size: 12px;
            color: #0044cc;
            text-decoration: none;
            font-weight: normal;
        }

        .atividade-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 10px 0;
        }

        .atividade-item + .atividade-item {
            border-top: 1px solid #ececec;
        }

        .atividade-esquerda {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .atividade-info strong {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #111;
            margin-bottom: 2px;
        }

        .atividade-info span {
            font-size: 11px;
            color: #666;
        }

        .atividade-data {
            font-size: 11px;
            color: #666;
            white-space: nowrap;
        }

        .estado-vazio {
            text-align: center;
            padding: 14px 10px;
            font-size: 13px;
            color: #666666;
        }

        .estado-vazio a {
            color: #0044cc;
            text-decoration: none;
            font-weight: bold;
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

    <div class="container-principal">
        <aside class="sidebar">
            <nav class="menu-navegacao">
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
                        <a href="progresso.php" class="ativo">
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
                        <a href="admin_conteudos.php">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </aside>

        <main class="conteudo-principal">
            <div class="cabecalho-pagina">
                <h1>Acompanhamento do progresso</h1>
                <p>Veja seu avanço nos conteúdos e mantenha sua rotina de estudos em dia</p>
            </div>

            <hr class="linha-topo">

         
            <section class="card-box">
                <div class="resumo-grid">
                    <div class="grafico-donut">
                        <div class="grafico-centro">
                            <strong><?php echo $percentualGeral; ?>%</strong>
                            <span>Concluído</span>
                        </div>
                    </div>

                    <div class="divisor-resumo"></div>

                    <div class="resumo-metricas">
                        <div class="metrica-bloco">
                            <small>Conteúdos concluídos</small>
                            <div class="metrica-linha">
                                <div class="icone-quadrado bg-azul">
                                    <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                </div>
                                <div class="metrica-texto">
                                    <strong><?php echo $concluidos; ?> de <?php echo $totalConteudos; ?></strong>
                                    <span>Conteúdos</span>
                                </div>
                            </div>
                        </div>

                        <hr class="divisor-metrica">

                        <div class="metrica-bloco">
                            <small>Conteúdos restantes</small>
                            <div class="metrica-linha">
                                <div class="icone-quadrado bg-verde">
                                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <div class="metrica-texto">
                                    <strong><?php echo $restantes; ?> de <?php echo $totalConteudos; ?></strong>
                                    <span>Conteúdos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

           
            <div class="secao-titulo">
                <span>Progresso por temas</span>
                <a href="registrar_conclusao.php" class="link-acao">+ Registrar conclusão</a>
            </div>

            <section class="card-box lista-temas">
                <div class="tema-linha">
                    <div class="tema-icone bg-azul">
                        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaComputador['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaComputador['pct']; ?>%</strong><span><?php echo $temaComputador['feitos']; ?> de <?php echo $temaComputador['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-verde">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaInternet['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaInternet['pct']; ?>%</strong><span><?php echo $temaInternet['feitos']; ?> de <?php echo $temaInternet['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-roxo">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaEmail['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaEmail['pct']; ?>%</strong><span><?php echo $temaEmail['feitos']; ?> de <?php echo $temaEmail['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-laranja">
                        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaProdutividade['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaProdutividade['pct']; ?>%</strong><span><?php echo $temaProdutividade['feitos']; ?> de <?php echo $temaProdutividade['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-rosa">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaSeguranca['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaSeguranca['pct']; ?>%</strong><span><?php echo $temaSeguranca['feitos']; ?> de <?php echo $temaSeguranca['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-ciano">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 22 7 12 2"/><line x1="4" y1="22" x2="20" y2="22"/><line x1="6" y1="7" x2="6" y2="22"/><line x1="12" y1="7" x2="12" y2="22"/><line x1="18" y1="7" x2="18" y2="22"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaServicos['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaServicos['pct']; ?>%</strong><span><?php echo $temaServicos['feitos']; ?> de <?php echo $temaServicos['total']; ?> &gt;</span></div>
                </div>

                <div class="tema-linha">
                    <div class="tema-icone bg-rosa">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="barra-fundo"><div class="barra-preenchida" style="width: <?php echo $temaOutros['pct']; ?>%;"></div></div>
                    <div class="tema-stats"><strong><?php echo $temaOutros['pct']; ?>%</strong><span><?php echo $temaOutros['feitos']; ?> de <?php echo $temaOutros['total']; ?> &gt;</span></div>
                </div>
            </section>

            <div class="secao-titulo">
                <span>Atividades recentes</span>
                <a href="conteudos.php" class="link-acao">Ver todos &gt;</a>
            </div>

            <section class="card-box">
                <?php if (empty($conclusoesUsuario)): ?>
                    <p class="estado-vazio">
                        Você ainda não concluiu nenhum conteúdo. <a href="conteudos.php">Começar a estudar agora →</a>
                    </p>
                <?php else: ?>
                    <?php foreach ($conclusoesUsuario as $item): ?>
                        <div class="atividade-item">
                            <div class="atividade-esquerda">
                                <div class="icone-quadrado bg-verde">
                                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                                <div class="atividade-info">
                                    <strong>Você concluiu “<?php echo htmlspecialchars($item['conteudo']); ?>”</strong>
                                    <span><?php echo htmlspecialchars($item['categoria']); ?></span>
                                </div>
                            </div>
                            <span class="atividade-data"><?php echo date('d/m/Y', strtotime($item['data_conclusao'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
    </div>

</body>

</html>