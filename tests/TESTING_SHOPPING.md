# Guia de Teste - Sistema de Compra (Pontos + Dinheiro)

## Pré-requisitos

- Banco atualizado com tabela `compra_experiencia`
- XAMPP rodando
- Acesso a `http://localhost/TravelTrack/`

---

## Teste 1: Modal de Compra Abre Corretamente

### Passos:
1. Login com `joao@gmail.com` / `123`
2. Na página de Dashboard ou Locais, clique no botão "Comprar" de um local
3. **Verificação**:
   - ✅ Modal abre com título do local
   - ✅ Duas abas visíveis: "Trocar Pontos" e "Comprar com Dinheiro"
   - ✅ Aba "Trocar Pontos" ativa por padrão

---

## Teste 2: Compra com Pontos (Aba 1)

### Passos:
1. No modal, verifique a aba "Trocar Pontos"
2. Veja o saldo atual de pontos (ex: "Seu saldo atual: 150 pts")
3. Veja o custo da experiência (ex: "Custo: 30 pontos")
4. **Se tem pontos suficientes**:
   - ✅ Botão "Confirmar Compra com Pontos" habilitado
   - ✅ Mensagem verde: "Você tem pontos suficientes!"
   - Clique para confirmar
5. **Se NÃO tem pontos suficientes**:
   - ✅ Botão desabilitado (grayed out)
   - ✅ Mensagem vermelha: "Você precisa de mais X pontos"

### Resultado:
- Página redireciona com mensagem: "Experiência adquirida com sucesso! Pontos restantes: 120"
- Saldo de pontos diminui

---

## Teste 3: Compra com Dinheiro (Aba 2)

### Passos:
1. No modal, clique na aba "Comprar com Dinheiro"
2. Veja a informação: "Ao comprar com dinheiro, você receberá 10 pontos por real gasto! 🎁"
3. Digite um valor (ex: 10.00) no campo "Valor a pagar (R$)"
4. **Verificação em tempo real**:
   - ✅ Campo calcula: "Você receberá: 100 pontos"
   - ✅ Cada mudança no valor atualiza os pontos (em tempo real)
5. Clique em "Comprar Agora"

### Resultado:
- Página redireciona com mensagem: "Compra realizada com sucesso! Você recebeu 100 pontos 🎉"
- Saldo de pontos **aumenta** (não diminui!)
- Ex: Se tinha 150 pts, agora tem 250 pts

---

## Teste 4: Conversão de Pontos

### Cálculo esperado:
```
1 real = 10 pontos

Exemplos:
- Compra de R$ 5.00 → +50 pontos
- Compra de R$ 10.50 → +105 pontos
- Compra de R$ 0.01 → +0 pontos (arredonda para baixo)
```

### Teste:
1. Compre com R$ 7.50
2. **Verificação**:
   - ✅ Calcula 75 pontos
   - ✅ Pontos são adicionados corretamente ao saldo

---

## Teste 5: Histórico de Compras

### Passos:
1. Faça pelo menos 1 compra com pontos e 1 com dinheiro
2. No menu, clique em "Minhas Compras"
3. **Verificação**:
   - ✅ Página carrega com título "Histórico de Minhas Compras"
   - ✅ Saldo de pontos aparece no canto superior direito

### Estatísticas (Card):
- ✅ "Total de Compras": mostra número total
- ✅ "Compras com Pontos": conta apenas com pontos
- ✅ "Compras com Dinheiro": conta apenas com dinheiro
- ✅ "Pontos Ganhos": soma total de pontos recebidos

### Tabela:
- ✅ Data e hora de cada compra
- ✅ Nome do local
- ✅ Tipo: badge "Dinheiro" (verde) ou "Pontos" (amarelo)
- ✅ **Valor**:
  - Se dinheiro: "R$ X,XX"
  - Se pontos: "-X pts" (em vermelho)
- ✅ **Pontos**:
  - Se dinheiro: "+X pts" (verde)
  - Se pontos: "—" (traço)

---

## Teste 6: Dados no Banco

### Via phpMyAdmin - Tabela `compra_experiencia`:

1. Compre com pontos (custo 30 pts):
   ```sql
   SELECT * FROM compra_experiencia WHERE id_usuario = 1 ORDER BY id_compra DESC LIMIT 1;
   ```
   **Verificação**:
   - ✅ `tipo_compra` = 'pontos'
   - ✅ `valor_gasto` = 30
   - ✅ `pontos_recebidos` = 0
   - ✅ `valor_real` = 0

