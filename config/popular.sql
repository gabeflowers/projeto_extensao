INSERT INTO `empresa` (`nome`, `dtCadastro`) VALUES
('Empresa A', '2023-01-01'),
('Empresa B', '2023-02-01'),
('Empresa C', '2023-03-01');

-- Inserindo dados na tabela perfil
INSERT INTO `perfil` (`nome`) VALUES
('Administrador'),
('Gerente'),
('Funcionário');

-- Inserindo dados na tabela sessao
INSERT INTO `sessao` (`nome`) VALUES
('Sessão A'),
('Sessão B'),
('Sessão C');

-- Inserindo dados na tabela usuario
INSERT INTO `usuario` (`idEmpresa`, `idPerfil`, `nome`, `email`, `dtCadastro`, `ativo`) VALUES
(1, 1, 'Usuário Admin', 'admin@empresa.com', '2023-01-01 10:00:00', 'S'),
(2, 2, 'Usuário Gerente', 'gerente@empresa.com', '2023-02-01 11:00:00', 'S'),
(3, 3, 'Usuário Funcionário', 'funcionario@empresa.com', '2023-03-01 12:00:00', 'S');

-- Inserindo dados na tabela centrocusto
INSERT INTO `centrocusto` (`idUsuario`, `nome`, `ativo`, `dtCadastro`) VALUES
(1, 'Centro de Custo A', 'S', '2023-01-01 10:00:00'),
(2, 'Centro de Custo B', 'S', '2023-02-01 11:00:00'),
(3, 'Centro de Custo C', 'S', '2023-03-01 12:00:00');

-- Inserindo dados na tabela despesa
INSERT INTO `despesa` (`idCentroCusto`, `idUsuario`, `nome`, `dtCadastro`, `ativo`) VALUES
(1, 1, 'Despesa A', '2023-01-01 10:00:00', 'S'),
(2, 2, 'Despesa B', '2023-02-01 11:00:00', 'S'),
(3, 3, 'Despesa C', '2023-03-01 12:00:00', 'S');

-- Inserindo dados na tabela lancamentodespesa
INSERT INTO `lancamentodespesa` (`idDespesa`, `idUsuario`, `parcela`, `dtCadastro`, `dtVencimento`, `valor`, `dtPagamento`, `valorPago`, `observacoes`, `ativo`) VALUES
(1, 1, 1, '2023-01-01 10:00:00', '2023-01-10', 100.00, '2023-01-09', 100.00, 'Pagamento efetuado', 'S'),
(2, 2, 2, '2023-02-01 11:00:00', '2023-02-10', 200.00, '2023-02-09', 200.00, 'Pagamento efetuado', 'S'),
(3, 3, 3, '2023-03-01 12:00:00', '2023-03-10', 300.00, '2023-03-09', 300.00, 'Pagamento efetuado', 'S');

-- Inserindo dados na tabela perfisessao
INSERT INTO `perfisessao` (`idPerfil`, `idSessao`) VALUES
(1, 1),
(2, 2),
(3, 3);