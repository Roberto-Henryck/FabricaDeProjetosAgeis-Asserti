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
    <title>Registro de Conclusão - Asserti</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #022147;
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

        /* Área do Formulário */
        .conteudo-principal {
            flex: 1;
            padding: 28px 45px;
            max-width: 980px;
            margin: 0 auto;
            width: 100%;
        }

        .cabecalho-pagina {
            text-align: center;
            margin-bottom: 12px;
        }

        .cabecalho-pagina h1 {
            font-size: 22px;
            font-weight: 800;
            font-style: italic;
            color: #022147;
            margin-bottom: 4px;
        }

        .cabecalho-pagina p {
            font-size: 12px;
            color: #4a607a;
            max-width: 340px;
            margin: 0 auto;
            line-height: 1.4;
        }

        .linha-topo {
            border: none;
            border-top: 1px solid #8ea6c1;
            margin-bottom: 22px;
        }

        .form-conclusao {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .campo-grupo {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .campo-grupo label {
            font-size: 19px;
            font-weight: 700;
            color: #022147;
        }

        .campo-grupo select,
        .campo-grupo input[type="date"] {
            width: 100%;
            height: 40px;
            padding: 0 14px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 13px;
            color: #555;
            outline: none;
        }

        .campo-grupo select:focus,
        .campo-grupo input[type="date"]:focus,
        .campo-grupo textarea:focus {
            border-color: #022147;
        }

        .campo-grupo textarea {
            width: 100%;
            height: 115px;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background-color: #eaeaea;
            font-size: 13px;
            color: #333;
            resize: vertical;
            outline: none;
        }

        .botoes-acoes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }

        .btn-voltar {
            flex: 1;
            max-width: 360px;
            height: 44px;
            background-color: #dcdcdc;
            color: #022147;
            border: 1px solid #4a7ebb;
            border-radius: 25px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .btn-voltar:hover {
            background-color: #cfcfcf;
        }

        .btn-salvar {
            flex: 1;
            max-width: 360px;
            height: 44px;
            background-color: #022147;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-salvar:hover {
            opacity: 0.92;
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
                        <a href="perfil.php">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                </ul>
            </nav>

           
        </aside>

        <main class="conteudo-principal">
            <div class="cabecalho-pagina">
                <h1>Registro de conteúdos concluídos</h1>
                <p>Registre os conteúdos que você concluiu para acompanhar seu progresso.</p>
            </div>

            <hr class="linha-topo">

            <form action="../Controller/usuarioControle.php" method="POST" class="form-conclusao">
                <input type="hidden" name="acao" value="registrar_conclusao">

                <div class="campo-grupo">
                    <label for="conteudo">1. Selecione o conteúdo concluído</label>
                    <select id="conteudo" name="conteudo" required>
                        <option value="" disabled selected>Selecione o conteúdo concluído</option>
                        <option value="Uso Básico do Computador">Uso Básico do Computador</option>
                        <option value="Navegadores e Mecanismos de Busca">Navegadores e Mecanismos de Busca</option>
                        <option value="Criando e Usando seu E-mail">Criando e Usando seu E-mail</option>
                        <option value="Proteja Seus Dados">Proteja Seus Dados</option>
                        <option value="Acesse Serviços Públicos">Acesse Serviços Públicos</option>
                        <option value="Cuidados durante as navegações">Cuidados durante as navegações</option>
                        <option value="Uso de Periféricos">Uso de Periféricos</option>
                    </select>
                </div>

                <div class="campo-grupo">
                    <label for="categoria">2. Tema / Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione o tema</option>
                        <option value="Computador">Computador</option>
                        <option value="Internet">Internet</option>
                        <option value="E-mail">E-mail</option>
                        <option value="Segurança">Segurança</option>
                        <option value="Serviços Públicos">Serviços Públicos</option>
                    </select>
                </div>

                <div class="campo-grupo">
                    <label for="data_conclusao">3. Data de conclusão</label>
                    <input type="date" id="data_conclusao" name="data_conclusao" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="campo-grupo">
                    <label for="observacoes">4. Observações (opcional)</label>
                    <textarea id="observacoes" name="observacoes" placeholder="Adicione uma observação"></textarea>
                </div>

                <div class="botoes-acoes">
                    <a href="conteudos.php" class="btn-voltar">
                        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        <span>Voltar</span>
                    </a>

                    <button type="submit" class="btn-salvar">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        <span>Registrar como concluído</span>
                    </button>
                </div>
            </form>
        </main>
    </div>

</body>

</html>