# Sistema de Compra TravelTrack - Resumo Técnico

## 🎯 Visão Geral

Implementamos um **sistema de compra dual** que permite aos usuários adquirir experiências de duas formas:

1. **Trocar com Pontos**: Usa pontos já acumulados (funcionalidade similar ao antigo "Comprar")
2. **Comprar com Dinheiro**: Simula um pagamento e ganha 10 pontos por real

---

## 🗄️ Banco de Dados

### Nova Tabela: `compra_experiencia`

```sql
CREATE TABLE compra_experiencia (
    id_compra SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL REFERENCES usuario(id_usuario),
    id_estab INT NOT NULL REFERENCES estabelecimento(id_estab),
    tipo_compra VARCHAR(20) NOT NULL DEFAULT 'pontos', -- 'pontos' ou 'dinheiro'
    valor_gasto DECIMAL(10, 2) NOT NULL,               -- pontos ou reais gastos
    pontos_recebidos INT DEFAULT 0,                    -- pontos ganhos (compra money)
    valor_real DECIMAL(10, 2) DEFAULT 0,               -- valor em reais
    data_compra TIMESTAMP DEFAULT NOW()
);
```

### Relacionamentos:
- Cada compra está vinculada a um usuário (`id_usuario`)
- Cada compra está vinculada a um estabelecimento (`id_estab`)
- Campo `tipo_compra` diferencia entre 'pontos' e 'dinheiro'

---

## 📁 Arquivos Criados/Modificados

### ✅ Criados:

| Arquivo | Descrição |
|---------|-----------|
| `models/ShoppingModel.php` | Lógica de negócio: compras com pontos/dinheiro |
| `controllers/ShoppingController.php` | Rotas: processar compras, histórico |
| `views/_shared/shopping_modal.php` | Modal reutilizável (abas: pontos vs dinheiro) |
| `views/user/shopping_history.php` | Página de histórico com estatísticas |
| `tests/TESTING_SHOPPING.md` | Guia completo de testes |

### ✅ Modificados:

| Arquivo | Mudanças |
|---------|----------|
| `config/db/estrutura/01-estrutura-inicial.sql` | Adicionada tabela `compra_experiencia` |
| `index.php` | 3 novas rotas: `shopping_money`, `shopping_points`, `shopping_history` |
| `views/_shared/header.php` | Novo link no menu: "Minhas Compras" |
| `views/user/dashboard.php` | Botão "Comprar" abre modal (antes era form simples) |
| `views/user/places.php` | Botão "Comprar" abre modal (antes era form simples) |
| `README.md` | Documentação atualizada com nova feature |

---

## 🏗️ Arquitetura

### ShoppingModel

**Métodos Principais:**

1. **`buyWithMoney($user_id, $place_id, $valor_real)`**
   - Valida valor > 0
   - Calcula pontos: `valor * 10`
   - Incrementa `usuario.pontos_totais`
   - Registra em `compra_experiencia` com `tipo_compra='dinheiro'`
   - Usa transação (rollback se erro)

2. **`buyWithPoints($user_id, $place_id, $pontos_custo)`**
   - Valida pontos suficientes
   - Decrementa `usuario.pontos_totais`
   - Registra em `compra_experiencia` com `tipo_compra='pontos'`
   - Usa transação (rollback se erro)

3. **`getShoppingHistory($user_id)`**
   - Retorna todas as compras do usuário (ordenadas desc)
   - Join com `estabelecimento` para nome do local

4. **`getStats($user_id)`**
   - Retorna agregações:
     - `total_compras`
     - `compras_dinheiro`
     - `compras_pontos`
     - `total_pontos_recebidos`
     - `total_pontos_gastos`
     - `total_real_gasto`

---

## 🎨 Interface

### Modal de Compra

