ALTER TABLE usuario ADD COLUMN tipo_acesso VARCHAR(31) DEFAULT 'USER';
ALTER TABLE usuario ADD COLUMN logradouro VARCHAR(127);
ALTER TABLE usuario ADD COLUMN numero_casa INT;
ALTER TABLE usuario ADD COLUMN cidade VARCHAR(127);
ALTER TABLE usuario ADD COLUMN uf VARCHAR(2);
ALTER TABLE usuario ADD COLUMN cep VARCHAR(8);

ALTER TABLE estabelecimento DROP COLUMN endereco;
ALTER TABLE estabelecimento ADD COLUMN logradouro VARCHAR(127);
ALTER TABLE estabelecimento ADD COLUMN numero_casa INT;
ALTER TABLE estabelecimento ADD COLUMN cidade VARCHAR(127);
ALTER TABLE estabelecimento ADD COLUMN uf VARCHAR(2);
ALTER TABLE estabelecimento ADD COLUMN cep VARCHAR(8);
ALTER TABLE estabelecimento ADD COLUMN pontos_base INT;