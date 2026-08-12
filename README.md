# 🍳 Recipe API

API REST para gerenciamento de receitas, incluindo autenticação, reações de usuários e visualizações.

## 📋 Sobre o Projeto

Recipe API é uma aplicação backend desenvolvida em Laravel que fornece endpoints para:
- Autenticação de usuários com Sanctum
- CRUD completo de receitas
- Sistema de reações em receitas
- Controle de visualizações
- Upload de imagens para receitas
- Envio de e-mails (digest semanal e receitas em destaque)

## 🔗 Links

- **Documentação**: [Postman Collection](./recipe-api.postman-collection.json) 

## 💻 Requisitos

- PHP 8.3+
- Composer
- Docker & Docker Compose (para usar Laravel Sail)
- MySQL 8.4+

## 🚀 Setup Local

### 1. Clonar o repositório

```bash
git clone https://github.com/anacnogueira/recipe-api.git
cd recipe-api
```

### 2. Instalar dependências

```bash
composer install
```

### 3. Configurar variáveis de ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

### 4. Com Laravel Sail (Docker)

Se preferir usar Docker para um ambiente isolado:

```bash
# Inicie os containers
./vendor/bin/sail up -d

# Execute as migrations
./vendor/bin/sail artisan migrate

# Popule o banco com dados de teste
./vendor/bin/sail artisan db:seed
```

### 5. Sem Docker (Configuração Manual)

Configure o banco de dados no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recipe_api
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Depois execute:

```bash
# Gerar chave da aplicação
php artisan key:generate

# Executar migrations
php artisan migrate
```

## 🔑 Variáveis de Ambiente

### Configurações Gerais

| Variável | Padrão | Descrição |
|----------|--------|-----------|
| `APP_NAME` | Recipe API | Nome da aplicação |
| `APP_ENV` | local | Ambiente (local, staging, production) |
| `APP_DEBUG` | true | Modo debug |
| `APP_URL` | http://localhost | URL base da aplicação |
| `APP_KEY` | - | Chave de criptografia (gerar com `artisan key:generate`) |

### Banco de Dados

| Variável | Descrição |
|----------|-----------|
| `DB_CONNECTION` | Driver (mysql, sqlite, postgres) |
| `DB_HOST` | Host do banco (127.0.0.1 para local) |
| `DB_PORT` | Porta do banco (3306 para MySQL) |
| `DB_DATABASE` | Nome do banco de dados |
| `DB_USERNAME` | Usuário do banco |
| `DB_PASSWORD` | Senha do banco |

### Laravel Sail (Docker)

| Variável | Padrão | Descrição |
|----------|--------|-----------|
| `APP_PORT` | 80 | Porta HTTP da aplicação |
| `VITE_PORT` | 5173 | Porta do dev server Vite |
| `FORWARD_DB_PORT` | 3306 | Porta forwarding do MySQL |
| `WWWUSER` | 1000 | UID do usuário www |
| `WWWGROUP` | 1000 | GID do grupo www |

### Email

| Variável | Padrão | Descrição |
|----------|--------|-----------|
| `MAIL_MAILER` | log | Driver de e-mail (log, smtp, mailgun, etc) |
| `MAIL_FROM_ADDRESS` | hello@example.com | E-mail remetente |
| `MAIL_FROM_NAME` | Example | Nome do remetente |

### Cache, Sessão e Fila

| Variável | Valor | Descrição |
|----------|-------|-----------|
| `CACHE_STORE` | database | Driver de cache |
| `SESSION_DRIVER` | database | Driver de sessão |
| `QUEUE_CONNECTION` | database | Driver de fila |

## 📜 Scripts Disponíveis

### Desenvolvimento

```bash
# Instalar tudo de uma vez (compostas, migrations, assets)
composer run setup

# Iniciar servidor com hot reload de assets
composer run dev

# Com Laravel Sail (Docker)
./vendor/bin/sail artisan serve
```

