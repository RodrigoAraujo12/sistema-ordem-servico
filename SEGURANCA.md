# Guia de Segurança - Sistema de Ordens de Serviço

## 🔒 Medidas de Segurança Implementadas

### 1. **Proteção CSRF (Cross-Site Request Forgery)**
✅ **Status:** Implementado automaticamente pelo Laravel
- Todos os formulários incluem `@csrf`
- Token validado em todas requisições POST/PUT/DELETE
- Previne ataques de requisições forjadas

**Como funciona:**
```blade
<form method="POST">
    @csrf  <!-- Token de segurança -->
</form>
```

---

### 2. **Rate Limiting (Limitação de Taxa)**
✅ **Status:** Implementado
- **Login:** Máximo 5 tentativas por minuto
- **APIs:** Limitação padrão Laravel (60 req/min)

**Protege contra:**
- Brute force attacks
- DDoS básico
- Spam de formulários

**Configuração:** `routes/web.php`
```php
->middleware('throttle:5,1') // 5 tentativas, 1 minuto
```

---

### 3. **SQL Injection Protection**
✅ **Status:** Implementado (Eloquent ORM)
- Queries parametrizadas automaticamente
- Validações em todos inputs
- Uso de `whereNumber()` em rotas

**Exemplo seguro:**
```php
// ✅ Seguro - Eloquent escapa automaticamente
OrdemServico::where('status', $status)->get();

// ❌ Inseguro - NUNCA usar
DB::raw("SELECT * WHERE status = '$status'");
```

---

### 4. **XSS Protection (Cross-Site Scripting)**
✅ **Status:** Implementado
- Blade escapa output automaticamente: `{{ $variavel }}`
- Header `X-XSS-Protection` habilitado
- Content Security Policy configurada

**Como Blade protege:**
```blade
{{ $cliente->nome }}  <!-- ✅ Escapado -->
{!! $html !!}         <!-- ⚠️ Não escapado - usar com cuidado -->
```

---

### 5. **Headers de Segurança HTTP**
✅ **Status:** Implementado em `SecurityHeaders` middleware

| Header | Função | Proteção |
|--------|--------|----------|
| `X-Frame-Options` | SAMEORIGIN | Clickjacking |
| `X-Content-Type-Options` | nosniff | MIME sniffing |
| `X-XSS-Protection` | 1; mode=block | XSS no navegador |
| `Content-Security-Policy` | Restringe recursos | Injeção de scripts |
| `Referrer-Policy` | strict-origin | Vazamento de info |
| `Permissions-Policy` | Desabilita APIs | Acesso câmera/mic |

---

### 6. **Autenticação e Sessões**
✅ **Status:** Implementado
- **Session Regeneration:** ID regenerado no login/logout
- **Session Invalidation:** Sessão invalidada no logout
- **CSRF Token Rotation:** Token regenerado após logout
- **Remember Token:** Hash seguro para "lembrar-me"

**Código aplicado:**
```php
// Login
request()->session()->regenerate();

// Logout
request()->session()->invalidate();
request()->session()->regenerateToken();
```

---

### 7. **Logs de Auditoria**
✅ **Status:** Implementado
- Login bem-sucedido (user_id, email, IP)
- Tentativas de login falhadas (email, IP)
- Logout (user_id, IP)
- Mudanças em ordens (histórico completo)

**Localização:** `storage/logs/laravel.log`

**Exemplo de log:**
```
[2025-12-08] Login bem-sucedido: user_id=1, email=admin@example.com, ip=127.0.0.1
[2025-12-08] Tentativa de login falhou: email=hacker@test.com, ip=192.168.1.100
```

---

### 8. **Validação de Inputs**
✅ **Status:** Implementado
- Validações server-side em todos formulários
- Sanitização de emails (`filter_var`)
- Tipos de dados forçados (`whereNumber`)
- Limites de tamanho (`max:100`)

**Exemplo:**
```php
$validated = request()->validate([
    'email' => 'required|email',
    'cpf' => 'required|string|max:20',
    'valor' => 'required|numeric|min:0',
]);
```

---

### 9. **Controle de Acesso (RBAC)**
✅ **Status:** Implementado
- Middleware `auth` (autenticação)
- Middleware `admin` (autorização)
- Verificações no controller (técnico só vê suas ordens)
- Verificações na view (botões condicionais)
- **Token público para clientes** (acesso sem login)

**Níveis de acesso:**
- **Cliente (via token):** Ver apenas sua ordem (sem login)
- **Técnico:** Ver/editar suas ordens (com login)
- **Admin:** Acesso total (com login)

---

### 9.1 **Token de Acesso Público**
✅ **Status:** Implementado
- Cada ordem possui token único (64 caracteres hex)
- Token válido por 30 dias
- Link público: `https://site.com/ordem/{token}`
- Cliente acessa sem necessidade de cadastro/login
- Somente leitura (não pode editar)
- Logs de acesso registrados
- Token não pode ser reutilizado em outras ordens

**Benefícios:**
- ✅ Cliente não precisa criar conta
- ✅ Acesso seguro e rastreável
- ✅ Expira automaticamente
- ✅ Previne acesso não autorizado a outras ordens

**Geração de token:**
```php
$ordem->generatePublicToken(); // Gera e salva automaticamente
```

---

### 10. **Proteção de Arquivos Sensíveis**
✅ **Status:** Laravel padrão
- `.env` nunca versionado (`.gitignore`)
- `storage/` e `database/` protegidos
- Chave `APP_KEY` única e secreta

---

## 🔧 Configurações para Produção

### No arquivo `.env`:

```env
# PRODUÇÃO - Desabilitar debug
APP_ENV=production
APP_DEBUG=false

# Session segura (HTTPS)
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Forçar HTTPS
APP_URL=https://seudominio.com
```

---

## ✅ Checklist de Segurança

Antes do deploy, confirme:

- [ ] `APP_DEBUG=false` em produção
- [ ] `APP_KEY` gerado e único
- [ ] `.env` não commitado no Git
- [ ] HTTPS habilitado (SSL/TLS)
- [ ] Senhas fortes no banco de dados
- [ ] Backups configurados
- [ ] Logs monitorados
- [ ] Rate limiting testado
- [ ] Permissões de arquivo corretas (755 diretórios, 644 arquivos)

---

## 🚀 Próximos Passos (Opcional)

Para segurança avançada:

1. **Two-Factor Authentication (2FA)**
2. **Password complexity requirements**
3. **Captcha no login** (após 3 tentativas)
4. **IP whitelist para admin**
5. **Audit logs completos** (tabela dedicada)
6. **Encryption at rest** (dados sensíveis)
7. **WAF (Web Application Firewall)**
8. **Penetration testing**

---

## 📚 Referências

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [Content Security Policy](https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP)

---

**Sistema protegido contra as vulnerabilidades mais comuns (OWASP Top 10):**
✅ Injection  
✅ Broken Authentication  
✅ XSS  
✅ CSRF  
✅ Security Misconfiguration  
✅ Sensitive Data Exposure  
✅ Broken Access Control
