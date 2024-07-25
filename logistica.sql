-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/07/2024 às 18:53
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
(13, '1', 8, 'S3naiAdmin'),
(14, '2', 11, 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `cod_estoque` int(11) NOT NULL,
  `Andar` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Apartamento` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Quantidade_setor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`cod_estoque`, `Andar`, `Apartamento`, `Quantidade_setor`) VALUES
(1, 'A', '1', 0),
(2, 'A', '2', 0),
(3, 'A', '3', 0),
(4, 'A', '4', 0),
(5, 'B', '1', 0),
(6, 'B', '2', 0),
(7, 'B', '3', 0),
(8, 'B', '4', 0),
(9, 'C', '1', 0),
(10, 'C', '2', 0),
(11, 'C', '3', 0),
(12, 'C', '4', 0),
(13, 'D', '1', 0),
(14, 'D', '2', 0),
(15, 'D', '3', 0),
(16, 'D', '4', 0),
(17, 'E', '1', 0),
(18, 'E', '2', 0),
(19, 'E', '3', 0),
(20, 'E', '4', 0);

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
-- Estrutura para tabela `itensestoque`
--

CREATE TABLE `itensestoque` (
  `cod_itenEstoque` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL,
  `Situacao` varchar(255) NOT NULL,
  `cod_estoque` int(11) NOT NULL,
  `cod_itenpedido` int(11) NOT NULL,
  `codTurma` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `itensestoque`
--

INSERT INTO `itensestoque` (`cod_itenEstoque`, `Quantidade`, `Situacao`, `cod_estoque`, `cod_itenpedido`, `codTurma`) VALUES
(20, 1, 'No estoque', 1, 29, 'S3naiAdmin'),
(21, 1, 'No estoque', 7, 30, 'S3naiAdmin'),
(22, 1, 'No estoque', 15, 30, 'S3naiAdmin'),
(23, 2, 'No estoque', 11, 35, 'S3naiAdmin'),
(24, 2, 'No estoque', 17, 36, 'S3naiAdmin'),
(25, 1, 'No estoque', 14, 36, 'S3naiAdmin');

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

INSERT INTO `itenspedido` (`cod_itenPedido`, `cod_produto`, `cod_pedido`, `Quantidade`, `Quantidade_doca`, `ValorUnitario`, `ValorTotal`, `Avariado`, `Faltando`, `VistoriaConcluida`, `codTurma`) VALUES
(29, 5, 8, 1, 0, 29.99, 29.99, 0, 0, 1, 'S3naiAdmin'),
(30, 4, 8, 2, 0, 7.3, 14.6, 0, 0, 1, 'S3naiAdmin'),
(35, 1, 11, 2, 0, 5.5, 11, 0, 0, 1, 'S3naiAdmin'),
(36, 2, 11, 3, 0, 1.2, 3.6, 0, 0, 1, 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itenssolicitacao`
--

CREATE TABLE `itenssolicitacao` (
  `cod_itemSolicitacao` int(11) NOT NULL,
  `cod_produto` int(11) NOT NULL,
  `cod_solicitacao` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL,
  `codTurma` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itenssolicitacao`
--

INSERT INTO `itenssolicitacao` (`cod_itemSolicitacao`, `cod_produto`, `cod_solicitacao`, `Quantidade`, `codTurma`) VALUES
(12, 1, 5, 2, 'S3naiAdmin');

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
(85430, '36298890168740512810013638509660969452805168', '2024-07-09 20:49:47', 'Mercadoria Super frágil', 11, '03.774.819/0001-02', '13.161.095/0001-77', '03.389.993/0001-23'),
(96344, '89942527962953630750710024629946201069103589', '2024-07-09 20:49:47', 'Mercadoria frágil', 8, '03.774.819/0001-02', '13.161.095/0001-77', '03.389.993/0001-23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `DataVenda` datetime NOT NULL,
  `DataEntrega` datetime NOT NULL,
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

INSERT INTO `pedido` (`id_pedido`, `cod_pedido`, `DataVenda`, `DataEntrega`, `ValorTotal`, `CNPJEmitente`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `Situacao`, `InformacaoAdicional`, `codTurma`) VALUES
(8, 1, '2024-07-09 20:49:47', '2024-07-16 20:49:00', 44.59, '03.389.993/0001-23', '03.774.819/0001-02', '13.161.095/0001-77', 'Em movimentação', 'Mercadoria frágil', 'S3naiAdmin'),
(11, 2, '2024-07-09 21:06:13', '2024-07-23 00:00:00', 14.6, '07.175.725/0001-60', '03.774.819/0001-02', '42.555.657/0001-65', 'Nas docas', 'Mercadoria Super frágil', 'S3naiAdmin');

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
(5, 29.99, 'Caneta Marca Texto', 20, '96082000', 'UN'),
(8, 2.99, 'Borracha', 20, '40025908', 'UN');

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
(10, 'Projeto 1', 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `id_solicitacao` int(11) NOT NULL,
  `cod_solicitacao` int(11) DEFAULT NULL,
  `Observacao` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Situacao` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Data_criacao` datetime NOT NULL,
  `codTurma` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `solicitacoes`
--

INSERT INTO `solicitacoes` (`id_solicitacao`, `cod_solicitacao`, `Observacao`, `Situacao`, `Data_criacao`, `codTurma`) VALUES
(5, 1, '', 'Em criação', '2024-07-25 13:41:47', 'S3naiAdmin');

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
('42.555.657/0001-65', 20, 'Graédi Transportes', '88303-36', '(47) 3011-3400', 'São Judas', 'Rua Rosendo Claudino de Freitas', 'Itajaí', 'SC');

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
('S3naiAdmin', 'SenaiADM', 0, '2024-05-29 20:59:55');

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
-- Índices de tabela `itensestoque`
--
ALTER TABLE `itensestoque`
  ADD PRIMARY KEY (`cod_itenEstoque`),
  ADD KEY `FK_codestoque` (`cod_estoque`),
  ADD KEY `FK_codItemPedido` (`cod_itenpedido`),
  ADD KEY `FK_id_turma` (`codTurma`);

--
-- Índices de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  ADD PRIMARY KEY (`cod_itenPedido`),
  ADD KEY `FK_cod_produto` (`cod_produto`),
  ADD KEY `FK_cod_pedido` (`cod_pedido`),
  ADD KEY `FK_cod_turma_item` (`codTurma`);

--
-- Índices de tabela `itenssolicitacao`
--
ALTER TABLE `itenssolicitacao`
  ADD PRIMARY KEY (`cod_itemSolicitacao`),
  ADD KEY `FK_cod_PRODUTO` (`cod_produto`),
  ADD KEY `FK_COD_TURMAS` (`codTurma`),
  ADD KEY `FK_COD_SOLICITACAO` (`cod_solicitacao`);

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
-- Índices de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD PRIMARY KEY (`id_solicitacao`),
  ADD KEY `FK_COD_TURMA` (`codTurma`);

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
  MODIFY `cod_doca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `cod_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `itensestoque`
--
ALTER TABLE `itensestoque`
  MODIFY `cod_itenEstoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  MODIFY `cod_itenPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `itenssolicitacao`
--
ALTER TABLE `itenssolicitacao`
  MODIFY `cod_itemSolicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `idprojeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `solicitacoes`
--
ALTER TABLE `solicitacoes`
  MODIFY `id_solicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itensestoque`
--
ALTER TABLE `itensestoque`
  ADD CONSTRAINT `FK_codItemPedido` FOREIGN KEY (`cod_itenpedido`) REFERENCES `itenspedido` (`cod_itenPedido`),
  ADD CONSTRAINT `FK_codestoque` FOREIGN KEY (`cod_estoque`) REFERENCES `estoque` (`cod_estoque`),
  ADD CONSTRAINT `FK_id_turma` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `itenssolicitacao`
--
ALTER TABLE `itenssolicitacao`
  ADD CONSTRAINT `FK_COD_SOLICITACAO` FOREIGN KEY (`cod_solicitacao`) REFERENCES `solicitacoes` (`id_solicitacao`),
  ADD CONSTRAINT `FK_COD_TURMAS` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`),
  ADD CONSTRAINT `FK_cod_PRODUTO` FOREIGN KEY (`cod_produto`) REFERENCES `produtos` (`cod_produto`);

--
-- Restrições para tabelas `solicitacoes`
--
ALTER TABLE `solicitacoes`
  ADD CONSTRAINT `FK_COD_TURMA` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
