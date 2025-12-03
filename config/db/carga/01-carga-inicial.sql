INSERT INTO usuario (nome, email, senha, pontos_totais) VALUES
('João Silva', 'joao@gmail.com', '123', 150),
('Maria Souza', 'maria@gmail.com', '123', 320),
('Carlos Lima', 'carlos@gmail.com', '123', 80),
('Ana Ferreira', 'ana@gmail.com', '123', 210),
('Pedro Santos', 'pedro@gmail.com', '123', 60),
('Juliana Rocha', 'juliana@gmail.com', '123', 190),
('Rafael Moura', 'rafael@gmail.com', '123', 75),
('Beatriz Lopes', 'beatriz@gmail.com', '123', 260);

INSERT INTO estabelecimento (nome, endereco, descricao, tipo) VALUES
('Parque das Nações Indígenas', 'Parque das Nações Indigenas, Av. Afonso Pena, Campo Grande - MS', 
 'Um dos maiores parques urbanos da América Latina, ideal para lazer e contato com a natureza.', 
 'Parque Urbano'),

('Recanto Ecológico Rio da Prata', 'Recanto Ecológico Rio da Prata, Jardim - MS', 
 'Famoso passeio de flutuação em águas cristalinas, com vasta biodiversidade.', 
 'Ecoturismo'),

('Buraco das Araras', 'Buraco das Araras Jardim - MS', 
 'Enorme dolina com centenas de araras vermelhas; ponto turístico muito procurado.', 
 'Natureza'),

('Complexo de Bonito', 'Bonito - MS', 
 'Conjunto turístico com grutas, balneários e trilhas ecológicas.', 
 'Turismo Ecológico');


INSERT INTO checkin (id_usuario, id_estab, pontos_gerados) VALUES
(1, 1, 30),
(1, 3, 50),
(2, 2, 40),
(2, 4, 35),
(3, 1, 20),
(3, 3, 25),
(4, 2, 40),
(4, 3, 30),
(5, 4, 35),
(6, 1, 30),
(7, 3, 25),
(8, 2, 40);

INSERT INTO avaliacao (id_usuario, id_estab, nota, comentario) VALUES
(1, 1, 5, 'Lugar incrível, recomendo!'),
(2, 2, 4, 'Muito interessante e bem organizado.'),
(3, 3, 5, 'Praia maravilhosa!'),
(4, 4, 4, 'Parque muito agradável.'),
(6, 1, 5, 'Voltaria sempre!'),
(8, 2, 3, 'Legal, mas poderia ser melhor.');

INSERT INTO recompensa (titulo, descricao, custo_pontos) VALUES
('Desconto 10% Passagem', 'Voucher digital para desconto em passagens.', 200),
('Desconto 20% Passagem', 'Voucher digital para desconto em passagens.', 350),
('Desconto 50% Passagem', 'Voucher digital para desconto em passagens.', 600),
('Desconto 70% Passagem', 'Voucher digital para desconto em passagens.', 900);

INSERT INTO resgate_pontos (id_usuario, id_recompensa) VALUES
(2, 1),
(1, 2),
(4, 3),
(6, 2),
(8, 4),
(3, 1);