2. Compre com dinheiro (R$ 10):
   ```sql
   SELECT * FROM compra_experiencia WHERE id_usuario = 1 ORDER BY id_compra DESC LIMIT 1;
   ```
   **Verificação**:
   - ✅ `tipo_compra` = 'dinheiro'
   - ✅ `valor_gasto` = 0
   - ✅ `pontos_recebidos` = 100
   - ✅ `valor_real` = 10.00

### Tabela `usuario`:

1. Após comprar com pontos (-30):
   ```sql
   SELECT pontos_totais FROM usuario WHERE id_usuario = 1;
   ```
   **Verificação**:
   - ✅ Diminui o valor de pontos

2. Após comprar com dinheiro (R$ 10 = +100 pontos):
   ```sql
   SELECT pontos_totais FROM usuario WHERE id_usuario = 1;
   ```
   **Verificação**:
   - ✅ Aumenta o valor de pontos

---

## Teste 7: Validações e Erros

### Teste com valor inválido:
1. Na aba "Comprar com Dinheiro", tente:
   - Deixar em branco → Campo "required"
   - Colocar 0 → Resultado: Erro no controller
   - Colocar negativo → Validação do form

### Teste sem estar logado:
1. Faça logout
2. Tente acessar "Minhas Compras" manualmente: `http://localhost/TravelTrack/index.php?page=shopping_history`
3. **Verificação**:
   - ✅ Redireciona para login

---

## Teste 8: Fluxo Completo

### Cenário:
Usuário começa com 150 pontos, faz:
1. Compra com 30 pontos → 120 pts
2. Compra com R$ 5 (50 pontos) → 170 pts
3. Compra com R$ 2 (20 pontos) → 190 pts
4. Compra com 50 pontos → 140 pts

### Verificação Final:
- ✅ Histórico mostra 4 compras
- ✅ Total de Compras: 4
- ✅ Compras com Pontos: 2
- ✅ Compras com Dinheiro: 2
- ✅ Pontos Ganhos: 70 (50 + 20)
- ✅ Saldo final: 140 pts

---

## Teste 9: Modal em Múltiplos Locais

### Passos:
1. No Dashboard, veja 3-4 locais diferentes
2. Cada local tem seu próprio botão "Comprar"
3. Clique em "Comprar" para diferentes locais
4. **Verificação**:
   - ✅ Cada modal é independente
   - ✅ Título muda conforme o local
   - ✅ Custo em pontos é diferente para cada local
   - ✅ Não há conflito entre modais

---

## Resumo de Funcionalidades Testadas

| Feature | Status | Testado |
|---------|--------|---------|
| Modal de compra abre | ✅ OK | ❓ |
| Aba "Trocar Pontos" | ✅ OK | ❓ |
| Aba "Comprar com Dinheiro" | ✅ OK | ❓ |
| Cálculo de pontos em tempo real | ✅ OK | ❓ |
| Validação de pontos suficientes | ✅ OK | ❓ |
| Histórico de compras | ✅ OK | ❓ |
| Estatísticas de compras | ✅ OK | ❓ |
| Conversão R$ → Pontos (1:10) | ✅ OK | ❓ |
| Banco: tabela `compra_experiencia` | ✅ OK | ❓ |
| Banco: atualização de `usuario.pontos_totais` | ✅ OK | ❓ |
| Link "Minhas Compras" no menu | ✅ OK | ❓ |
| Redirect ao deslogado | ✅ OK | ❓ |

---

## Comandos Úteis

### Limpar histórico de compras:
```sql
DELETE FROM compra_experiencia WHERE id_usuario = 1;
```

### Ver todas as compras de um usuário:
```sql
SELECT * FROM compra_experiencia WHERE id_usuario = 1 ORDER BY data_compra DESC;
```

### Resetar pontos:
```sql
UPDATE usuario SET pontos_totais = 150 WHERE id_usuario = 1;
```

### Total ganho com compras em dinheiro:
```sql
SELECT SUM(pontos_recebidos) FROM compra_experiencia WHERE id_usuario = 1 AND tipo_compra = 'dinheiro';
```

### Total gasto com compras em pontos:
```sql
SELECT SUM(valor_gasto) FROM compra_experiencia WHERE id_usuario = 1 AND tipo_compra = 'pontos';
```

---

**Fim do Guia de Teste de Compra**
