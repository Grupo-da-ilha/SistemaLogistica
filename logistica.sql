-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/05/2024 às 22:58
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`Id`, `email`, `senha`, `nome`, `ativo`, `data_entrada`, `tipousuario`, `codTurma`) VALUES
(124, 'kauan007@gmail.com', 'eijks', 'Kauan', 's', '2024-05-29 21:01:11', 'Professor', 'S3naiAdmin');

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
  `cod_pedido` int(11) NOT NULL,
  `codprojeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `docas`
--

INSERT INTO `docas` (`cod_doca`, `posicao`, `cod_pedido`, `codprojeto`) VALUES
(16, 'A1', 1, 5);

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
  `ValorUnitario` double NOT NULL,
  `ValorTotal` double NOT NULL,
  `Avariado` tinyint(1) NOT NULL,
  `Faltando` tinyint(1) NOT NULL,
  `VistoriaConcluida` tinyint(1) NOT NULL,
  `codprojeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `itenspedido`
--

INSERT INTO `itenspedido` (`cod_itenPedido`, `cod_produto`, `cod_pedido`, `Quantidade`, `ValorUnitario`, `ValorTotal`, `Avariado`, `Faltando`, `VistoriaConcluida`, `codprojeto`) VALUES
(115, 1, 11, 2, 5.5, 11, 0, 0, 0, 6),
(118, 1, 11, 2, 5.5, 11, 0, 0, 0, 6),
(127, 1, 1, 5, 5.5, 27.5, 1, 1, 1, 5),
(128, 2, 1, 3, 1.2, 3.6, 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota_fiscal`
--

CREATE TABLE `nota_fiscal` (
  `cod_nota` int(11) NOT NULL,
  `chave_acesso` varchar(65) NOT NULL,
  `DataExpedicao` datetime NOT NULL,
  `InformacoesAdicionais` varchar(255) NOT NULL,
  `cod_pedido` int(11) NOT NULL,
  `CNPJ_Destinatario` varchar(65) NOT NULL,
  `CNPJ_Transportadora` varchar(65) NOT NULL,
  `CNPJ_Emitente` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `nota_fiscal`
--

INSERT INTO `nota_fiscal` (`cod_nota`, `chave_acesso`, `DataExpedicao`, `InformacoesAdicionais`, `cod_pedido`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `CNPJ_Emitente`) VALUES
(64029, '35364095924551024804542641476196790032831620', '2024-05-29 18:27:04', 'Pedido deve ser entregue com antecedência', 1, '03.774.819/0001-02', '07.639.029/0001-67', '03.389.993/0001-23'),
(84817, '18670429376789829333058572513610113722260039', '2024-05-29 18:27:04', '', 11, '03.774.819/0001-02', '07.639.029/0001-67', '03.389.993/0001-23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `cod_pedido` int(11) NOT NULL,
  `DataVenda` datetime NOT NULL,
  `ValorTotal` double NOT NULL,
  `CNPJEmitente` varchar(65) NOT NULL,
  `CNPJ_Destinatario` varchar(64) NOT NULL,
  `CNPJ_Transportadora` varchar(65) NOT NULL,
  `Situacao` varchar(255) NOT NULL,
  `InformacaoAdicional` varchar(255) NOT NULL,
  `codprojeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`cod_pedido`, `DataVenda`, `ValorTotal`, `CNPJEmitente`, `CNPJ_Destinatario`, `CNPJ_Transportadora`, `Situacao`, `InformacaoAdicional`, `codprojeto`) VALUES
(1, '2024-05-29 18:27:04', 31.1, '03.389.993/0001-23', '03.774.819/0001-02', '07.639.029/0001-67', 'Em transporte', 'Pedido deve ser entregue com antecedência', 5),
(11, '2024-05-29 18:45:49', 22, '44.990.901/0001-43', '03.774.819/0001-02', '42.555.657/0001-65', 'Em transporte', '', 6);

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
(5, 'Senai', 'S3naiAdmin'),
(6, 'Projeto 1', 'S3naiAdmin');

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
('S3naiAdmin', 'SenaiADM', 0, '2024-05-29 20:59:55');

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
-- Índices de tabela `docas`
--
ALTER TABLE `docas`
  ADD PRIMARY KEY (`cod_doca`),
  ADD KEY `cod_pedido` (`cod_pedido`),
  ADD KEY `codprojeto` (`codprojeto`);

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
  ADD KEY `cod_produto` (`cod_produto`),
  ADD KEY `codprojeto` (`codprojeto`);

--
-- Índices de tabela `nota_fiscal`
--
ALTER TABLE `nota_fiscal`
  ADD PRIMARY KEY (`cod_nota`),
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
  ADD KEY `CNPJ` (`CNPJ_Transportadora`),
  ADD KEY `codprojeto` (`codprojeto`);

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
  ADD KEY `codTurma` (`codTurma`);

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de tabela `docas`
--
ALTER TABLE `docas`
  MODIFY `cod_doca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `itenspedido`
--
ALTER TABLE `itenspedido`
  MODIFY `cod_itenPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `cod_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `idprojeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cadastro`
--
ALTER TABLE `cadastro`
  ADD CONSTRAINT `cadastro_ibfk_1` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);

--
-- Restrições para tabelas `docas`
--
ALTER TABLE `docas`
  ADD CONSTRAINT `docas_ibfk_1` FOREIGN KEY (`cod_pedido`) REFERENCES `pedido` (`cod_pedido`),
  ADD CONSTRAINT `docas_ibfk_2` FOREIGN KEY (`codprojeto`) REFERENCES `projetos` (`idprojeto`);

--
-- Restrições para tabelas `itenspedido`
--
ALTER TABLE `itenspedido`
  ADD CONSTRAINT `itenspedido_ibfk_1` FOREIGN KEY (`cod_pedido`) REFERENCES `pedido` (`cod_pedido`),
  ADD CONSTRAINT `itenspedido_ibfk_2` FOREIGN KEY (`cod_produto`) REFERENCES `produtos` (`cod_produto`),
  ADD CONSTRAINT `itenspedido_ibfk_3` FOREIGN KEY (`codprojeto`) REFERENCES `projetos` (`idprojeto`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`codprojeto`) REFERENCES `projetos` (`idprojeto`);

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`codTurma`) REFERENCES `turmas` (`codTurma`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
