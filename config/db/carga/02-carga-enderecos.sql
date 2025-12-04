UPDATE usuario
SET tipo_acesso = 'USER'
WHERE id_usuario > 1;  -- mantém o id 1 como admin

UPDATE usuario
SET tipo_acesso = 'ADM'
WHERE id_usuario = 1;  -- mantém o id 1 como admin

UPDATE estabelecimento
SET pontos_base = 20
WHERE id_estab > 0;

-- ===========================================
-- UPDATE DOS 4 ESTABELECIMENTOS EXISTENTES
-- ===========================================

-- 1. Parque das Nações Indígenas (Campo Grande - MS)
UPDATE estabelecimento
SET 
    logradouro = 'Av. Afonso Pena',
    numero_casa = 0,
    cidade = 'Campo Grande',
    uf = 'MS',
    cep = '79020000',
    pontos_base = 30
WHERE id_estab = 1;

-- 2. Recanto Ecológico Rio da Prata (Bonito/Jardim - MS)
UPDATE estabelecimento
SET 
    logradouro = 'Rodovia Bonito/Jardim',
    numero_casa = 0,
    cidade = 'Jardim',
    uf = 'MS',
    cep = '79240000',
    pontos_base = 45
WHERE id_estab = 2;

-- 3. Buraco das Araras (Jardim - MS)
UPDATE estabelecimento
SET 
    logradouro = 'Fazenda Alegria',
    numero_casa = 1,
    cidade = 'Jardim',
    uf = 'MS',
    cep = '79240000',
    pontos_base = 50
WHERE id_estab = 3;

-- 4. Complexo de Bonito (Bonito - MS)
UPDATE estabelecimento
SET 
    logradouro = 'Centro Turístico de Bonito',
    numero_casa = 0,
    cidade = 'Bonito',
    uf = 'MS',
    cep = '79290000',
    pontos_base = 40
WHERE id_estab = 4;