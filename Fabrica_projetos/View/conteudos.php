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
    <title>Conteúdos - Asserti</title>
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

        /* Área de Conteúdo */
        .conteudo-principal {
            flex: 1;
            padding: 30px 45px;
            max-width: 1150px;
            margin: 0 auto;
            width: 100%;
        }

        /* Barra de Pesquisa */
        .barra-busca {
            background-color: #dcdcdc;
            border-radius: 25px;
            padding: 12px 22px;
            display: flex;
            align-items: center;
            gap: 15px;
            max-width: 780px;
            margin: 0 auto 22px auto;
        }

        .barra-busca input {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 16px;
            color: #222;
            outline: none;
        }

        /* Filtros */
        .filtros {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 28px;
        }

        .filtro-btn {
            background-color: #dcdcdc;
            border: none;
            border-radius: 20px;
            padding: 8px 32px;
            font-size: 13px;
            color: #222;
            cursor: pointer;
            transition: 0.2s;
        }

        .filtro-btn:hover,
        .filtro-btn.ativo {
            background-color: #022147;
            color: #ffffff;
        }

        /* Lista de Módulos */
        .lista-modulos {
            display: flex;
            flex-direction: column;
            gap: 18px;
            max-width: 820px;
            margin: 0 auto;
        }

        .modulo-card {
            background-color: #96c2ea;
            border-radius: 22px;
            padding: 18px 28px 18px 85px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            position: relative;
        }

        .modulo-card:hover {
            background-color: #82b5e4;
            transform: translateX(4px);
        }

        .modulo-info h3 {
            font-size: 16px;
            font-weight: 500;
            color: #111;
            margin-bottom: 4px;
        }

        .modulo-info p {
            font-size: 12px;
            color: #222;
            margin-bottom: 8px;
            max-width: 460px;
        }

        .modulo-meta {
            font-size: 10px;
            color: #222;
            display: flex;
            gap: 18px;
        }

        .modulo-direita {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .badge-concluido {
            background-color: #24b34b;
            color: #ffffff;
            font-size: 11px;
            padding: 4px 20px;
            border-radius: 12px;
            font-weight: bold;
        }

        .seta {
            font-size: 24px;
            color: #111;
            font-weight: bold;
        }

        /* Player de Vídeo com Navegação entre Aulas */
        .player-box {
            display: none;
            max-width: 820px;
            margin: 0 auto 30px auto;
            background-color: #f4f7fb;
            border: 1px solid #cfdbe8;
            border-radius: 18px;
            padding: 22px;
        }

        .player-topo {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }

        .player-topo small {
            display: block;
            color: #0254a5;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .player-topo h2 {
            font-size: 18px;
            color: #022147;
        }

        .btn-fechar-player {
            background-color: #555;
            color: #fff;
            border: none;
            padding: 7px 14px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 12px;
            flex-shrink: 0;
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 12px;
            background: #000;
            margin-bottom: 16px;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Controles Anterior / Próxima Aula */
        .player-controles {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .navegacao-aulas {
            display: flex;
            gap: 10px;
        }

        .btn-nav-aula {
            background-color: #022147;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-nav-aula:disabled {
            background-color: #b0bec5;
            cursor: not-allowed;
        }

        .btn-registrar {
            background-color: #24b34b;
            color: #fff;
            text-decoration: none;
            padding: 9px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        /* Playlist das Aulas do Módulo */
        .playlist-aulas {
            border-top: 1px solid #d5e0ec;
            padding-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .playlist-item {
            background-color: #ffffff;
            border: 1px solid #d5e0ec;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: 0.15s;
        }

        .playlist-item:hover {
            background-color: #e6f0fa;
        }

        .playlist-item.ativa {
            background-color: #022147;
            color: #ffffff;
            border-color: #022147;
            font-weight: bold;
        }

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
                        <a href="conteudos.php" class="ativo">
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
                        <a href="admin_conteudos.php">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="menu-rodape">
           
        </aside>

        <main class="conteudo-principal">

            <!-- Player de Aula com Playlist e Navegação -->
            <section class="player-box" id="playerBox">
                <div class="player-topo">
                    <div>
                        <small id="playerContador">Módulo • Aula 1 de 5</small>
                        <h2 id="playerTitulo">Título da Aula</h2>
                    </div>
                    <button class="btn-fechar-player" onclick="fecharPlayer()">Fechar vídeo</button>
                </div>

                <div class="video-wrapper">
                    <iframe id="playerIframe" src="" title="Aula Asserti" allowfullscreen></iframe>
                </div>

                <div class="player-controles">
                    <div class="navegacao-aulas">
                        <button class="btn-nav-aula" id="btnAnterior" onclick="mudarAula(-1)">← Aula Anterior</button>
                        <button class="btn-nav-aula" id="btnProxima" onclick="mudarAula(1)">Próxima Aula →</button>
                    </div>

                    <a href="registrar_conclusao.php" class="btn-registrar">Registrar módulo como concluído</a>
                </div>

                <!-- Lista clicável com todas as aulas do curso -->
                <div class="playlist-aulas" id="playlistContainer"></div>
            </section>

            <!-- Barra de Busca -->
            <div class="barra-busca">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="campoBusca" placeholder="O que você procura?" onkeyup="filtrarModulos()">
            </div>

            <!-- Botões de Filtro -->
            <div class="filtros">
                <button class="filtro-btn ativo" onclick="selecionarCategoria('todos', this)">Todos</button>
                <button class="filtro-btn" onclick="selecionarCategoria('computador', this)">Computador</button>
                <button class="filtro-btn" onclick="selecionarCategoria('internet', this)">Internet</button>
                <button class="filtro-btn" onclick="selecionarCategoria('email', this)">E-mail</button>
            </div>

            <!-- Lista de Conteúdos -->
            <section class="lista-modulos" id="listaModulos">

                <article class="modulo-card" data-categoria="computador" onclick="abrirModulo('computador_basico')">
                    <div class="modulo-info">
                        <h3>Uso Básico do Computador</h3>
                        <p>Conheça os princípios do computador, o teclado, o mouse e como usar o sistema.</p>
                        <div class="modulo-meta">
                            <span>5 aulas</span>
                            <span>•</span>
                            <span>1h 10min</span>
                        </div>
                    </div>
                    <div class="modulo-direita">
                        <span class="badge-concluido">Concluído</span>
                        <span class="seta">&gt;</span>
                    </div>
                </article>

                <article class="modulo-card" data-categoria="internet" onclick="abrirModulo('navegadores')">
                    <div class="modulo-info">
                        <h3>Navegadores e Mecanismos de Busca</h3>
                        <p>Aprenda a usar navegadores, pesquisar na internet e identificar sites confiáveis.</p>
                        <div class="modulo-meta">
                            <span>3 aulas</span>
                            <span>•</span>
                            <span>40min</span>
                        </div>
                    </div>
                    <div class="modulo-direita">
                        <span class="seta">&gt;</span>
                    </div>
                </article>

                <article class="modulo-card" data-categoria="email" onclick="abrirModulo('email')">
                    <div class="modulo-info">
                        <h3>Criando e Usando seu E-mail</h3>
                        <p>Saiba como criar uma conta, enviar e receber mensagens e organizar sua caixa de entrada.</p>
                        <div class="modulo-meta">
                            <span>3 aulas</span>
                            <span>•</span>
                            <span>15min</span>
                        </div>
                    </div>
                    <div class="modulo-direita">
                        <span class="seta">&gt;</span>
                    </div>
                </article>

                <article class="modulo-card" data-categoria="internet" onclick="abrirModulo('seguranca')">
                    <div class="modulo-info">
                        <h3>Proteja Seus Dados</h3>
                        <p>Aprenda a criar senhas seguras, evitar golpes e se proteger na internet.</p>
                        <div class="modulo-meta">
                            <span>3 aulas</span>
                            <span>•</span>
                            <span>10min</span>
                        </div>
                    </div>
                    <div class="modulo-direita">
                        <span class="seta">&gt;</span>
                    </div>
                </article>

                <article class="modulo-card" data-categoria="internet" onclick="abrirModulo('servicos_publicos')">
                    <div class="modulo-info">
                        <h3>Acesse Serviços Públicos</h3>
                        <p>Saiba como usar o gov.br, preencher formulários e acessar serviços online.</p>
                        <div class="modulo-meta">
                            <span>2 Aulas</span>
                            <span>•</span>
                            <span>10min</span>
                        </div>
                    </div>
                    <div class="modulo-direita">
                        <span class="seta">&gt;</span>
                    </div>
                </article>

            </section>
        </main>
    </div>

    <script>
        function formatarUrlYoutube(url) {
            if (!url) return '';
            if (url.includes('/embed/')) return url;

            let videoId = '';
            if (url.includes('youtu.be/')) {
                videoId = url.split('youtu.be/')[1].split(/[?&]/)[0];
            } else if (url.includes('v=')) {
                videoId = url.split('v=')[1].split('&')[0];
            }
            return videoId ? `https://www.youtube.com/embed/${videoId}` : url;
        }

       
        const cursos = {
            computador_basico: {
                nome: 'Uso Básico do Computador',
                aulas: [
                    { titulo: 'Aula 1: Conceitos Iniciais — Hardware e Software', url: 'https://www.youtube.com/watch?v=M3Ypqy-MIEc' },
                    { titulo: 'Aula 2: Conhecendo a Área de Trabalho do Windows', url: 'https://www.youtube.com/watch?v=frxft47tchI' },
                    { titulo: 'Aula 3: Como usar o teclado do computador passo a passo', url: 'https://www.youtube.com/watch?v=Pk9RKJh_ZNk' },
                    { titulo: 'Aula 4: Funções das teclas e atalhos essenciais', url: 'https://www.youtube.com/watch?v=J_qW4UQbnFI' },
                    { titulo: 'Aula 5: Arquivos, Pastas e Janelas no Windows', url: 'https://www.youtube.com/watch?v=I1m7fnCTOT0' }
                ]
            },
            navegadores: {
                nome: 'Navegadores e Mecanismos de Busca',
                aulas: [
                    { titulo: 'Aula 1: Navegadores de Internet — Chrome, Edge e como funcionam', url: 'https://www.youtube.com/watch?v=AKRJ6wYPryw' },
                    { titulo: 'Aula 2: Como pesquisar no Google e usar ferramentas de busca', url: 'https://www.youtube.com/watch?v=YuOBbF2DR1Q' },
                    { titulo: 'Aula 3: Recursos do Google na Web (Imagens, Maps e Tradutor)', url: 'https://www.youtube.com/watch?v=VyWUJgMk8T0' }
                ]
            },
            email: {
                nome: 'Criando e Usando seu E-mail',
                aulas: [
                    { titulo: 'Aula 1: Como criar um e-mail novo no Gmail', url: 'https://www.youtube.com/watch?v=ovZjAF1HJVw' },
                    { titulo: 'Aula 2: Passo a passo para criar sua conta Gmail em 3 minutos', url: 'https://www.youtube.com/watch?v=qXtzobMvNCg' },
                    { titulo: 'Aula 3: Como usar o Gmail passo a passo (enviar e organizar)', url: 'https://www.youtube.com/watch?v=zSAHLP7Vz7c' }
                ]
            },
            seguranca: {
                nome: 'Proteja Seus Dados',
                aulas: [
                    { titulo: 'Aula 1: Cibersegurança — Como criar senhas fortes e proteger dados', url: 'https://www.youtube.com/watch?v=pie43dOZl3Q' },
                    { titulo: 'Aula 2: Phishing — Como identificar golpes e links falsos', url: 'https://www.youtube.com/watch?v=qJWIFlpvkwU' },
                    { titulo: 'Aula 3: Segurança no uso de e-mails e verificação em duas etapas', url: 'https://www.youtube.com/watch?v=m-SwxRYhQus' }
                ]
            },
            servicos_publicos: {
                nome: 'Acesse Serviços Públicos',
                aulas: [
                    { titulo: 'Aula 1: Saiba como criar uma conta GOV.BR (Canal Oficial)', url: 'https://www.youtube.com/watch?v=qmqJqr3fN5w' },
                    { titulo: 'Aula 2: Como cadastrar e acessar sua conta GOV.BR passo a passo', url: 'https://www.youtube.com/watch?v=BoI5o22MBQI' }
                ]
            }
        };

        let moduloAtualKey = null;
        let indiceAulaAtual = 0;
        let categoriaAtual = 'todos';

        function abrirModulo(chave) {
            moduloAtualKey = chave;
            indiceAulaAtual = 0;
            renderizarAula();

            const box = document.getElementById('playerBox');
            box.style.display = 'block';
            box.scrollIntoView({ behavior: 'smooth' });
        }

        function renderizarAula() {
            const modulo = cursos[moduloAtualKey];
            const aula = modulo.aulas[indiceAulaAtual];
            const total = modulo.aulas.length;

            document.getElementById('playerContador').textContent = `${modulo.nome} • Aula ${indiceAulaAtual + 1} de ${total}`;
            document.getElementById('playerTitulo').textContent = aula.titulo;
            document.getElementById('playerIframe').src = formatarUrlYoutube(aula.url);

            document.getElementById('btnAnterior').disabled = (indiceAulaAtual === 0);
            document.getElementById('btnProxima').disabled = (indiceAulaAtual === total - 1);

            const playlistDiv = document.getElementById('playlistContainer');
            playlistDiv.innerHTML = '';

            modulo.aulas.forEach((item, index) => {
                const div = document.createElement('div');
                div.className = 'playlist-item' + (index === indiceAulaAtual ? ' ativa' : '');
                div.innerHTML = `<span>${item.titulo}</span><span>${index === indiceAulaAtual ? 'Assistindo' : '▶'}</span>`;
                div.onclick = () => {
                    indiceAulaAtual = index;
                    renderizarAula();
                };
                playlistDiv.appendChild(div);
            });
        }

        function mudarAula(direcao) {
            const total = cursos[moduloAtualKey].aulas.length;
            const novoIndice = indiceAulaAtual + direcao;

            if (novoIndice >= 0 && novoIndice < total) {
                indiceAulaAtual = novoIndice;
                renderizarAula();
            }
        }

        function fecharPlayer() {
            document.getElementById('playerIframe').src = '';
            document.getElementById('playerBox').style.display = 'none';
        }

        function selecionarCategoria(categoria, botao) {
            categoriaAtual = categoria;
            document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('ativo'));
            botao.classList.add('ativo');
            filtrarModulos();
        }

        function filtrarModulos() {
            const termo = document.getElementById('campoBusca').value.toLowerCase();
            const cards = document.querySelectorAll('.modulo-card');

            cards.forEach(card => {
                const cat = card.getAttribute('data-categoria');
                const texto = card.innerText.toLowerCase();
                const bateCategoria = (categoriaAtual === 'todos' || cat === categoriaAtual);
                const bateTexto = texto.includes(termo);

                card.style.display = (bateCategoria && bateTexto) ? 'flex' : 'none';
            });
        }
    </script>

</body>

</html>