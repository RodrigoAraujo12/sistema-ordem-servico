<!-- Instruções de Desenvolvimento para o Sistema de Ordens de Serviço -->

# Sistema de Ordens de Serviço - Instruções de Uso

## 🚀 Como Executar

### 1. Instalação de Dependências
```bash
composer install
```

### 2. Configurar o Arquivo .env
```bash
cp .env.example .env
php artisan key:generate
```

Edite o `.env` com suas credenciais PostgreSQL.

### 3. Criar Banco de Dados PostgreSQL
```bash
createdb ordem_servico -U postgres
```

### 4. Executar Migrations
```bash
php artisan migrate
```

### 5. Executar Seeders
```bash
php artisan db:seed
```

### 6. Iniciar o Servidor
```bash
php artisan serve
```

Acesse em: `http://localhost:8000`

## 👤 Dados de Teste

| Email | Senha | Role |
|-------|-------|------|
| admin@example.com | password | Admin |
| tecnico1@example.com | password | Técnico |
| tecnico2@example.com | password | Técnico |

## 📋 Funcionalidades Implementadas

✅ Dashboard de Ordens de Serviço
✅ Criar Nova Ordem (com número automático)
✅ Editar Ordem Existente
✅ Visualizar Detalhes da Ordem
✅ Filtrar por Status
✅ Buscar por Número ou Cliente
✅ Gerar PDF da Ordem
✅ Autenticação com Roles
✅ Gerenciamento de Clientes
✅ Validação de Formulários
✅ Interface Responsiva com Tailwind CSS
✅ Componentes Livewire Interativos

## 🔧 Principais Componentes

### Models
- `User` - Usuários do sistema com roles
- `Cliente` - Dados dos clientes
- `OrdemServico` - Ordens de serviço técnico

### Livewire Components
- `ListarOrdensServico` - Listagem com filtros
- `CriarOrdemServico` - Criar nova ordem
- `EditarOrdemServico` - Editar ordem

### Controllers
- `OrdemServicoController` - Gerenciar ordens
- `PDFController` - Gerar e visualizar PDFs

## 📝 Status Disponíveis

- Em análise
- Aguardando peça
- Em reparo
- Concluído
- Entregue
- Cancelado

## 🎨 Customizações Possíveis

1. **Cores e Layout**: Edite o Tailwind CSS nas views
2. **Campos Adicionais**: Adicione campos nas migrations e models
3. **Roles Adicionais**: Estenda o sistema com mais permissões
4. **Email Notifications**: Configure notificações por email
5. **Relatórios**: Crie novas rotas para gerar relatórios

## 🐛 Troubleshooting

### Erro de conexão PostgreSQL
```bash
# Verifique se PostgreSQL está rodando
psql -U postgres
```

### Limpar cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Resetar banco de dados
```bash
php artisan migrate:refresh --seed
```

## 📦 Dependências Principais

- Laravel 11
- Livewire 3
- Tailwind CSS
- Barryvdh DomPDF
- PostgreSQL
