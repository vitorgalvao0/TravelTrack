CREATE DATABASE traveltrack;
USE traveltrack;

-- ============================
-- TABELA USUARIO
-- ============================
CREATE TABLE usuario (
    id_usuario SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    logradouro VARCHAR(127),
    numero_casa INT,
    cidade VARCHAR(127),
    uf VARCHAR(2),
    cep VARCHAR(8),
    tipo_acesso VARCHAR(31) DEFAULT 'USER',
    pontos_totais INT DEFAULT 0
);

-- ============================
-- TABELA ESTABELECIMENTO
-- ============================
CREATE TABLE estabelecimento (
    id_estab SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    logradouro VARCHAR(127),
    numero_casa INT,
    cidade VARCHAR(127),
    uf VARCHAR(2),
    cep VARCHAR(8),
    pontos_base INT,
    tipo VARCHAR(50)
);

-- ============================
-- TABELA CHECK-IN
-- ============================
CREATE TABLE checkin (
    id_checkin SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_estab INT NOT NULL REFERENCES estabelecimento(id_estab),
    data_checkin TIMESTAMP DEFAULT NOW(),
    pontos_gerados INT NOT NULL
);

-- ============================
-- TABELA AVALIACAO
-- ============================
CREATE TABLE avaliacao (
    id_avaliacao SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_estab INT NOT NULL REFERENCES estabelecimento(id_estab),
    nota INT CHECK (nota BETWEEN 1 AND 5),
    comentario TEXT,
    data_avaliacao TIMESTAMP DEFAULT NOW()
);

-- ============================
-- TABELA RECOMPENSA
-- ============================
CREATE TABLE recompensa (
    id_recompensa SERIAL PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    custo_pontos INT NOT NULL
);

-- ============================
-- TABELA RESGATE DE PONTOS
-- ============================
CREATE TABLE resgate_pontos (
    id_resgate SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_recompensa INT NOT NULL REFERENCES recompensa(id_recompensa),
    data_resgate TIMESTAMP DEFAULT NOW()
);

-- ============================
-- TABELA COMPRA DE EXPERIENCIA
-- ============================
CREATE TABLE compra_experiencia (
    id_compra SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_estab INT NOT NULL REFERENCES estabelecimento(id_estab),
    tipo_compra VARCHAR(20) NOT NULL DEFAULT 'pontos',
    valor_gasto DECIMAL(10, 2) NOT NULL,
    pontos_recebidos INT DEFAULT 0,
    valor_real DECIMAL(10, 2) DEFAULT 0,
    data_compra TIMESTAMP DEFAULT NOW()
);

-- ============================
-- CARGA INICIAL DE DADOS
-- ============================

-- ============================
-- USUÁRIOS
-- ============================
INSERT INTO usuario (nome, email, senha, logradouro, numero_casa, cidade, uf, cep, tipo_acesso, pontos_totais)
VALUES
('João Pessoa', 'joao@example.com', '$2y$10$S0kg04wfq7.psPNpMsWXm..OkVRIouaTuGAaL4NlyuJsC2PXU.aCi', 'Rua Rui Barbosa', 222, 'Campo Grande', 'MS', '79000100', 'ADM', 0),
('Guilherme Alves', 'guilherme@example.com', '$2y$10$S0kg04wfq7.psPNpMsWXm..OkVRIouaTuGAaL4NlyuJsC2PXU.aCi', 'Rua das Flores', 123, 'Campo Grande', 'MS', '79000000', 'USER', 0),
('Mariana Silva', 'mariana@example.com', '$2y$10$S0kg04wfq7.psPNpMsWXm..OkVRIouaTuGAaL4NlyuJsC2PXU.aCi', 'Av Mato Grosso', 450, 'Campo Grande', 'MS', '79002000', 'USER', 0),
('Ana Souza', 'ana@example.com', '$2y$10$S0kg04wfq7.psPNpMsWXm..OkVRIouaTuGAaL4NlyuJsC2PXU.aCi', 'Rua Dom Aquino', 555, 'Campo Grande', 'MS', '79005000', 'USER', 0);

-- ============================
-- ESTABELECIMENTOS TURÍSTICOS DO MS
-- ============================
INSERT INTO estabelecimento (nome, descricao, logradouro, numero_casa, cidade, uf, cep, pontos_base, tipo)
VALUES
('Parque das Nações Indígenas', 'Um dos maiores parques urbanos do Brasil, excelente para caminhada.', 'Av Afonso Pena', 7000, 'Campo Grande', 'MS', '79002160', 50, 'parque'),
('Bioparque Pantanal', 'Maior aquário de água doce do mundo, destaque da cidade.', 'Av Afonso Pena', 6000, 'Campo Grande', 'MS', '79002000', 80, 'aquário'),
('Morada dos Baís', 'Ponto histórico com apresentações culturais e gastronomia.', 'Av Noroeste', 5140, 'Campo Grande', 'MS', '79004500', 40, 'centro cultural'),
('Praça das Araras', 'Praça famosa com a escultura das araras e ponto turístico clássico.', 'Rua 14 de Julho', 3000, 'Campo Grande', 'MS', '79002010', 30, 'praça'),
('Buraco das Araras', 'Imensa dolina natural com rica biodiversidade.', NULL, NULL, 'Jardim', 'MS', '79460000', 120, 'atração natural'),
('Bonito - Gruta do Lago Azul', 'Principal cartão-postal de Bonito, famoso lago azul profundo.', NULL, NULL, 'Bonito', 'MS', '79290000', 150, 'gruta');

-- ============================
-- AVALIAÇÕES (2 POR ESTABELECIMENTO)
-- Total: 12 avaliações
-- Usuários rotacionados
-- ============================

-- Parque das Nações Indígenas
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(1, 1, 5, 'Excelente lugar para relaxar e caminhar.'),
(2, 1, 4, 'Muito bonito, mas estava um pouco cheio.');

-- Bioparque Pantanal
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(3, 2, 5, 'Experiência incrível, animais lindos.'),
(4, 2, 4, 'Estrutura muito boa, vale a visita.');

-- Morada dos Baís
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(1, 3, 4, 'Ótimo ambiente cultural.'),
(3, 3, 5, 'Show ao vivo foi fantástico.');

-- Praça das Araras
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(2, 4, 3, 'Simples, porém bonito.'),
(4, 4, 4, 'Boa parada rápida para fotos.');

-- Buraco das Araras
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(1, 5, 5, 'Lugar surreal, natureza impressionante!'),
(2, 5, 5, 'Visita imperdível.');

-- Gruta do Lago Azul
INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario)
VALUES
(3, 6, 5, 'Maravilhoso, uma das melhores experiências do MS.'),
(4, 6, 4, 'Muito bonito, só achei a descida cansativa.');

-- ============================
-- RECOMPENSAS
-- ============================
INSERT INTO recompensa (titulo, descricao, custo_pontos)
VALUES
('Desconto de 10% em Passeio', 'Aplique 10% de desconto em qualquer atração parceira.', 150),
('Ingresso Grátis Parque', 'Entrada gratuita para parques parceiros.', 300),
('Visita Guiada Premium', 'Tour exclusivo com guia especializado.', 500),
('Brinde Turístico', 'Camiseta ou souvenir oficial.', 200);
