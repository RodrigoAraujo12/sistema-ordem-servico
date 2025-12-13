# Sistema de Ordens de Serviço para Assistência Técnica

Um sistema completo para gerenciar ordens de serviço técnico, desenvolvido com **Laravel 11**, **Livewire**, **Blade**, **Tailwind CSS** e **PostgreSQL**.

## 🚀 Funcionalidades

- ✅ **Gestão de Clientes** - Cadastro e gerenciamento de clientes
- ✅ **Ordens de Serviço** - Criação, edição e visualização de ordens
- ✅ **Rastreamento de Status** - Em análise, Aguardando peça, Em reparo, Concluído, Entregue
- ✅ **Valores e Orçamentos** - Controle de orçamento e valor aprovado
- ✅ **Geração de PDF** - PDFs formatados das ordens de serviço para entregar ao cliente
- ✅ **Autenticação** - Sistema de login com roles (Admin e Técnico)
- ✅ **Dashboard Responsivo** - Interface com Tailwind CSS
- ✅ **Componentes Livewire** - Interatividade sem recarregar a página

## 📋 Stack

- **Backend**: Laravel 11
- **Frontend**: Blade + Livewire 3 + Tailwind CSS
- **Database**: PostgreSQL
- **PDF**: Barryvdh DomPDF
- **Autenticação**: Laravel Breeze

## 🛠️ Instalação e Configuração

### Pré-requisitos

- PHP 8.2+
- Composer
- PostgreSQL 12+
- Node.js (para Tailwind CSS)

### Passos

1. **Clone o repositório**
   ```bash
   cd "Sistema de Ordens de Serviço para Assistência Técnica"
   ```

2. **Instale as dependências PHP**
   ```bash
   composer install
   ```

3. **Configure o arquivo .env**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Edite o `.env` e configure as credenciais do PostgreSQL:
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=ordem_servico
   DB_USERNAME=postgres
   DB_PASSWORD=sua_senha
   ```

4. **Crie o banco de dados PostgreSQL**
   ```bash
   createdb ordem_servico -U postgres
   ```

5. **Execute as migrations**
   ```bash
   php artisan migrate
   ```

6. **Execute os seeders (dados de teste)**
   ```bash
   php artisan db:seed
   ```

7. **Inicie o servidor**
   ```bash
   php artisan serve
   ```

8. **Acesse a aplicação**
   ```
   http://localhost:8000
   ```

## 👤 Dados de Teste

Após executar os seeders, use as seguintes credenciais:

### Admin
- **Email**: admin@example.com
- **Senha**: password
- **Permissões**: Acesso total ao sistema

### Técnico
- **Email**: tecnico1@example.com
- **Senha**: password
- **Email**: tecnico2@example.com
- **Senha**: password

## 📁 Estrutura do Projeto

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── livewire/
│       ├── ordensservico/
│       ├── pdf/
│       └── auth/
├── routes/
└── config/
```

## 🔐 Funcionalidades de Segurança

- Autenticação com email e senha
- Middleware de autenticação nas rotas protegidas
- Proteção CSRF (Cross-Site Request Forgery)
- Hash de senhas com Bcrypt

## 📝 Campos da Ordem de Serviço

- **Número da Ordem**: Gerado automaticamente (OS-YYYYMMDD0001)
- **Cliente**: Selecionado do banco de clientes
- **Aparelho**: Tipo de equipamento (Notebook, Desktop, Impressora, etc.)
- **Defeito Relatado**: Descrição detalhada do problema
- **Status**: Em análise, Aguardando peça, Em reparo, Concluído, Entregue, Cancelado
- **Orçamento**: Valor inicial estimado
- **Valor Aprovado**: Valor aprovado pelo cliente
- **Data de Entrada**: Data em que a ordem foi criada
- **Data de Conclusão**: Data em que o serviço foi concluído
- **Técnico Responsável**: Técnico atribuído ao serviço
- **Observações**: Notas adicionais sobre o serviço

## 📊 Funcionalidades do Livewire

### ListarOrdensServico
- Listagem paginada de ordens
- Busca por número da ordem ou nome do cliente
- Filtro por status
- Links para visualizar, editar e gerar PDF

### CriarOrdemServico
- Formulário reativo para criar novas ordens
- Validação em tempo real
- Geração automática de número de ordem

### EditarOrdemServico
- Formulário para editar ordens existentes
- Seleção de técnico responsável
- Atualização de status

## 📄 Geração de PDF

O sistema gera PDFs profissionais das ordens de serviço com:
- Informações do cliente
- Detalhes do equipamento
- Defeito relatado
- Orçamento e valor aprovado
- Status atual
- Observações
- Data e hora de geração

## 🔧 Troubleshooting

### Erro de conexão com PostgreSQL
Verifique se:
- PostgreSQL está rodando
- As credenciais no `.env` estão corretas
- O banco de dados foi criado
- O usuário tem permissão para acessar o banco

### Erro ao gerar PDF
- Verifique se a biblioteca WKHTMLTOPDF está instalada
- Ou use a biblioteca padrão DomPDF que já vem configurada

### Port 8000 já está em uso
```bash
php artisan serve --port=8080
```

## 📚 Documentação Adicional

- [Laravel Docs](https://laravel.com/docs)
- [Livewire Docs](https://livewire.laravel.com)
- [Tailwind CSS Docs](https://tailwindcss.com)
- [DomPDF Docs](https://github.com/barryvdh/laravel-dompdf)

## 📝 Licença

MIT

## 👨‍💻 Autor

Sistema desenvolvido para gerenciar ordens de serviço técnico com interface moderna e responsiva.

---

**Desenvolvido com ❤️ usando Laravel e Livewire**
