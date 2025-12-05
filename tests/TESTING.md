# Guia de Teste - Sistema de Compra de Experiências

## Pré-requisitos

- Banco de dados `traveltrack` criado e preenchido com dados de exemplo
- XAMPP rodando com Apache e MySQL
- Acesso a `http://localhost/TravelTrack/`

---

## Teste 1: Verificar Remoção de QR Code

### Passos:
1. Abra `http://localhost/TravelTrack/`
2. Faça login com `joao@gmail.com` / `123`
3. **Verificação**: 
   - ❌ O menu NÃO deve ter link "QR"
   - ❌ O dashboard NÃO deve ter botão "Escanear QR Code"
   - ✅ Menu tem: Locais, Recompensas, Histórico, **Experiências** (novo), Admin, Perfil, Sair

---

## Teste 2: Visualizar Botão de Compra no Dashboard

### Passos:
1. No dashboard (página inicial logado)
2. Procure pelos cartões de "Locais próximos"
3. **Verificação**:
   - ✅ Cada local tem 2 botões: "Ver Detalhes" (verde) e "Comprar" (azul)
   - ✅ Badge com número de pontos: ex. "30 pts"
   - ✅ Clique em "Ver Detalhes" leva para o detalhe do local
   - ✅ Clique em "Comprar" desconcentra (deve fazer a compra e voltar com mensagem)

---

## Teste 3: Comprar uma Experiência com Pontos Suficientes

### Passos:
1. No dashboard, abra o navegador e veja os pontos do usuário (canto superior direito: "Pts 150")
2. Clique no botão "Comprar" de um local que custe MENOS pontos que o usuário possui
   - Ex: "Parque das Nações Indígenas" (30 pts) - o usuário (João) tem 150 pts
3. **Verificação**:
   - ✅ Página recarrega com mensagem em verde: "Experiência adquirida com sucesso! Pontos restantes: 120"
   - ✅ Pontos diminuem (de 150 → 120)
   - ✅ Compra fica registrada

---

## Teste 4: Tentar Comprar sem Pontos Suficientes

### Passos:
1. Abra um local que custe muitos pontos (ex: Buraco das Araras = 50 pts)
2. Faça 3 compras desse local até seus pontos chegarem perto de 0
   - Ex: João começa com 150, compra 1x (120), compra 2x (90), compra 3x (60)
3. Agora tente comprar um local que custe mais que o restante
4. **Verificação**:
   - ✅ Mensagem de erro em vermelho: "Pontos insuficientes para esta compra"
   - ✅ Pontos NÃO mudam
   - ✅ Compra não é registrada

---

## Teste 5: Verificar Histórico de Experiências Adquiridas

### Passos:
1. Faça pelo menos 2 compras em locais diferentes
2. Clique em "Experiências" no menu (novo link adicionado)
3. **Verificação**:
   - ✅ Página exibe lista de experiências adquiridas
   - ✅ Cada item mostra:
     - Nome do local
     - Data e hora da compra
     - Pontos gastos em vermelho (ex: "-30 pts")
   - ✅ Saldo de pontos aparece no canto superior direito
   - ✅ Se nenhuma compra foi feita, mensagem: "Você ainda não adquiriu nenhuma experiência com seus pontos."

---

## Teste 6: Comprar a partir da Página de Locais

### Passos:
1. Clique em "Locais" no menu
2. Veja a lista completa de locais turísticos
3. **Verificação**:
   - ✅ Cada local tem 2 botões: "Ver Detalhes" e "Comprar"
   - ✅ Funcionalidade é igual ao dashboard
   - ✅ Clique em "Comprar" funciona normalmente

---

## Teste 7: Fluxo de Usuário Deslogado

### Passos:
1. Clique em "Sair" para fazer logout
2. Volte para o dashboard (a página redireciona para o login)
3. Abra a página de locais sem logar
4. **Verificação**:
   - ✅ Botão "Ver Detalhes" funciona normalmente (apenas mostra info)
   - ✅ Botão "Comprar" redireciona para login: `index.php?page=login`
   - ✅ Link diz "Comprar" em vez de form POST

---

## Teste 8: Verificar Dados no Banco (Avançado)

### Passos via phpMyAdmin:
1. Abra `http://localhost/phpmyadmin`
2. Vá para banco `traveltrack`, tabela `usuario`
3. Verifique o usuário (ex: João, id 1)
4. **Verificação**:
   - ✅ Campo `pontos_totais` diminui após cada compra
   - Exemplo: Se fez 2 compras de 30 pts cada, diminui 60 pts

5. Vá para tabela `checkin`
6. **Verificação**:
   - ✅ Novas linhas com `pontos_gerados` NEGATIVO (ex: -30, -50)
   - ✅ Estas linhas indicam gastos de pontos (compras)
   - ✅ Campo `data_checkin` mostra quando a compra foi feita

---

## Teste 9: Validar Exceções e Erros

### Passos:
1. Edite o `config/database.php` e altere a senha para algo errado
2. Tente acessar um local ou fazer uma compra
3. **Verificação**:
   - ✅ Mensagem de erro amigável (não PHP white-screen-of-death)
   - Restaure a senha correta

4. Apague um usuário da tabela `usuario` via phpMyAdmin
5. Tente fazer login com esse usuário
6. **Verificação**:
   - ✅ Página de login ainda funciona
   - ✅ Erro de login é capturado

---

## Resumo das Funcionalidades Testadas

| Feature | Status | Testado |
|---------|--------|---------|
| QR Code removido | ✅ Removido | ❓ |
| Botão "Comprar" no dashboard | ✅ Adicionado | ❓ |
| Botão "Comprar" em locais | ✅ Adicionado | ❓ |
| Desconto de pontos | ✅ Implementado | ❓ |
| Validação de pontos suficientes | ✅ Implementado | ❓ |
| Histórico de compras | ✅ Implementado | ❓ |
| Menu "Experiências" | ✅ Adicionado | ❓ |
| Tratamento de exceções | ✅ Melhorado | ❓ |

---

## Comandos Rápidos

### Resetar pontos de um usuário (via phpMyAdmin SQL):
```sql
UPDATE usuario SET pontos_totais = 150 WHERE id_usuario = 1;
```

### Ver histórico de compras de um usuário:
```sql
SELECT * FROM checkin WHERE id_usuario = 1 AND pontos_gerados < 0;
```

### Limpar histórico de compras (cuidado!):
```sql
DELETE FROM checkin WHERE id_usuario = 1 AND pontos_gerados < 0;
```

---

**Fim do Guia de Teste**
