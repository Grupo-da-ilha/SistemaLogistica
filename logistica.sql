-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/06/2024 às 19:56
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
-- Banco de dados: `logistica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `CNPJ` varchar(65) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `Telefone` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`CNPJ`, `Nome`, `CEP`, `rua`, `bairro`, `cidade`, `estado`, `Telefone`) VALUES
('03.774.819/0001-02', 'SENAI ITAJAÍ', '88305-55', 'Blumenau', 'São João', 'Itajaí', 'SC', '(47) 3341-2900');

-- --------------------------------------------------------

--
-- Estrutura para tabela `docas`
--

CREATE TABLE `docas` (
  `cod_doca` int(11) NOT NULL,
  `posicao` varchar(5) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `codTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `docas`
--

INSERT INTO `docas` (`cod_doca`, `posicao`, `id_pedido`, `codTurma`) VALUES
(1, '1', 2, 'S3naiAdmin'),
(2, '3', 3, 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `cod_estoque` int(11) NOT NULL,
  `Andar` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Apartamento` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`cod_estoque`, `Andar`, `Apartamento`) VALUES
(1, 'A', '1'),
(2, 'A', '2'),
(3, 'A', '3'),
(4, 'A', '4'),
(5, 'A', '5'),
(6, 'B', '1'),
(7, 'B', '2'),
(8, 'B', '3'),
(9, 'B', '4'),
(10, 'B', '5'),
(11, 'C', '1'),
(12, 'C', '2'),
(13, 'C', '3'),
(14, 'C', '4'),
(15, 'C', '5'),
(16, 'D', '1'),
(17, 'D', '2'),
(18, 'D', '3'),
(19, 'D', '4'),
(20, 'D', '5');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fabricantes`
--

CREATE TABLE `fabricantes` (
  `CNPJ` varchar(65) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `CEP` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `Telefone` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `fabricantes`
--

INSERT INTO `fabricantes` (`CNPJ`, `Nome`, `CEP`, `rua`, `bairro`, `cidade`, `estado`, `Telefone`) VALUES
('03.389.993/0001-23', 'CIS', '88.304-101', 'Heitor Liberato', 'São João', 'Itajaí', 'SC', '(47) 3247-9763'),
('07.175.725/0001-60', 'WEG', '88.311-720', 'Rosa Orsi Dalçoquio', 'Cordeiros', 'Itajaí', 'SC', '(47) 3276-7311'),
('44.990.901/0001-43', 'Tilibra', '17013-900', 'Aymorés', 'Vila Antártica', 'Bauru', 'SP', '(14) 3235-4003');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `CNPJ` varchar(65) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `materiaPrima` varchar(255) NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `Telefone` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itenspedido`
--

CREATE TABLE `itenspedido` (
  `cod_itenPedido` int(11) NOT NULL,
  `cod_produto` int(11) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL,
  `Quantidade_doca` int(11) NOT NULL,
  `Quantidade_estoque` int(11) NOT NULL,
  `PosicaoPrevia` varchar(5) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `Avariado` tinyint(1) NOT NULL,
  `Faltando` tinyint(1) NOT NULL,
  `VistoriaConcluida` tinyint(1) NOT NULL,
  `codTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `itenspedido`
--

INSERT INTO `itenspedido` (`cod_itenPedido`, `cod_produto`, `cod_pedido`, `Quantidade`, `Quantidade_doca`, `Quantidade_estoque`, `PosicaoPrevia`, `ValorUnitario`, `ValorTotal`, `Avariado`, `Faltando`, `VistoriaConcluida`, `codTurma`) VALUES
(1, 1, 2, 2, 1, 1, 'A1', 5.5, 11, 0, 1, 1, 'S3naiAdmin'),
(2, 2, 2, 3, 0, 3, 'B3', 1.2, 3.6, 1, 0, 1, 'S3naiAdmin'),
(4, 4, 3, 3, 3, 0, 'AA', 7.3, 21.9, 1, 0, 1, 'S3naiAdmin'),
(5, 5, 3, 2, 2, 0, 'AA', 29.99, 59.98, 1, 0, 1, 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_fiscal`
--

CREATE TABLE `nota_fiscal` (
  `cod_nota` int(11) NOT NULL,
  `chave_acesso` varchar(65) NOT NULL,
  `DataExpedicao` datetime NOT NULL,
  `InformacoesAdicionais` varchar(255) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `CNPJ_Destinatario` varchar(65) NOT NULL,
  `CNPJ_Transportadora` varchar(65) NOT NULL,
  `CNPJ_Emitente` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `nota_fiscal`
--

INSERT INTO `nota_fiscal` (`cod_nota`, `chave_acesso`, `DataExpedicao`, `InformacoesAdicionais`, `id_pedido`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `CNPJ_Emitente`) VALUES
(53732, '45322005557186824891300211341784926188275865', '2024-05-31 17:31:38', 'MARCA TEXTOS VERDE NEON', 3, '03.774.819/0001-02', '42.555.657/0001-65', '07.175.725/0001-60'),
(86679, '00080831661334808902745293029033638238842947', '2024-05-31 17:31:38', 'CUIDADO TESOURAS COM PONTA', 2, '03.774.819/0001-02', '42.555.657/0001-65', '07.175.725/0001-60');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `DataVenda` datetime NOT NULL,
  `ValorTotal` double NOT NULL,
  `CNPJEmitente` varchar(65) NOT NULL,
  `CNPJ_Destinatario` varchar(64) NOT NULL,
  `CNPJ_Transportadora` varchar(65) NOT NULL,
  `Situacao` varchar(255) NOT NULL,
  `InformacaoAdicional` varchar(255) NOT NULL,
  `codTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `cod_pedido`, `DataVenda`, `ValorTotal`, `CNPJEmitente`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `Situacao`, `InformacaoAdicional`, `codTurma`) VALUES
(2, 1, '2024-05-31 17:31:38', 14.6, '07.175.725/0001-60', '03.774.819/0001-02', '42.555.657/0001-65', 'Nas docas', 'CUIDADO TESOURAS COM PONTA', 'S3naiAdmin'),
(3, 23, '2024-05-31 17:57:11', 81.88, '03.389.993/0001-23', '03.774.819/0001-02', '07.639.029/0001-67', 'Nas docas', 'MARCA TEXTOS VERDE NEON', 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL,
  `PrecoUNI` double NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `PesoGramas` double DEFAULT NULL,
  `NCM` varchar(8) DEFAULT NULL,
  `UN` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`cod_produto`, `PrecoUNI`, `Nome`, `PesoGramas`, `NCM`, `UN`) VALUES
(1, 5.5, 'Tesoura', 26, '82016000', 'UN'),
(2, 1.2, 'Lápis', 20, '96091000', 'UN'),
(4, 7.3, 'Caderno', 100, '48202000', 'UN'),
(5, 29.99, 'Caneta Marca Texto', 20, '96082000', 'UN');

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `idprojeto` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `codTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `projetos`
--

INSERT INTO `projetos` (`idprojeto`, `nome`, `codTurma`) VALUES
(2, 'Senai', 'S3naiAdmin'),
(3, 'Projeto 1', 'terceirao');

-- --------------------------------------------------------

--
-- Estrutura para tabela `transportadoras`
--

CREATE TABLE `transportadoras` (
  `CNPJ` varchar(65) NOT NULL,
  `QuantidadeFrota` int(11) NOT NULL,
  `Nome` varchar(255) DEFAULT NULL,
  `CEP` varchar(8) NOT NULL,
  `Telefone` varchar(22) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `transportadoras`
--

INSERT INTO `transportadoras` (`CNPJ`, `QuantidadeFrota`, `Nome`, `CEP`, `Telefone`, `bairro`, `rua`, `cidade`, `estado`) VALUES
('07.639.029/0001-67', 15, 'Tac Transportes', '88301-49', '(47) 2104-4600', 'Fazenda', 'Rua Júlio Coutinho', 'Itajaí', 'SC'),
('13.161.095/0001-77', 30, 'NSL Brasil', '88303-20', '(47) 3045-4141', 'Vila Operária', 'Rua Carlos Seara', 'Itajaí', 'SC'),
('42.555.657/0001-65', 20, 'Graédi Transportes', '88303-36', '(47) 3011-3400', 'S?o Judas', 'Rua Rosendo Claudino de Freitas', 'Itajaí', 'SC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `codTurma` varchar(255) NOT NULL,
  `nomeTurma` varchar(50) NOT NULL,
  `total_alunos` int(11) DEFAULT 0,
  `data_turma` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`codTurma`, `nomeTurma`, `total_alunos`, `data_turma`) VALUES
('S3naiAdmin', 'SenaiADM', 0, '2024-05-29 20:59:55'),
('terceirao', '2 DS', 0, '2024-05-31 23:12:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `data_entrada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipousuario` varchar(255) NOT NULL,
  `codTurma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`Id`, `email`, `senha`, `nome`, `ativo`, `data_entrada`, `tipousuario`, `codTurma`) VALUES
(124, 'kauan007@gmail.com', 'eijks', 'Kauan', 's', '2024-05-31 19:42:49', 'Professor', 'S3naiAdmin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`CNPJ`);

--
-- Índices de tabela `docas`
--
ALTER TABLE `docas`
  ADD PRIMARY KEY (`cod_doca`),
  ADD KEY `FK_idpedido` (`id_pedido`),
  ADD KEY `FK_codigo_Turma` (`codTurma`);

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`cod_estoque`);

--
-- Índices de tabela `fabricantes`
--
ALTER TABLE `fabricantes`
  ADD PRIMARY KEY (`CNPJ`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`CNPJ`);

--
-- Índices de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  ADD PRIMARY KEY (`cod_itenPedido`),
  ADD KEY `FK_cod_produto` (`cod_produto`),
  ADD KEY `FK_cod_pedido` (`cod_pedido`),
  ADD KEY `FK_cod_turma_item` (`codTurma`);

--
-- Índices de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD PRIMARY KEY (`cod_nota`),
  ADD KEY `FK_id_pedido` (`id_pedido`),
  ADD KEY `FK_CNPJDestinatario` (`CNPJ_Destinatario`),
  ADD KEY `FK_CNPJTransportadora` (`CNPJ_Transportadora`),
  ADD KEY `FK_CNPJ_Emitente` (`CNPJ_Emitente`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `FK_CNPJEmitente` (`CNPJEmitente`),
  ADD KEY `FK_CNPJ_Destinatario` (`CNPJ_Destinatario`),
  ADD KEY `FK_CNPJ_Transportadora` (`CNPJ_Transportadora`),
  ADD KEY `FK_cod_Turma` (`codTurma`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`cod_produto`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`idprojeto`),
  ADD KEY `FK_codigoTurma` (`codTurma`);

--
-- Índices de tabela `transportadoras`
--
ALTER TABLE `transportadoras`
  ADD PRIMARY KEY (`CNPJ`);

--
-- Índices de tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`codTurma`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_codTurma` (`codTurma`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `docas`
--
ALTER TABLE `docas`
  MODIFY `cod_doca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `cod_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  MODIFY `cod_itenPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `idprojeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `docas`
--
ALTER TABLE `docas`
  ADD CONSTRAINT `FK_codigo_Turma` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`),
  ADD CONSTRAINT `FK_idpedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Restrições para tabelas `itenspedido`
--
ALTER TABLE `itenspedido`
  ADD CONSTRAINT `FK_cod_pedido` FOREIGN KEY (`cod_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `FK_cod_produto` FOREIGN KEY (`cod_produto`) REFERENCES `produtos` (`cod_produto`),
  ADD CONSTRAINT `FK_cod_turma_item` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD CONSTRAINT `FK_CNPJDestinatario` FOREIGN KEY (`CNPJ_Destinatario`) REFERENCES `clientes` (`CNPJ`),
  ADD CONSTRAINT `FK_CNPJTransportadora` FOREIGN KEY (`CNPJ_Transportadora`) REFERENCES `transportadoras` (`CNPJ`),
  ADD CONSTRAINT `FK_CNPJ_Emitente` FOREIGN KEY (`CNPJ_Emitente`) REFERENCES `fabricantes` (`CNPJ`),
  ADD CONSTRAINT `FK_id_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_CNPJEmitente` FOREIGN KEY (`CNPJEmitente`) REFERENCES `fabricantes` (`CNPJ`),
  ADD CONSTRAINT `FK_CNPJ_Destinatario` FOREIGN KEY (`CNPJ_Destinatario`) REFERENCES `clientes` (`CNPJ`),
  ADD CONSTRAINT `FK_CNPJ_Transportadora` FOREIGN KEY (`CNPJ_Transportadora`) REFERENCES `transportadoras` (`CNPJ`),
  ADD CONSTRAINT `FK_cod_Turma` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `FK_codigoTurma` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_codTurma` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
