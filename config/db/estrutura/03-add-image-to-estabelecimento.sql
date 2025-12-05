-- ============================
-- Recomendo excluir o banco anterior e executar o query-unico.sql atualizado
-- ============================

-- Add imagem column to estabelecimento
ALTER TABLE estabelecimento ADD COLUMN imagem VARCHAR(255);
