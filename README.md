# TravelTrack 🌍✈️

Um sistema PHP MVC gamificado para turistas registrarem check-ins em locais turísticos, acumularem pontos e trocarem por recompensas. Desenvolvido com foco em sustentabilidade e experiência do usuário.

---

## 📋 Sumário

- [Requisitos](#requisitos)
- [Setup XAMPP + MySQL](#setup-xampp--mysql)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Executar Localmente](#executar-localmente)
- [Funcionalidades](#funcionalidades)
- [Testes](#testes)
- [Estrutura de Pastas](#estrutura-de-pastas)

---

## 📦 Requisitos

- **XAMPP** (Apache + MySQL + PHP 7.4+)
- **PHP 7.4 ou superior**
- **MySQL 5.7 ou superior**
- **Navegador moderno** (Chrome, Firefox, Edge)
- **Google Maps API Key** (para exibir mapas com rotas)

---

## 🚀 Setup XAMPP + MySQL

### 1. Instalar XAMPP

1. Baixe XAMPP de [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Execute o instalador e escolha:
   - ✅ Apache
   - ✅ MySQL
   - ✅ PHP
   - (opcional: phpMyAdmin, Perl)
3. Instale em local padrão (ex: `C:\xampp`)

### 2. Iniciar Apache e MySQL

- Abra **XAMPP Control Panel**
- Clique em **Start** para Apache e MySQL
- Verifique se os serviços ficam **verde** (rodando)

### 3. Verificar Instalação

Abra no navegador:
```
http://localhost/phpmyadmin
```
Você deve ver a interface phpMyAdmin. Se não funcionar, verifique os logs do XAMPP.

---

## 🗄️ Estrutura do Banco de Dados

### Passos para Criar o Banco

#### **Passo 1: Executar Script de Estrutura**

Este script cria o banco e todas as tabelas necessárias.

**Método 1: Via phpMyAdmin**
1. Abra [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Clique em **SQL** (abas no topo)
3. Copie e cole o conteúdo do arquivo:
   ```
   c:\xampp\htdocs\TravelTrack\config\db\estrutura\01-estrutura-inicial.sql
   ```
4. Clique em **Executar** (Execute)

**Método 2: Via Terminal (PowerShell/CMD)**
```powershell
cd C:\xampp\mysql\bin
mysql -u root -p < C:\xampp\htdocs\TravelTrack\config\db\estrutura\01-estrutura-inicial.sql
```
Quando solicitada a senha, pressione **Enter** (senha padrão é vazia).

**Resultado esperado:**
- Banco `traveltrack` criado
- 6 tabelas criadas: `usuario`, `estabelecimento`, `checkin`, `avaliacao`, `recompensa`, `resgate_pontos`

#### **Passo 2: Executar Script de Carga Inicial**

Este script insere dados de exemplo (usuários, locais, check-ins, avaliações, recompensas).

**Método 1: Via phpMyAdmin**
1. No phpMyAdmin, abra a aba **SQL** novamente
2. Copie e cole o conteúdo do arquivo:
   ```
   c:\xampp\htdocs\TravelTrack\config\db\carga\01-carga-inicial.sql
   ```
3. Clique em **Executar**

**Método 2: Via Terminal**
```powershell
mysql -u root traveltrack < C:\xampp\htdocs\TravelTrack\config\db\carga\01-carga-inicial.sql
```

**Resultado esperado:**
- 8 usuários inseridos (João, Maria, Carlos, Ana, Pedro, Juliana, Rafael, Beatriz)
- 4 locais turísticos inseridos (Parque das Nações Indígenas, Rio da Prata, Buraco das Araras, Complexo de Bonito)
- 12 check-ins de exemplo
- 6 avaliações de exemplo
- 4 recompensas (descontos em passagens)
- 6 resgates de pontos de exemplo

#### **Passo 3: Executar Script de Endereços (Coordenadas e Localização)**

Este script atualiza os locais com endereços completos, CEP, latitude e longitude para o mapa.

**Método 1: Via phpMyAdmin**
1. No phpMyAdmin, abra a aba **SQL** novamente
2. Copie e cole o conteúdo do arquivo:
   ```
   c:\xampp\htdocs\TravelTrack\config\db\carga\02-carga-enderecos.sql
   ```
3. Clique em **Executar**

**Método 2: Via Terminal**
```powershell
mysql -u root traveltrack < C:\xampp\htdocs\TravelTrack\config\db\carga\02-carga-enderecos.sql
```

**Resultado esperado:**
- Todos os 4 locais recebem endereços completos (logradouro, número, cidade, UF, CEP)
- Pontos-base ajustados para cada local (20-50 pontos)
- Usuários configurados com roles (ID 1 = ADM, demais = USER)

---

## 🌐 Executar Localmente

### 1. Clonar/Baixar o Projeto

Se o projeto está em `C:\xampp\htdocs\TravelTrack`, pronto!

Se não está, coloque os arquivos lá:
```powershell
# Exemplo: se você tem em outro lugar
cp -r C:\Users\seu_usuario\Downloads\TravelTrack C:\xampp\htdocs\
```

### 2. Acessar no Navegador

Abra seu navegador e vá para:
```
http://localhost/TravelTrack/
```

Você será redirecionado para o dashboard de turistas.

---

## ✨ Funcionalidades

### 👤 Para Turistas

- **Dashboard**: Visualizar locais próximos e ranking semanal de pontos
- **Explorar Locais**: Ver lista completa de pontos turísticos com descrições
- **Detalhes + Mapa**: Ver local selecionado com mapa interativo (Google Maps) e rota até lá
- **Check-in**: Registrar presença em um local e ganhar pontos
- **Avaliações**: Deixar notas e comentários sobre locais visitados
- **🆕 Sistema de Compra Dual**:
  - **Trocar com Pontos**: Use seus pontos acumulados para "comprar" uma experiência
  - **Comprar com Dinheiro**: Pague de verdade e receba 10 pontos por real gasto! 💰
- **Histórico de Compras**: Ver todas as compras (pontos e dinheiro) com detalhes
- **Recompensas**: Visualizar prêmios disponíveis e resgatar com pontos acumulados

### 🛠️ Para Administradores

- **Gerenciar Locais**: Criar, editar, deletar pontos turísticos
- **Gerenciar Recompensas**: Criar e atualizar prêmios
- **Ver Avaliações**: Moderar comentários de usuários
- **Ver Reviews**: Acessar todas as críticas deixadas

### 🗺️ Recursos Técnicos

- **Google Maps Integration**: Exibe rota interativa do usuário até o local
- **Sistema de Pontos Gamificado**: 
  - Check-ins ganham pontos
  - Compras com dinheiro ganham pontos (1 real = 10 pontos)
  - Trocas com pontos existentes
- **Autenticação**: Login seguro com sessão PHP
- **Responsivo**: Interface adaptada para mobile, tablet e desktop (Bootstrap 5)
- **Modal de Compra**: Interface intuitiva com abas para escolher tipo de compra

---

## 🧪 Testes

### Rodar Script de Testes

Para validar que modelos e conexão com BD funcionam:

```powershell do XAMPP
cd C:\xampp\htdocs\TravelTrack
& 'C:\xampp\php\php.exe' tests/run.php
```

**Resultado esperado:**
```
[OK] Conexão com o banco estabelecida
[OK] PlaceModel::all() retornou array (4)
[OK] PlaceModel::find(invalid) retornou false
[OK] UserModel::findById(invalid) retornou false
Teste concluído.
```

Se houver erros, verifique:
1. MySQL está rodando? (XAMPP Control Panel)
2. Banco `traveltrack` foi criado? (phpMyAdmin)
3. Credenciais em `config/database.php` estão corretas? (user=root, password='')

---

## 📁 Estrutura de Pastas

```
TravelTrack/
├── config/
│   ├── autoload.php           # Carregador automático de classes
│   ├── database.php           # Configuração do PDO/MySQL
│   └── db/
│       ├── estrutura/
│       │   └── 01-estrutura-inicial.sql    # Script de criação de tabelas
│       └── carga/
│           ├── 01-carga-inicial.sql        # Dados de exemplo
│           └── 02-carga-enderecos.sql      # Endereços e coordenadas
├── controllers/
│   ├── BaseController.php     # Classe base para views
│   ├── AuthController.php     # Login/Registro
│   ├── PlaceController.php    # Locais turísticos
│   ├── CheckinController.php  # Check-ins
│   ├── RewardController.php   # Recompensas
│   ├── ReviewController.php   # Avaliações
│   ├── AdminController.php    # Painel admin
│   └── ProfileController.php  # Perfil do usuário
├── models/
│   ├── UserModel.php          # Usuários
│   ├── PlaceModel.php         # Locais
│   ├── CheckinModel.php       # Check-ins
│   ├── ReviewModel.php        # Avaliações
│   ├── RewardModel.php        # Recompensas
│   └── BaseModel.php          # Classe base (se usar)
├── views/
│   ├── user/
│   │   ├── dashboard.php      # Página inicial para turistas
│   │   ├── places.php         # Lista de locais
│   │   ├── place.php          # Detalhe + mapa de um local
│   │   ├── rewards.php        # Recompensas disponíveis
│   │   ├── history.php        # Histórico de check-ins
│   │   ├── profile.php        # Editar perfil
│   │   └── login.php          # Login/Register
│   ├── admin/
│   │   ├── panel.php          # Dashboard admin
│   │   ├── places.php         # Gerenciar locais
│   │   ├── rewards.php        # Gerenciar recompensas
│   │   └── reviews.php        # Ver avaliações
│   ├── _shared/
│   │   ├── header.php         # Menu + navbar
│   │   └── footer.php         # Rodapé + scripts
│   └── 404.php                # Página de erro
├── public/
│   ├── styles.css             # CSS customizado
│   ├── app.js                 # JS global (logout, etc)
│   ├── js/
│   │   └── place.js           # Google Maps e mapa do local
│   ├── images/
│   │   └── place-placeholder.jpg
│   └── ...
├── tests/
│   └── run.php                # Script de testes básicos
├── index.php                  # Router principal
└── README.md                  # Este arquivo
```

---

## 🔧 Configurações

### Google Maps API Key

Para que o mapa de rotas funcione, você precisa de uma chave da Google Maps API:

1. Vá para [Google Cloud Console](https://console.cloud.google.com/)
2. Crie um novo projeto
3. Ative a API "Maps JavaScript API"
4. Gere uma chave de API (API Key)
5. **Opção A**: Defina variável de ambiente (Windows):
   ```powershell
   [Environment]::SetEnvironmentVariable("GOOGLE_MAPS_API_KEY", "sua_chave_aqui", "User")
   ```
6. **Opção B**: Edite `config/database.php` e adicione:
   ```php
   define('GOOGLE_MAPS_API_KEY', 'sua_chave_aqui');
   ```
7. Ou defina em `views/_shared/footer.php` (não recomendado em produção):
   ```php
   window.GOOGLE_MAPS_API_KEY = 'sua_chave_aqui';
   ```

### Conexão com Banco

Edite `config/database.php` se precisar alterar host, porta, usuário ou senha:

```php
private $host = "localhost";      // Host do MySQL
private $port = "3306";           // Porta padrão
private $dbName = "traveltrack";  // Nome do banco
private $user = "root";           // Usuário MySQL
private $password = "";           // Senha (vazia por padrão no XAMPP)
```

---

## 🐛 Troubleshooting

### Erro: "Conexão recusada"
- Verifique se MySQL está rodando (XAMPP Control Panel)
- Confirme credenciais em `config/database.php`

### Erro: "Table not found"
- Execute o script `01-estrutura-inicial.sql` via phpMyAdmin
- Verifique se banco `traveltrack` existe

### Mapa não aparece / "Google Maps API key not set"
- Defina a chave da Google Maps API (veja seção Configurações)
- Verifique se a chave tem permissão para Maps JavaScript API

### Página branca ou erro 500
- Verifique logs do Apache: `C:\xampp\apache\logs\error.log`
- Ative debug em `config/autoload.php` ou coloque `ini_set('display_errors', 1);` no `index.php`

### Login não funciona
- Confirme dados em `config/db/carga/01-carga-inicial.sql`
- Verifique se usuários foram inseridos (SELECT * FROM usuario no phpMyAdmin)

---

## 📝 Próximos Passos / Melhorias

- [ ] Integrar pagamento para resgate de recompensas
- [ ] Sistema de notificações (email, push)
- [ ] API REST para mobile app
- [ ] Dashboard de analytics (relatórios de uso)
- [ ] Autenticação OAuth (Google, Facebook)
- [ ] Cache de dados (Redis)
- [ ] Testes unitários (PHPUnit)

---

## 📄 Licença

Este projeto é fornecido como está. Use livremente para fins educacionais.

---

## 👨‍💻 Autor

Desenvolvido como sistema de gamificação turística.

**Contato / Issues:** [seu repositório GitHub]

---

## 🌟 Dicas Finais

- Após primeira execução, explore os dados de teste para entender o fluxo
- Tente criar um novo usuário e fazer check-ins
- Teste o mapa em um local (place.php?id=1) com a chave da Google Maps configurada
- Para ambiente de produção, configure variáveis de ambiente (`.env`) para dados sensíveis
- Faça backup do banco regularmente com `mysqldump`

---

**Pronto para começar? Abra http://localhost/TravelTrack/ 🚀**