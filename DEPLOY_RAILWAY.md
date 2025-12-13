# 🚀 Deploy no Railway - Variáveis de Ambiente

Configure estas variáveis no Railway Dashboard:

## Obrigatórias
```
APP_NAME="Sistema de Ordens de Serviço"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seu-app.up.railway.app

# Gerar novo: php artisan key:generate --show
APP_KEY=base64:SUA_CHAVE_AQUI

DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite
```

## Opcionais (Email - se usar Mailtrap ou Gmail)
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ordemservico.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Como configurar no Railway:

1. No dashboard do projeto, clique em **Variables**
2. Adicione cada variável acima
3. O Railway reiniciará automaticamente após salvar

## Gerar APP_KEY:
Execute localmente: `php artisan key:generate --show`
Copie o resultado e cole no Railway
