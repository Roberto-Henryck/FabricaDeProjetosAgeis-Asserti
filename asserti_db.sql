-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2026 às 20:55
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `asserti_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `progresso_conteudos`
--

CREATE TABLE `progresso_conteudos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `conteudo` varchar(150) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `data_conclusao` date NOT NULL,
  `observacoes` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `progresso_conteudos`
--

INSERT INTO `progresso_conteudos` (`id`, `usuario_id`, `conteudo`, `categoria`, `data_conclusao`, `observacoes`, `criado_em`) VALUES
(1, 1, 'Uso de Periféricos', 'Internet', '2026-11-23', 'Legal', '2026-11-22 23:43:36'),
(2, 1, 'Cuidados durante as navegações', 'E-mail', '2026-11-23', 'Mt bom', '2026-11-22 23:44:05'),
(3, 1, 'Criando e Usando seu E-mail', 'E-mail', '2026-11-23', 'ss', '2026-11-22 23:49:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_recuperacao` varchar(255) DEFAULT NULL,
  `token_expira` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `criado_em`, `token_recuperacao`, `token_expira`) VALUES
(1, 'Roberto Henryck Angeli Silva', 'robertohenryck365@gmail.com', '$2y$10$AqVhxfWlYo/SCDO8EMY8feIi5CYwI8sU3RUlHdv/B5YDThHNulOKS', '18997209853', '2026-11-22 23:02:35', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `progresso_conteudos`
--
ALTER TABLE `progresso_conteudos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `progresso_conteudos`
--
ALTER TABLE `progresso_conteudos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `progresso_conteudos`
--
ALTER TABLE `progresso_conteudos`
  ADD CONSTRAINT `progresso_conteudos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
