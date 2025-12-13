#!/bin/bash

echo "🚀 Setup do Sistema de Ordens de Serviço"
echo "========================================"

# Verificar se composer existe
if ! command -v composer &> /dev/null; then
    echo "❌ Composer não está instalado. Por favor instale o Composer."
    exit 1
fi

# Verificar se PHP existe
if ! command -v php &> /dev/null; then
    echo "❌ PHP não está instalado. Por favor instale PHP 8.2+"
    exit 1
fi

echo "📦 Instalando dependências..."
composer install

echo "🔑 Gerando chave da aplicação..."
if [ ! -f .env ]; then
    cp .env.example .env
fi
php artisan key:generate

echo "⚙️  Configurando banco de dados..."
echo "Por favor, configure as credenciais do PostgreSQL no arquivo .env"
read -p "Pressione ENTER para continuar..."

echo "🔄 Executando migrations..."
php artisan migrate

echo "🌱 Executando seeders..."
php artisan db:seed

echo ""
echo "✅ Setup concluído!"
echo ""
echo "Para iniciar o servidor, execute:"
echo "  php artisan serve"
echo ""
echo "Acesse: http://localhost:8000"
echo ""
echo "Dados de teste:"
echo "  Email: admin@example.com"
echo "  Senha: password"
