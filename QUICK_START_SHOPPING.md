# 🚀 Instruções Rápidas - Sistema de Compra

## 1️⃣ Preparar Banco de Dados

Se o banco `traveltrack` já existe, execute:

```sql
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS tipo_acesso VARCHAR(10) DEFAULT 'USER';
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS logradouro VARCHAR(255);
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS numero_casa INT;
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS cidade VARCHAR(100);
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS uf VARCHAR(2);
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS cep VARCHAR(8);
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS latitude DECIMAL(10, 8);
ALTER TABLE usuario ADD COLUMN IF NOT EXISTS longitude DECIMAL(11, 8);

-- Criar tabela de compras
CREATE TABLE IF NOT EXISTS compra_experiencia (
    id_compra SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_estab INT NOT NULL REFERENCES estabelecimento(id_estab),
    tipo_compra VARCHAR(20) NOT NULL DEFAULT 'pontos',
    valor_gasto DECIMAL(10, 2) NOT NULL,
    pontos_recebidos INT DEFAULT 0,
    valor_real DECIMAL(10, 2) DEFAULT 0,
    data_compra TIMESTAMP DEFAULT NOW()
);
```

Se o banco é novo, use o script:
```
config/db/estrutura/01-estrutura-inicial.sql
config/db/carga/01-carga-inicial.sql
config/db/carga/02-carga-enderecos.sql
```

---

## 2️⃣ Testar no Navegador

### Login
- Email: `joao@gmail.com`
- Senha: `123`

### Testar Compra com Pontos
1. Dashboard ou Locais
2. Click "Comprar" em um local
3. Modal abre
4. Aba "Trocar Pontos" (ativa)
5. Click "Confirmar Compra com Pontos"
6. ✅ Pontos descontam

### Testar Compra com Dinheiro
1. Dashboard ou Locais
2. Click "Comprar" em um local
3. Modal abre
4. Click na aba "Comprar com Dinheiro"
5. Digite valor (ex: 10.00)
6. Veja: "Você receberá: 100 pontos"
7. Click "Comprar Agora"
8. ✅ Pontos aumentam

### Ver Histórico
1. Menu → "Minhas Compras"
2. Veja estatísticas e tabela

---

## 3️⃣ Arquivos Necessários

Certifique-se que existem:

```
✅ models/ShoppingModel.php
✅ controllers/ShoppingController.php
✅ views/_shared/shopping_modal.php
✅ views/user/shopping_history.php
✅ config/db/estrutura/01-estrutura-inicial.sql (com tabela compra_experiencia)
✅ index.php (com rotas shopping_*)
✅ views/_shared/header.php (com link "Minhas Compras")
```

---

## 4️⃣ Erros Comuns e Soluções

### ❌ "Tabela compra_experiencia não existe"
**Solução**: Execute o SQL acima ou rode o script de estrutura

### ❌ "Modal não aparece"
**Solução**: Certifique-se que `shopping_modal.php` existe em `views/_shared/`

### ❌ "Cálculo de pontos não funciona"
**Solução**: Verifique se JavaScript está habilitado no navegador

### ❌ "Compra não registra"
**Solução**: Verifique credenciais do BD em `config/database.php`

---

## 5️⃣ Ajustar Conversão de Pontos

Se quer mudar de "1 real = 10 pontos" para outro valor:

**Arquivo**: `models/ShoppingModel.php`

Procure por:
```php
private $CONVERSION_RATE = 10; // ← Mude aqui
```

Exemplos:
- `5` = 1 real = 5 pontos
- `20` = 1 real = 20 pontos
- `100` = 1 real = 100 pontos

---

## 6️⃣ Monitorar Transações

### Ver todas as compras:
```sql
SELECT u.nome, e.nome as local, ce.tipo_compra, ce.valor_real, ce.valor_gasto, ce.pontos_recebidos, ce.data_compra 
FROM compra_experiencia ce
JOIN usuario u ON u.id_usuario = ce.id_usuario
JOIN estabelecimento e ON e.id_estab = ce.id_estab
ORDER BY ce.data_compra DESC;
```

### Receita total:
```sql
SELECT SUM(valor_real) as receita_total FROM compra_experiencia;
```

### Usuários que compraram com dinheiro:
```sql
SELECT DISTINCT u.nome, u.email 
FROM compra_experiencia ce
JOIN usuario u ON u.id_usuario = ce.id_usuario
WHERE ce.tipo_compra = 'dinheiro';
```

---

## 7️⃣ Documentação Completa

Leia os documentos detalhados:

- **Guia de Teste**: `tests/TESTING_SHOPPING.md`
- **Arquitetura Técnica**: `docs/SHOPPING_SYSTEM.md`
- **Teste Manual**: `tests/TESTING.md`

---

## 8️⃣ Próximos Passos (Melhorias)

- [ ] Integração com gateway de pagamento (Stripe, PayPal)
- [ ] Processamento assíncrono de pagamentos
- [ ] Email de confirmação de compra
- [ ] Relatórios de vendas/receita
- [ ] Limite de compras por usuário/dia
- [ ] Cupons e promoções
- [ ] Estatísticas de conversão

---

**Tudo pronto! Sistema funcional e testado.** ✅
