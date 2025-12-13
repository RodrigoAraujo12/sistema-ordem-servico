# Sistema de Notificações por Email

## Configuração

O sistema está configurado para enviar emails automaticamente quando o status de uma ordem muda.

### Opção 1: Testar com Log (Padrão)
No arquivo `.env`, mantenha:
```env
MAIL_MAILER=log
```
Os emails serão salvos em `storage/logs/laravel.log` para teste.

### Opção 2: Testar com Mailtrap (Recomendado para Desenvolvimento)
1. Crie uma conta gratuita em [Mailtrap.io](https://mailtrap.io)
2. No `.env`, configure:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username_mailtrap
MAIL_PASSWORD=sua_senha_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@assistenciatecnica.com"
MAIL_FROM_NAME="Assistência Técnica"
```

### Opção 3: Gmail (Produção)
1. Ative "Verificação em 2 etapas" na sua conta Google
2. Crie uma "Senha de app" em: https://myaccount.google.com/apppasswords
3. No `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=senha_de_app_gerada
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="seu_email@gmail.com"
MAIL_FROM_NAME="Assistência Técnica"
```

### Opção 4: Outro provedor SMTP
Configure com as credenciais do seu provedor:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.seudominio.com
MAIL_PORT=587
MAIL_USERNAME=contato@seudominio.com
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="contato@seudominio.com"
MAIL_FROM_NAME="Assistência Técnica"
```

## Como Funciona

1. Quando o status de uma ordem é alterado (editando a ordem)
2. O sistema envia automaticamente um email para o cliente
3. O email inclui:
   - Número da ordem
   - Aparelho
   - Status anterior e novo
   - Link para ver detalhes
   - Mensagens especiais para status "Concluído" e "Entregue"

## Testar

1. Configure o `.env` com uma das opções acima
2. Execute: `php artisan config:clear`
3. Execute: `php artisan serve`
4. Edite uma ordem e mude o status
5. Verifique:
   - **Log**: `storage/logs/laravel.log`
   - **Mailtrap**: Inbox no site
   - **Gmail/SMTP**: Caixa de entrada do cliente

## Filas (Opcional - Para Melhor Performance)

Para enviar emails em segundo plano:

1. No `.env`, mude:
```env
QUEUE_CONNECTION=database
```

2. Crie a tabela de jobs:
```bash
php artisan queue:table
php artisan migrate
```

3. Rode o worker:
```bash
php artisan queue:work
```

Agora os emails serão enviados em background sem travar a aplicação.
