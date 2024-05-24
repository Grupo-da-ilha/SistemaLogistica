-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/05/2024 às 00:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `Id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `data_entrada` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipousuario` varchar(255) NOT NULL,
  `codTurma` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`Id`, `email`, `senha`, `nome`, `ativo`, `data_entrada`, `tipousuario`, `codTurma`) VALUES
(123, 'kauan007@gmail.com', 'eijks', 'Kauan', 's', '2024-05-21 22:27:57', 'Professor', 'S3naiAdmin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `CNPJ` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CEP` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Telefone` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`CNPJ`, `Nome`, `CEP`, `Telefone`) VALUES
('03.774.819/0001-02', 'SENAI ITAJAÍ', '88305-55', '(47) 3341-2900');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `cod_estoque` int(11) NOT NULL,
  `Prateleiras` int(11) NOT NULL,
  `Setor` varchar(255) NOT NULL,
  `Andar` int(11) NOT NULL,
  `Apartamento` int(11) NOT NULL,
  `idFabricantes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fabricantes`
--

CREATE TABLE `fabricantes` (
  `CNPJ` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CEP` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Telefone` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `fabricantes`
--

INSERT INTO `fabricantes` (`CNPJ`, `Nome`, `CEP`, `Telefone`) VALUES
('03.389.993/0001-23', 'CIS', '88.304-101', '(47) 3247-9763'),
('07.175.725/0001-60', 'WEG', '88.311-720', '(47) 3276-7311'),
('44.990.901/0001-43', 'Tilibra', '17013-900', '(14) 3235-4003');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itenspedido`
--

CREATE TABLE `itenspedido` (
  `cod_itenPedido` int(11) NOT NULL,
  `cod_produto` int(11) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL,
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `itenspedido`
--

INSERT INTO `itenspedido` (`cod_itenPedido`, `cod_produto`, `cod_pedido`, `Quantidade`, `ValorUnitario`, `ValorTotal`) VALUES
(102, 1, 1, 2, 5.5, 11),
(103, 2, 1, 1, 1.2, 1.2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_fiscal`
--

CREATE TABLE `nota_fiscal` (
  `chave_acesso` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `DataExpedicao` datetime NOT NULL,
  `InformacoesAdicionais` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `CNPJ_Destinatario` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_Transportadora` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_Emitente` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `nota_fiscal`
--

INSERT INTO `nota_fiscal` (`chave_acesso`, `DataExpedicao`, `InformacoesAdicionais`, `cod_pedido`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `CNPJ_Emitente`) VALUES
('87944123004087564261476436429885448813782899', '2024-05-21 20:18:49', 'Cuidado com os lápis, pois são frágeis', 1, '03.774.819/0001-02', '07.639.029/0001-67', '44.990.901/0001-43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `cod_pedido` int(11) NOT NULL,
  `DataVenda` datetime NOT NULL,
  `ValorTotal` double NOT NULL,
  `CNPJEmitente` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_Destinatario` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CNPJ_Transportadora` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Situacao` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `InformacaoAdicional` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`cod_pedido`, `DataVenda`, `ValorTotal`, `CNPJEmitente`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `Situacao`, `InformacaoAdicional`) VALUES
(1, '2024-05-21 20:18:49', 12.2, '44.990.901/0001-43', '03.774.819/0001-02', '07.639.029/0001-67', 'Em transporte', 'Cuidado com os lápis, pois são frágeis');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `cod_produto` int(11) NOT NULL,
  `PrecoUNI` double NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PesoGramas` double DEFAULT NULL,
  `NCM` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `UN` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `nome` varchar(12) NOT NULL,
  `Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `projetos`
--

INSERT INTO `projetos` (`idprojeto`, `nome`, `Id`) VALUES
(78, 'SENAI', 123),
(85, 'SENAI', 123),
(86, '', 123),
(87, 'SENAI 4', 123);

-- --------------------------------------------------------

--
-- Estrutura para tabela `transportadoras`
--

CREATE TABLE `transportadoras` (
  `CNPJ` varchar(65) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `QuantidadeFrota` int(11) NOT NULL,
  `Nome` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `CEP` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Telefone` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `transportadoras`
--

INSERT INTO `transportadoras` (`CNPJ`, `QuantidadeFrota`, `Nome`, `CEP`, `Telefone`, `bairro`, `rua`, `cidade`, `estado`) VALUES
('07.639.029/0001-67', 15, 'Tac Transportes', '88301-49', '(47) 2104-4600', 'Fazenda', 'Rua J?lio Coutinho', 'Itaja?', 'SC'),
('13.161.095/0001-77', 30, 'NSL Brasil', '88303-20', '(47) 3045-4141', 'Vila Oper?ria', 'Rua Carlos Seara', 'Itaja?', 'SC'),
('42.555.657/0001-65', 20, 'Graédi Transportes', '88303-36', '(47) 3011-3400', 'S?o Judas', 'Rua Rosendo Claudino de Freitas', 'Itaja?', 'SC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `turmas`
--

CREATE TABLE `turmas` (
  `codTurma` varchar(258) NOT NULL,
  `nomeTurma` varchar(50) NOT NULL,
  `total_alunos` int(11) DEFAULT 0,
  `data_turma` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `turmas`
--

INSERT INTO `turmas` (`codTurma`, `nomeTurma`, `total_alunos`, `data_turma`) VALUES
('S3naiAdmin', 'SENAI', 0, '2024-05-15 03:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `codTurma` (`codTurma`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`CNPJ`);

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
  ADD KEY `cod_pedido` (`cod_pedido`),
  ADD KEY `cod_produto` (`cod_produto`);

--
-- Índices de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD PRIMARY KEY (`chave_acesso`),
  ADD KEY `cod_pedido` (`cod_pedido`),
  ADD KEY `CNPJ_Destinatario` (`CNPJ_Destinatario`),
  ADD KEY `CNPJ_Transportadora` (`CNPJ_Transportadora`),
  ADD KEY `CNPJ_Emitente` (`CNPJ_Emitente`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`cod_pedido`),
  ADD KEY `CPF` (`CNPJ_Destinatario`),
  ADD KEY `CNPJEmitente` (`CNPJEmitente`),
  ADD KEY `CNPJ` (`CNPJ_Transportadora`);

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
  ADD KEY `idaluno` (`Id`);

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
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  MODIFY `cod_itenPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `idprojeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cadastro`
--
ALTER TABLE `cadastro`
  ADD CONSTRAINT `cadastro_ibfk_1` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `itenspedido`
--
ALTER TABLE `itenspedido`
  ADD CONSTRAINT `itenspedido_ibfk_1` FOREIGN KEY (`cod_pedido`) REFERENCES `pedido` (`cod_pedido`),
  ADD CONSTRAINT `itenspedido_ibfk_2` FOREIGN KEY (`cod_produto`) REFERENCES `produtos` (`cod_produto`);

--
-- Restrições para tabelas `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD CONSTRAINT `nota_fiscal_ibfk_1` FOREIGN KEY (`cod_pedido`) REFERENCES `pedido` (`cod_pedido`),
  ADD CONSTRAINT `nota_fiscal_ibfk_2` FOREIGN KEY (`CNPJ_Destinatario`) REFERENCES `clientes` (`CNPJ`),
  ADD CONSTRAINT `nota_fiscal_ibfk_3` FOREIGN KEY (`CNPJ_Transportadora`) REFERENCES `transportadoras` (`CNPJ`),
  ADD CONSTRAINT `nota_fiscal_ibfk_4` FOREIGN KEY (`CNPJ_Emitente`) REFERENCES `fabricantes` (`CNPJ`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`CNPJ_Destinatario`) REFERENCES `clientes` (`CNPJ`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`CNPJEmitente`) REFERENCES `fabricantes` (`CNPJ`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`CNPJEmitente`) REFERENCES `fabricantes` (`CNPJ`),
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`CNPJEmitente`) REFERENCES `fabricantes` (`CNPJ`),
  ADD CONSTRAINT `pedido_ibfk_5` FOREIGN KEY (`CNPJ_Transportadora`) REFERENCES `transportadoras` (`CNPJ`);

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`Id`) REFERENCES `cadastro` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
