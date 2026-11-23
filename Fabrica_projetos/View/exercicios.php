<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para acessar esta página.'); window.location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercícios - Asserti</title>
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
            padding: 28px 45px;
            max-width: 1020px;
            margin: 0 auto;
            width: 100%;
        }

        /* TELA 1: SELEÇÃO DE TEMA DE EXERCÍCIO */
        .selecao-cabecalho {
            text-align: center;
            margin-bottom: 14px;
        }

        .selecao-cabecalho h1 {
            font-size: 23px;
            font-weight: 800;
            font-style: italic;
            color: #022147;
            margin-bottom: 4px;
        }

        .selecao-cabecalho p {
            font-size: 13px;
            color: #365070;
        }

        .linha-topo {
            border: none;
            border-top: 1px solid #8ea6c1;
            margin-bottom: 24px;
        }

        .grade-exercicios {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .card-tema-quiz {
            background-color: #f4f8fd;
            border: 1.5px solid #b8d0eb;
            border-radius: 16px;
            padding: 20px 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 14px;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s, background-color 0.2s;
        }

        .card-tema-quiz:hover {
            transform: translateY(-3px);
            border-color: #022147;
            background-color: #e8f1fc;
        }

        .card-tema-topo {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .tema-badge-icone {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background-color: #022147;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .card-tema-quiz h2 {
            font-size: 16px;
            color: #022147;
            margin-bottom: 4px;
        }

        .card-tema-quiz p {
            font-size: 13px;
            color: #44586e;
            line-height: 1.4;
        }

        .card-tema-rodape {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #d7e4f2;
            padding-top: 10px;
            font-size: 12px;
            color: #164878;
            font-weight: bold;
        }

        .card-tema-quiz.destaque-misto {
            background-color: #022147;
            border-color: #022147;
            color: #ffffff;
        }

        .card-tema-quiz.destaque-misto:hover {
            background-color: #032d61;
        }

        .card-tema-quiz.destaque-misto .tema-badge-icone {
            background-color: #0044ff;
        }

        .card-tema-quiz.destaque-misto h2,
        .card-tema-quiz.destaque-misto .card-tema-rodape {
            color: #ffffff;
        }

        .card-tema-quiz.destaque-misto p {
            color: #d6e4f5;
        }

        .card-tema-quiz.destaque-misto .card-tema-rodape {
            border-top-color: rgba(255, 255, 255, 0.25);
        }

        /* TELA 2: QUIZ (LAYOUT FIGMA) */
        .quiz-container {
            display: none;
        }

        .barra-voltar-tema {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .btn-trocar-tema {
            background: none;
            border: 1px solid #164878;
            color: #164878;
            border-radius: 16px;
            padding: 6px 14px;
            font-size: 12px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-trocar-tema:hover {
            background-color: #eef4fc;
        }

        .tag-tema-atual {
            background-color: #dbe8ff;
            color: #022147;
            padding: 5px 14px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: bold;
        }

        .quiz-cabecalho {
            margin-bottom: 18px;
        }

        .quiz-titulo-linha {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .quiz-titulo-linha h1 {
            font-size: 22px;
            font-weight: 800;
            font-style: italic;
            color: #022147;
        }

        .quiz-pontos {
            font-size: 13px;
            font-weight: 600;
            color: #1a56db;
            padding-right: 45px;
        }

        .quiz-contador {
            display: block;
            font-size: 12px;
            color: #555555;
            margin-bottom: 10px;
        }

        .barra-progresso-quiz {
            width: 100%;
            height: 8px;
            background-color: #b5b5b5;
            overflow: hidden;
            margin-bottom: 14px;
        }

        .barra-progresso-preenchida {
            height: 100%;
            background-color: #0033cc;
            width: 25%;
            transition: width 0.3s ease;
        }

        .instrucao-topo {
            font-size: 11px;
            color: #777777;
        }

        /* Corpo da Pergunta */
        .quiz-corpo {
            margin-top: 12px;
        }

        .pergunta-enunciado {
            font-size: 26px;
            font-weight: 500;
            color: #164878;
            line-height: 1.3;
            max-width: 580px;
            margin-bottom: 8px;
        }

        .instrucao-sub {
            font-size: 13px;
            color: #444444;
            margin-bottom: 20px;
        }

        .quiz-grid {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 32px;
            flex-wrap: wrap;
        }

        /* Lista Semântica de Alternativas */
        .alternativas-fieldset {
            border: none;
            flex: 1;
            min-width: 300px;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
        }

        .alternativa-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background-color: #f3f3f3;
            border: 1.5px solid #222222;
            border-radius: 18px;
            padding: 14px 20px;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s;
            min-height: 62px;
        }

        .alternativa-item:hover {
            background-color: #e8eefc;
        }

        .alternativa-item input[type="radio"] {
            display: none;
        }

        .alternativa-esquerda {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .radio-indicador {
            width: 34px;
            height: 24px;
            border-radius: 14px;
            border: 2px solid #111111;
            background-color: transparent;
            flex-shrink: 0;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .alternativa-texto {
            font-size: 15px;
            color: #164878;
            line-height: 1.35;
        }

        .check-selecionado {
            width: 36px;
            height: 24px;
            border-radius: 14px;
            background-color: #0044ff;
            color: #ffffff;
            display: none;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Estado Selecionado */
        .alternativa-item.selecionada {
            background-color: #6b8cff;
            border-color: #2c4cb8;
        }

        .alternativa-item.selecionada .radio-indicador {
            background-color: #022147;
            border-color: #022147;
        }

        .alternativa-item.selecionada .alternativa-texto {
            color: #081c3a;
            font-weight: 500;
        }

        .alternativa-item.selecionada .check-selecionado {
            display: flex;
        }

        /* Cartão Lateral de Dicas */
        .card-dicas {
            width: 310px;
            min-height: 235px;
            background-color: #02387a;
            color: #ffffff;
            border-radius: 14px;
            padding: 24px 22px;
            display: flex;
            flex-direction: column;
            gap: 28px;
            flex-shrink: 0;
        }

        .card-dicas h2 {
            text-align: center;
            font-size: 19px;
            font-weight: 400;
        }

        .dica-conteudo {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .dica-icone-circulo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #011c3d;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dica-conteudo p {
            font-size: 14px;
            line-height: 1.45;
            color: #f0f4fa;
        }

        /* Rodapé com Botões Anterior e Próxima */
        .quiz-navegacao {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 65px;
            margin-top: 32px;
            max-width: 680px;
        }

        .btn-quiz {
            width: 225px;
            height: 46px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-quiz:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .btn-anterior {
            background-color: #ffffff;
            color: #164878;
            border: 1.5px solid #1a56db;
        }

        .btn-proxima {
            background-color: #022147;
            color: #ffffff;
            border: 1.5px solid #0044ff;
        }

        .seta-circulo-escuro {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #022147;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .seta-circulo-claro {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* TELA 3: RESULTADO FINAL DO QUIZ */
        .resultado-box {
            display: none;
            max-width: 680px;
            margin: 20px auto;
            border: 1.5px solid #b8d0eb;
            border-radius: 18px;
            background-color: #f8fbff;
            padding: 30px;
            text-align: center;
        }

        .resultado-box h2 {
            font-size: 24px;
            color: #022147;
            margin-bottom: 8px;
        }

        .resultado-placar {
            font-size: 36px;
            font-weight: 800;
            color: #0044cc;
            margin: 14px 0;
        }

        .resultado-detalhes {
            text-align: left;
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .resumo-questao-item {
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            border: 1px solid #d5e0ec;
            background-color: #ffffff;
        }

        .resumo-questao-item.acerto {
            border-left: 5px solid #24b34b;
        }

        .resumo-questao-item.erro {
            border-left: 5px solid #d93025;
        }

        .resultado-acoes {
            display: flex;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .btn-resultado {
            padding: 11px 22px;
            border-radius: 22px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .btn-refazer {
            background-color: #022147;
            color: #ffffff;
        }

        .btn-outro-tema {
            background-color: #dcdcdc;
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

        @media (max-width: 780px) {
            .grade-exercicios {
                grid-template-columns: 1fr;
            }
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
                        <a href="exercicios.php" class="ativo">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            <span>Exercícios</span>
                        </a>
                    </li>
                    <li>
                        <a href="perfil.php">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

         
        </aside>

        <main class="conteudo-principal">

          
            <section id="telaSelecao">
                <header class="selecao-cabecalho">
                    <h1>Exercícios e Prática</h1>
                    <p>Escolha o tema que você deseja praticar agora</p>
                </header>

                <hr class="linha-topo">

                <div class="grade-exercicios">
                    <article class="card-tema-quiz" onclick="iniciarQuiz('computador')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                </div>
                                <h2>Uso Básico do Computador</h2>
                            </div>
                            <p style="margin-top: 10px;">Pratique conceitos sobre mouse, teclado, atalhos, pastas e funcionamento do Windows.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>6 perguntas no banco • 4 por rodada</span>
                            <span>Iniciar &gt;</span>
                        </div>
                    </article>

                    <article class="card-tema-quiz" onclick="iniciarQuiz('navegadores')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                </div>
                                <h2>Navegadores e Busca</h2>
                            </div>
                            <p style="margin-top: 10px;">Teste seus conhecimentos sobre pesquisas no Google, abas, links e navegação segura.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>6 perguntas no banco • 4 por rodada</span>
                            <span>Iniciar &gt;</span>
                        </div>
                    </article>

                    <article class="card-tema-quiz" onclick="iniciarQuiz('email')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </div>
                                <h2>Criando e Usando seu E-mail</h2>
                            </div>
                            <p style="margin-top: 10px;">Questões sobre envio de mensagens, anexos, caixa de entrada, spam e organização.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>6 perguntas no banco • 4 por rodada</span>
                            <span>Iniciar &gt;</span>
                        </div>
                    </article>

                    <article class="card-tema-quiz" onclick="iniciarQuiz('seguranca')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <h2>Proteja Seus Dados</h2>
                            </div>
                            <p style="margin-top: 10px;">Aprenda a identificar golpes virtuais, criar senhas fortes e proteger suas contas.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>6 perguntas no banco • 4 por rodada</span>
                            <span>Iniciar &gt;</span>
                        </div>
                    </article>

                    <article class="card-tema-quiz" onclick="iniciarQuiz('servicos')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 22 7 12 2"/><line x1="4" y1="22" x2="20" y2="22"/><line x1="6" y1="7" x2="6" y2="22"/><line x1="12" y1="7" x2="12" y2="22"/><line x1="18" y1="7" x2="18" y2="22"/></svg>
                                </div>
                                <h2>Acesse Serviços Públicos</h2>
                            </div>
                            <p style="margin-top: 10px;">Pratique sobre acesso ao portal Gov.br, níveis de conta e documentos digitais.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>6 perguntas no banco • 4 por rodada</span>
                            <span>Iniciar &gt;</span>
                        </div>
                    </article>

                    <article class="card-tema-quiz destaque-misto" onclick="iniciarQuiz('misto')">
                        <div>
                            <div class="card-tema-topo">
                                <div class="tema-badge-icone">
                                    <svg viewBox="0 0 24 24"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/><line x1="4" y1="4" x2="9" y2="9"/></svg>
                                </div>
                                <h2>Desafio Geral (Aleatório)</h2>
                            </div>
                            <p style="margin-top: 10px;">Sorteia perguntas misturadas de todos os módulos da plataforma Asserti.</p>
                        </div>
                        <div class="card-tema-rodape">
                            <span>30 perguntas no banco • 4 por rodada</span>
                            <span>Sortear Quiz &gt;</span>
                        </div>
                    </article>
                </div>
            </section>

          
            <section id="telaQuiz" class="quiz-container">
                <div class="barra-voltar-tema">
                    <button type="button" class="btn-trocar-tema" onclick="voltarSelecao()">← Escolher outro exercício</button>
                    <span class="tag-tema-atual" id="nomeTemaAtual">Tema</span>
                </div>

                <header class="quiz-cabecalho">
                    <div class="quiz-titulo-linha">
                        <h1>Perguntas e Respostas</h1>
                        <span class="quiz-pontos" id="pontuacaoTexto">0 pts</span>
                    </div>
                    <span class="quiz-contador" id="contadorPergunta">Perguntas 1 de 4</span>

                    <div class="barra-progresso-quiz" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="25">
                        <div class="barra-progresso-preenchida" id="barraProgresso"></div>
                    </div>

                    <p class="instrucao-topo">Selecione a alternativa correta.</p>
                </header>

                <article class="quiz-corpo">
                    <h2 class="pergunta-enunciado" id="textoPergunta">Carregando pergunta...</h2>
                    <p class="instrucao-sub">Seleciona a alternativa correta.</p>

                    <div class="quiz-grid">
                        <fieldset class="alternativas-fieldset" id="listaAlternativas">
                            <legend class="sr-only">Alternativas de resposta</legend>
                        </fieldset>

                        <aside class="card-dicas" aria-label="Dica da pergunta">
                            <h2>Dicas</h2>
                            <div class="dica-conteudo">
                                <div class="dica-icone-circulo">
                                    <svg viewBox="0 0 24 24" stroke="#ffffff">
                                        <path d="M9 18h6"/>
                                        <path d="M10 22h4"/>
                                        <path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/>
                                    </svg>
                                </div>
                                <p id="textoDica"></p>
                            </div>
                        </aside>
                    </div>

                    <footer class="quiz-navegacao">
                        <button type="button" class="btn-quiz btn-anterior" id="btnAnterior" onclick="navegarPergunta(-1)">
                            <span class="seta-circulo-escuro">
                                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                            </span>
                            <span>Anterior</span>
                        </button>

                        <button type="button" class="btn-quiz btn-proxima" id="btnProxima" onclick="navegarPergunta(1)">
                            <span>Próxima</span>
                            <span class="seta-circulo-claro">
                                <svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </span>
                        </button>
                    </footer>
                </article>
            </section>

        
            <section id="telaResultado" class="resultado-box">
                <h2 id="tituloResultado">Quiz Concluído!</h2>
                <p id="subtituloResultado" style="font-size: 14px; color: #44586e;"></p>
                <div class="resultado-placar" id="placarFinal">100 pts</div>

                <div class="resultado-detalhes" id="detalhesRespostas"></div>

                <div class="resultado-acoes">
                    <button type="button" class="btn-resultado btn-refazer" onclick="iniciarQuiz(temaSelecionadoKey)">Refazer com Novas Perguntas</button>
                    <button type="button" class="btn-resultado btn-outro-tema" onclick="voltarSelecao()">Escolher Outro Tema</button>
                </div>
            </section>

        </main>
    </div>

    <script>
        const bancoPorTema = {
            computador: {
                nome: "Uso Básico do Computador",
                questoes: [
                    {
                        pergunta: "Para que serve o botão esquerdo do mouse na maioria das ações?",
                        correta: "Selecionar itens, abrir programas e clicar em botões.",
                        erradas: ["Desligar o monitor imediatamente.", "Aumentar o volume do teclado.", "Apagar todos os arquivos da lixeira."],
                        dica: "Um clique seleciona um item e dois cliques rápidos abrem pastas ou programas."
                    },
                    {
                        pergunta: "Qual tecla apaga caracteres à esquerda do cursor enquanto você digita?",
                        correta: "Backspace",
                        erradas: ["Caps Lock", "Shift", "Esc"],
                        dica: "Ela fica logo acima da tecla Enter e costuma ter uma seta apontando para a esquerda."
                    },
                    {
                        pergunta: "Qual combinação de teclas serve para copiar um texto ou arquivo selecionado?",
                        correta: "Ctrl + C",
                        erradas: ["Ctrl + Z", "Alt + F4", "Shift + Tab"],
                        dica: "Depois de copiar com Ctrl + C, você pode colar em outro lugar usando Ctrl + V."
                    },
                    {
                        pergunta: "O que é considerado Hardware em um computador?",
                        correta: "As peças físicas, como monitor, teclado, mouse e gabinete.",
                        erradas: ["O navegador Google Chrome.", "O sistema operacional Windows.", "Um documento digitado no editor de texto."],
                        dica: "Hardware é tudo aquilo que você consegue tocar fisicamente no computador."
                    },
                    {
                        pergunta: "Qual é a forma mais recomendada de desligar o computador?",
                        correta: "Clicar no menu Iniciar e selecionar a opção Desligar.",
                        erradas: ["Puxar o cabo de energia direto da tomada.", "Desligar o estabilizador com os programas abertos.", "Fechar apenas a janela do navegador."],
                        dica: "Desligar pelo sistema operacional evita perda de arquivos e danos ao disco."
                    },
                    {
                        pergunta: "Para que serve a tecla Caps Lock no teclado?",
                        correta: "Ativar ou desativar a digitação em letras maiúsculas.",
                        erradas: ["Tirar uma foto da tela.", "Fechar a janela atual.", "Abrir a calculadora do sistema."],
                        dica: "Quando o Caps Lock está ativo, todas as letras digitadas saem em caixa alta."
                    }
                ]
            },
            navegadores: {
                nome: "Navegadores e Busca",
                questoes: [
                    {
                        pergunta: "Como identificar se um site é mais seguro para digitar seus dados?",
                        correta: "Quando o endereço começa com HTTPS e mostra um cadeado.",
                        erradas: ["Quando a página tem muitas propagandas piscando.", "Quando o link chega por mensagem de desconhecidos.", "Quando o site pede sua senha bancária por e-mail."],
                        dica: "Observe sempre a barra de endereço no topo do navegador antes de preencher formulários."
                    },
                    {
                        pergunta: "Qual destes programas é um navegador de internet?",
                        correta: "Google Chrome",
                        erradas: ["Calculadora do Windows", "Bloco de Notas", "Paint"],
                        dica: "Navegadores como Chrome, Edge e Firefox servem para acessar sites na web."
                    },
                    {
                        pergunta: "Para que servem as abas (guias) no topo de um navegador?",
                        correta: "Abrir vários sites diferentes dentro da mesma janela.",
                        erradas: ["Aumentar o brilho da tela.", "Apagar arquivos do computador.", "Desconectar o cabo de rede."],
                        dica: "Você pode clicar no sinal '+' no topo do navegador para abrir uma nova aba."
                    },
                    {
                        pergunta: "O que acontece quando você adiciona um site aos 'Favoritos'?",
                        correta: "O endereço fica salvo para você acessar rapidamente depois.",
                        erradas: ["O site é excluído da internet.", "Você passa a pagar uma assinatura.", "O computador reinicia automaticamente."],
                        dica: "Clique no ícone de estrela na barra de endereços para salvar uma página favorita."
                    },
                    {
                        pergunta: "Como fazer uma pesquisa mais eficiente no Google?",
                        correta: "Digitar palavras-chave diretas sobre o que você procura.",
                        erradas: ["Escrever sua senha pessoal na barra de busca.", "Digitar apenas uma letra.", "Clicar apenas nos anúncios sem ler o endereço."],
                        dica: "Use termos objetivos, como 'previsão do tempo São Paulo' ou 'receita bolo simples'."
                    },
                    {
                        pergunta: "Para que serve o botão de 'Atualizar' (seta circular) no navegador?",
                        correta: "Recarregar a página atual para mostrar informações recentes.",
                        erradas: ["Desligar o computador.", "Formatar o disco rígido.", "Bloquear o teclado."],
                        dica: "Se uma página travar ou não carregar uma imagem, clique na seta circular ou aperte F5."
                    }
                ]
            },
            email: {
                nome: "Criando e Usando seu E-mail",
                questoes: [
                    {
                        pergunta: "Para que serve a pasta 'Spam' ou 'Lixo Eletrônico' no e-mail?",
                        correta: "Separar automaticamente mensagens suspeitas ou propagandas indesejadas.",
                        erradas: ["Guardar fotos importantes com segurança.", "Aumentar a velocidade da conexão Wi-Fi.", "Enviar e-mails mais rápido para contatos."],
                        dica: "Evite clicar em links dentro da caixa de Spam; só abra se tiver certeza de quem enviou."
                    },
                    {
                        pergunta: "Qual símbolo obrigatório separa o nome do usuário e o provedor em um e-mail?",
                        correta: "@ (arroba)",
                        erradas: ["# (jogo da velha)", "$ (cifrão)", "% (porcentagem)"],
                        dica: "Todo endereço de e-mail segue o formato nome@provedor.com."
                    },
                    {
                        pergunta: "Para que serve o ícone de clipe de papel ao escrever um e-mail?",
                        correta: "Anexar arquivos como documentos, fotos ou PDFs à mensagem.",
                        erradas: ["Apagar toda a conta de e-mail.", "Mudar a senha do computador.", "Bloquear o remetente."],
                        dica: "O clipe de papel permite enviar arquivos junto com o texto do e-mail."
                    },
                    {
                        pergunta: "O que deve ser escrito no campo 'Assunto' de um e-mail?",
                        correta: "Um resumo curto do tema da mensagem.",
                        erradas: ["Sua senha do banco.", "Todo o texto longo da carta.", "O endereço da sua casa."],
                        dica: "Um bom assunto ajuda quem recebe a saber do que se trata o e-mail antes mesmo de abrir."
                    },
                    {
                        pergunta: "Onde ficam armazenados os e-mails que você começou a escrever mas ainda não enviou?",
                        correta: "Na pasta Rascunhos",
                        erradas: ["Na pasta Lixeira", "Na pasta Enviados", "Na pasta Spam"],
                        dica: "Se você fechar um e-mail antes de enviar, ele fica salvo em Rascunhos para continuar depois."
                    },
                    {
                        pergunta: "O que acontece quando você exclui um e-mail da Caixa de Entrada?",
                        correta: "Ele vai para a Lixeira e ainda pode ser recuperado por alguns dias.",
                        erradas: ["Ele é enviado para todos os seus contatos.", "Ele desliga o navegador.", "Ele imprime a mensagem automaticamente."],
                        dica: "Apagar por engano não é o fim: basta abrir a Lixeira e mover a mensagem de volta."
                    }
                ]
            },
            seguranca: {
                nome: "Proteja Seus Dados",
                questoes: [
                    {
                        pergunta: "Qual é o principal risco de compartilhar senhas com outras pessoas?",
                        correta: "A pessoa pode acessar suas contas e seus dados pessoais.",
                        erradas: ["A internet fica mais rápida.", "Seus arquivos ficam mais seguros no computador.", "Não existe nenhum risco."],
                        dica: "Nunca compartilhe suas senhas, mesmo com pessoas próximas."
                    },
                    {
                        pergunta: "O que você deve fazer ao receber um e-mail suspeito pedindo atualização urgente de cadastro?",
                        correta: "Não clicar nos links e verificar diretamente no site oficial.",
                        erradas: ["Responder o e-mail informando seu CPF e senha.", "Baixar todos os anexos enviados na mensagem.", "Encaminhar o link suspeito para seus contatos."],
                        dica: "Golpes de phishing usam senso de urgência para fazer você clicar sem conferir o remetente."
                    },
                    {
                        pergunta: "Qual característica torna uma senha mais segura?",
                        correta: "Misturar letras maiúsculas, minúsculas, números e símbolos.",
                        erradas: ["Usar apenas '123456' ou sua data de nascimento.", "Usar o seu próprio primeiro nome.", "Usar a mesma senha em todos os sites."],
                        dica: "Evite informações óbvias como datas de aniversário ou sequências numéricas."
                    },
                    {
                        pergunta: "O que é a verificação em duas etapas (2FA)?",
                        correta: "Uma camada extra de segurança que pede um código além da senha.",
                        erradas: ["Digitar a mesma senha duas vezes seguidas.", "Deixar a conta aberta sem senha.", "Compartilhar o login com dois amigos."],
                        dica: "Mesmo que alguém descubra sua senha, não entra sem o código enviado ao seu celular."
                    },
                    {
                        pergunta: "Qual cuidado você deve ter ao usar redes Wi-Fi públicas (shoppings, praças)?",
                        correta: "Evitar acessar aplicativos de banco ou digitar senhas importantes.",
                        erradas: ["Fazer transferências bancárias normalmente.", "Deixar compartilhamento de arquivos aberto.", "Salvar suas senhas no computador público."],
                        dica: "Redes abertas podem ser monitoradas; prefira seus dados móveis para operações financeiras."
                    },
                    {
                        pergunta: "Por que é importante manter o navegador e o sistema sempre atualizados?",
                        correta: "As atualizações corrigem falhas de segurança contra vírus e invasões.",
                        erradas: ["Apenas para mudar a cor dos ícones.", "Para deixar o computador mais lento.", "Para apagar seus documentos pessoais."],
                        dica: "Atualizações trazem correções que protegem você contra ameaças recentes."
                    }
                ]
            },
            servicos: {
                nome: "Acesse Serviços Públicos",
                questoes: [
                    {
                        pergunta: "O que é necessário para criar e acessar uma conta única no portal Gov.br?",
                        correta: "Informar o número do CPF e cadastrar uma senha pessoal.",
                        erradas: ["Pagar uma mensalidade pelo aplicativo.", "Ter um computador de última geração.", "Compartilhar sua senha com um atendente."],
                        dica: "O cadastro no Gov.br é gratuito e vinculado ao seu CPF."
                    },
                    {
                        pergunta: "Quais são os três níveis de segurança de uma conta Gov.br?",
                        correta: "Bronze, Prata e Ouro.",
                        erradas: ["Básico, Intermediário e VIP pago.", "Iniciante, Júnior e Sênior.", "Verde, Amarelo e Azul."],
                        dica: "Quanto maior o nível (como Prata ou Ouro), mais serviços digitais ficam liberados."
                    },
                    {
                        pergunta: "Qual é o endereço oficial do portal de serviços do Governo Federal?",
                        correta: "www.gov.br",
                        erradas: ["www.gov-brasil-gratis.com", "www.governo-cadastro.net", "www.govbr-premio.org"],
                        dica: "Sites oficiais do governo brasileiro terminam sempre em '.gov.br'."
                    },
                    {
                        pergunta: "Quais serviços podem ser acessados usando a conta Gov.br?",
                        correta: "Meu INSS, Carteira de Trabalho Digital, ENEM e CNH Digital.",
                        erradas: ["Apenas jogos online.", "Somente redes sociais.", "Compra de passagens aéreas internacionais."],
                        dica: "A conta Gov.br unifica o acesso a dezenas de serviços públicos digitais."
                    },
                    {
                        pergunta: "Como aumentar o nível da conta Gov.br para Ouro pelo celular?",
                        correta: "Fazendo o reconhecimento facial pelo aplicativo oficial Gov.br.",
                        erradas: ["Enviando foto do cartão de crédito por WhatsApp.", "Pagando uma taxa via Pix.", "Pedindo para outra pessoa entrar na sua conta."],
                        dica: "O app oficial valida sua biometria com a base da Justiça Eleitoral ou CNH."
                    },
                    {
                        pergunta: "Se você esquecer a senha da sua conta Gov.br, o que deve fazer?",
                        correta: "Clicar em 'Esqueci minha senha' na tela de login oficial para redefinir.",
                        erradas: ["Criar um novo CPF.", "Passar seus dados em links recebidos por SMS.", "Desistir de usar serviços públicos."],
                        dica: "Nunca use links de terceiros; acesse sempre direto pelo app ou site gov.br."
                    }
                ]
            }
        };

        let temaSelecionadoKey = null;
        let questoesRodada = [];
        let indiceAtual = 0;
        let respostasUsuario = [];

        function embaralharArray(lista) {
            const copia = [...lista];
            for (let i = copia.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [copia[i], copia[j]] = [copia[j], copia[i]];
            }
            return copia;
        }

        function iniciarQuiz(temaKey) {
            temaSelecionadoKey = temaKey;
            let pool = [];
            let nomeTema = "";

            if (temaKey === 'misto') {
                nomeTema = "Desafio Geral (Aleatório)";
                Object.values(bancoPorTema).forEach(t => {
                    pool = pool.concat(t.questoes);
                });
            } else {
                nomeTema = bancoPorTema[temaKey].nome;
                pool = bancoPorTema[temaKey].questoes;
            }

          
            const sorteadas = embaralharArray(pool).slice(0, 4);
            questoesRodada = sorteadas.map(q => {
                const opcoesEmbaralhadas = embaralharArray([q.correta, ...q.erradas]);
                return {
                    pergunta: q.pergunta,
                    alternativas: opcoesEmbaralhadas,
                    indiceCorreto: opcoesEmbaralhadas.indexOf(q.correta),
                    respostaCorretaTexto: q.correta,
                    dica: q.dica
                };
            });

            indiceAtual = 0;
            respostasUsuario = new Array(questoesRodada.length).fill(null);

            document.getElementById('nomeTemaAtual').textContent = nomeTema;
            document.getElementById('telaSelecao').style.display = 'none';
            document.getElementById('telaResultado').style.display = 'none';
            document.getElementById('telaQuiz').style.display = 'block';

            renderizarQuestao();
        }

        function voltarSelecao() {
            document.getElementById('telaQuiz').style.display = 'none';
            document.getElementById('telaResultado').style.display = 'none';
            document.getElementById('telaSelecao').style.display = 'block';
        }

        function renderizarQuestao() {
            const q = questoesRodada[indiceAtual];
            const total = questoesRodada.length;

            document.getElementById('contadorPergunta').textContent = `Perguntas ${indiceAtual + 1} de ${total}`;
            document.getElementById('barraProgresso').style.width = `${((indiceAtual + 1) / total) * 100}%`;
            document.getElementById('textoPergunta').textContent = q.pergunta;
            document.getElementById('textoDica').textContent = q.dica;

            let pontos = 0;
            respostasUsuario.forEach((resp, idx) => {
                if (resp === questoesRodada[idx].indiceCorreto) pontos += 25;
            });
            document.getElementById('pontuacaoTexto').textContent = `${pontos} pts`;

            const container = document.getElementById('listaAlternativas');
            container.innerHTML = '<legend class="sr-only">Alternativas de resposta</legend>';

            q.alternativas.forEach((alt, idx) => {
                const selecionada = respostasUsuario[indiceAtual] === idx;
                const label = document.createElement('label');
                label.className = 'alternativa-item' + (selecionada ? ' selecionada' : '');

                label.innerHTML = `
                    <input type="radio" name="alternativa" value="${idx}" ${selecionada ? 'checked' : ''}>
                    <div class="alternativa-esquerda">
                        <span class="radio-indicador" aria-hidden="true"></span>
                        <span class="alternativa-texto">${alt}</span>
                    </div>
                    <span class="check-selecionado" aria-hidden="true">
                        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;stroke-width:3;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </span>
                `;

                label.onclick = () => {
                    respostasUsuario[indiceAtual] = idx;
                    renderizarQuestao();
                };

                container.appendChild(label);
            });

            document.getElementById('btnAnterior').disabled = (indiceAtual === 0);
            const btnProxima = document.getElementById('btnProxima');
            btnProxima.querySelector('span').textContent = (indiceAtual === total - 1) ? 'Finalizar' : 'Próxima';
        }

        function navegarPergunta(direcao) {
            const novoIndice = indiceAtual + direcao;

            if (novoIndice >= 0 && novoIndice < questoesRodada.length) {
                indiceAtual = novoIndice;
                renderizarQuestao();
            } else if (novoIndice === questoesRodada.length) {
                mostrarResultadoFinal();
            }
        }

        function mostrarResultadoFinal() {
            let acertos = 0;
            const detalhesDiv = document.getElementById('detalhesRespostas');
            detalhesDiv.innerHTML = '';

            questoesRodada.forEach((q, idx) => {
                const respIdx = respostasUsuario[idx];
                const acertou = (respIdx === q.indiceCorreto);
                if (acertou) acertos++;

                const textoEscolhido = respIdx !== null ? q.alternativas[respIdx] : "Não respondida";
                const item = document.createElement('div');
                item.className = 'resumo-questao-item ' + (acertou ? 'acerto' : 'erro');
                item.innerHTML = `
                    <strong>${idx + 1}. ${q.pergunta}</strong><br>
                    <span>Sua resposta: ${textoEscolhido} ${acertou ? '✅' : '❌'}</span>
                    ${!acertou ? `<br><span style="color:#1f9d45;font-weight:bold;">Correta: ${q.respostaCorretaTexto}</span>` : ''}
                `;
                detalhesDiv.appendChild(item);
            });

            const pontosFinais = acertos * 25;
            document.getElementById('subtituloResultado').textContent = `Você acertou ${acertos} de ${questoesRodada.length} perguntas neste módulo.`;
            document.getElementById('placarFinal').textContent = `${pontosFinais} pts`;

            document.getElementById('telaQuiz').style.display = 'none';
            document.getElementById('telaResultado').style.display = 'block';
        }
    </script>

</body>

</html>