### Migrations e Seeding

```bash
# Executar todas as migrations
php artisan migrate

# Reverter última migration
php artisan migrate:rollback

# Resetar banco de dados (cuidado!)
php artisan migrate:fresh --seed

```

### Testes

```bash
# Rodar todos os testes
composer run test

# Rodar testes de um arquivo específico
php artisan test tests/Feature/ExampleTest.php

# Rodar com cobertura de código
php artisan test --coverage

# Com Laravel Sail
./vendor/bin/sail test
```

### Qualidade de Código

```bash
# Formatar código com Pint
./vendor/bin/pint

# Validar formatação
./vendor/bin/pint --check
```

### Utilitários

```bash
# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Otimizar aplicação
php artisan optimize

# Tinker (shell PHP interativo)
php artisan tinker

# Ver logs em tempo real (Sail)
./vendor/bin/sail pail
```

## 📡 Endpoints da API

Todos os endpoints requerem autenticação (token Bearer) exceto login e registro.

### Autenticação

```
POST /api/register          - Registrar novo usuário
POST /api/login             - Fazer login
POST /api/logout            - Fazer logout
```

### Usuários

```
GET    /api/users           - Listar usuários
GET    /api/users/{id}      - Obter usuário específico
PUT    /api/users/{id}      - Atualizar usuário
DELETE /api/users/{id}      - Deletar usuário
```

### Receitas

```
GET    /api/recipes         - Listar receitas
GET    /api/recipes/{id}    - Obter receita específica
POST   /api/recipes         - Criar nova receita
PUT    /api/recipes/{id}    - Atualizar receita
DELETE /api/recipes/{id}    - Deletar receita
PATCH  /api/recipes/{id}/image     - Upload de imagem
POST   /api/recipes/{id}/react     - Adicionar reação
```

## 🐳 Docker Cheat Sheet

```bash
# Iniciar containers em background
./vendor/bin/sail up -d

# Parar containers
./vendor/bin/sail down

# Ver logs
./vendor/bin/sail logs
./vendor/bin/sail logs -f laravel.test  # Seguir logs em tempo real

# Executar comando dentro do container
./vendor/bin/sail artisan comando:qualquer
./vendor/bin/sail php -v

# Acessar shell do container
./vendor/bin/sail shell

# Banco de dados MySQL
./vendor/bin/sail mysql

# Parar tudo e remover volumes
./vendor/bin/sail down -v
```

## 🔧 Troubleshooting

### Erro: "The Sail container is not running"

```bash
./vendor/bin/sail up -d
```

### Erro: "SQLSTATE[HY000]: General error: 1030 Got error"

Limpe o cache:

```bash
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
```

### Permissões de arquivo (sem Docker)

```bash
chmod -R 775 storage bootstrap/cache
```

### Porta 80/3306 em uso

Modifique no `.env`:

```env
APP_PORT=8000
FORWARD_DB_PORT=3307
```

## 📝 Estrutura de Pastas

```
app/
  ├── Console/          - Comandos artisan customizados
  ├── Http/
  │   ├── Controllers/  - Controllers da API
  │   ├── Requests/     - Form requests (validação)
  │   └── Resources/    - API Resources (transformação de dados)
  ├── Mail/             - Classes de e-mail
  ├── Models/           - Modelos Eloquent
  └── Policies/         - Policies (autorização)
routes/
  └── api.php           - Rotas da API
database/
  ├── migrations/       - Migrações do banco
  ├── factories/        - Factories para testes
  └── seeders/          - Seeders para popular dados
tests/                  - Testes automatizados
config/                 - Configurações da aplicação
```


## 📄 Licença

Este projeto está sob a licença MIT. Ver arquivo [LICENSE](LICENSE).

## 📧 Suporte

Para dúvidas ou issues, abra uma issue no repositório ou entre em contato.

---

**Última atualização**: 2026-08-12