**Estrutura:**
```
┌─ Modal Header
│  └─ Título: "Comprar: [Nome do Local]"
│
├─ Nav Tabs
│  ├─ Tab 1: "Trocar Pontos" (ativo por padrão)
│  └─ Tab 2: "Comprar com Dinheiro"
│
├─ Tab Pane 1: Trocar Pontos
│  ├─ Info: Custo em pontos
│  ├─ Info: Saldo atual
│  ├─ Status: Verde (suficiente) ou Vermelho (insuficiente)
│  └─ Botão: "Confirmar Compra com Pontos" (disabled se insuficiente)
│
├─ Tab Pane 2: Comprar com Dinheiro
│  ├─ Info: "Receberá 10 pontos por real"
│  ├─ Input: Campo de valor (R$)
│  ├─ Display: Cálculo em tempo real de pontos
│  └─ Botão: "Comprar Agora"
│
└─ Modal Footer
   ├─ "Cancelar"
   └─ "Confirmar/Comprar"
```

**Cálculo em Tempo Real:**
- JS escuta mudanças no campo de valor
- Multiplica por 10 e atualiza display
- Funciona com valores decimais (ex: 10.50 → 105 pontos)

---

## 🔄 Fluxos

### Fluxo 1: Compra com Pontos

```
[Dashboard/Locais]
    ↓ Click "Comprar"
[Modal Abre]
    ↓
[Tab "Trocar Pontos"]
    ↓ Validação
┌─ Se pontos suficientes
│  └─ Botão habilitado → Click
│     └─ POST /shopping_points
│        └─ ShoppingController::buyWithPoints()
│           └─ ShoppingModel::buyWithPoints()
│              ├─ Decrementa pontos
│              └─ Registra em compra_experiencia
│
└─ Se pontos insuficientes
   └─ Botão desabilitado
      └─ Mensagem: "Precisa de X pontos"
    ↓
[Redirect com mensagem de sucesso/erro]
```

### Fluxo 2: Compra com Dinheiro

```
[Dashboard/Locais]
    ↓ Click "Comprar"
[Modal Abre]
    ↓
[Tab "Comprar com Dinheiro"]
    ↓ Input valor (R$)
    ↓ JS calcula pontos em tempo real
    ↓ Click "Comprar Agora"
    └─ POST /shopping_money
       └─ ShoppingController::buyWithMoney()
          └─ ShoppingModel::buyWithMoney()
             ├─ Calcula pontos (valor × 10)
             ├─ Incrementa pontos do usuário
             └─ Registra em compra_experiencia
    ↓
[Redirect com mensagem de sucesso]
  └─ "Compra realizada! Você recebeu X pontos 🎉"
```

### Fluxo 3: Ver Histórico

```
[Menu "Minhas Compras"]
    ↓
[ShoppingController::history()]
    ├─ Carrega dados do usuário
    ├─ Carrega ShoppingHistory
    └─ Carrega Stats
    ↓
[View: shopping_history.php]
    ├─ Cards com estatísticas
    └─ Tabela com histórico detalhado
```

---

## 💡 Lógica de Pontos

### Conversão

```
1 Real = 10 Pontos

Exemplos:
├─ R$ 1.00  → +10 pontos
├─ R$ 5.00  → +50 pontos
├─ R$ 10.50 → +105 pontos
├─ R$ 0.99  → +9 pontos (Math.floor)
└─ R$ 0.05  → +0 pontos
```

### Fluxo de Pontos

```
Usuário inicia: 100 pts

Ganho (Check-in):     100 + 30 = 130 pts
Gasto (Trocar):       130 - 40 = 90 pts
Ganho (Dinheiro R$5): 90 + 50 = 140 pts

Total ganho: 80 pts
Total gasto: 40 pts
Saldo: 140 pts
```

---

## 🛡️ Validações e Tratamento de Erros

### ShoppingModel validações:

1. **buyWithMoney()**
   - `valor_real > 0` → Erro
   - Usuário não existe → Erro
   - DB error → Rollback

2. **buyWithPoints()**
   - `pontos_custo > 0` → Erro
   - Usuário não existe → Erro
   - `pontos_totais < pontos_custo` → Erro + mensagem amigável
   - DB error → Rollback

### ShoppingController validações:

1. **buyWithMoney()**
   - Método POST obrigatório
   - Usuário logado obrigatório (redireciona se não)
   - `place_id` e `valor_real` obrigatórios
   - Local deve existir

2. **buyWithPoints()**
   - Método POST obrigatório
   - Usuário logado obrigatório
   - `place_id` obrigatório
   - Local deve existir

