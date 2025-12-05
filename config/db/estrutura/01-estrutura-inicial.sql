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
    pontos_totais INT DEFAULT 0
);

-- ============================
-- TABELA ESTABELECIMENTO
-- ============================
CREATE TABLE estabelecimento (
    id_estab SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    endereco VARCHAR(255),
    descricao TEXT,
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