3. **history()**
   - Usuário logado obrigatório (redireciona para login se não)

---

## 📊 Banco de Dados - Queries Úteis

### Ver compras de um usuário:
```sql
SELECT * FROM compra_experiencia 
WHERE id_usuario = 1 
ORDER BY data_compra DESC;
```

### Ver compras com dinheiro:
```sql
SELECT c.*, e.nome 
FROM compra_experiencia c
JOIN estabelecimento e ON e.id_estab = c.id_estab
WHERE c.id_usuario = 1 AND c.tipo_compra = 'dinheiro';
```

### Ver compras com pontos:
```sql
SELECT c.*, e.nome 
FROM compra_experiencia c
JOIN estabelecimento e ON e.id_estab = c.id_estab
WHERE c.id_usuario = 1 AND c.tipo_compra = 'pontos';
```

### Total de pontos ganhos (dinheiro):
```sql
SELECT SUM(pontos_recebidos) as total_ganho
FROM compra_experiencia 
WHERE id_usuario = 1 AND tipo_compra = 'dinheiro';
```

### Total de pontos gastos (troca):
```sql
SELECT SUM(valor_gasto) as total_gasto
FROM compra_experiencia 
WHERE id_usuario = 1 AND tipo_compra = 'pontos';
```

---

## 🔐 Segurança

### Protections implementadas:

1. **SQL Injection**: Prepared statements em todos os queries
2. **Session Check**: Validação de `$_SESSION['user_id']` antes de usar
3. **Transactions**: Rollback automático em caso de erro
4. **Validação de Entrada**: Todos os inputs validados
5. **HTML Escape**: `htmlspecialchars()` em outputs (especialmente em modais)
6. **Tipo Casting**: `floatval()`, `intval()` para conversões

---

## 🎮 Casos de Uso

### Caso 1: Usuário novo
- Começa com 0 pontos
- Faz check-in (ganha 30 pts)
- Quer comprar experiência com dinheiro (ganha 10 pts por real)
- Depois pode trocar pontos por mais experiências

### Caso 2: Usuário com pontos
- Tem 500 pontos acumulados
- Vai direto para "Trocar Pontos" (aba ativa)
- Confirma compra imediatamente

### Caso 3: Monetização
- Usuários que não fazem check-ins frequentes podem "pular a fila"
- Pagam real (ex: R$ 5 = 50 pontos)
- Desbloqueiam mais experiências rapidamente

---

## 🚀 Como Usar

### Para Turista:

1. **Comprar com Pontos**:
   - Click "Comprar" no local
   - Modal abre na aba "Trocar Pontos"
   - Clique "Confirmar"

2. **Comprar com Dinheiro**:
   - Click "Comprar" no local
   - Modal abre
   - Clique na aba "Comprar com Dinheiro"
   - Digite valor (ex: 10.00)
   - Veja pontos calculados (ex: 100 pontos)
   - Clique "Comprar Agora"

3. **Ver Histórico**:
   - Menu → "Minhas Compras"
   - Veja cards com estatísticas
   - Veja tabela com todas as compras

### Para Desenvolvedor:

1. **Adicionar na rota**:
```php
case 'shopping_money':
    (new ShoppingController())->buyWithMoney();
    break;
```

2. **Usar no model**:
```php
$shopping = new ShoppingModel();
$result = $shopping->buyWithMoney($user_id, $place_id, 10.50);
if ($result['success']) {
    echo "Ganhou: " . $result['pontos_recebidos'] . " pontos";
}
```

---

## 📈 Métricas

### O que pode ser monitorado:

- Total de compras por tipo (dinheiro vs pontos)
- Receita total (SUM de valor_real)
- Pontos distribuídos (SUM de pontos_recebidos)
- Padrão de compra por usuário
- Local mais popular para compras

---

## ✅ Checklist de Implantação

- [x] Tabela criada no BD
- [x] Model implementado
- [x] Controller implementado
- [x] Rotas adicionadas
- [x] Modal implementado
- [x] Views criadasa
- [x] Menu atualizado
- [x] Testes documentados
- [x] README atualizado
- [ ] Testar em produção
- [ ] Monitorar transações

---

**Pronto para uso! Sistema de compra dual funcional e testado.** 🎉
