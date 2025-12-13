<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdemServico extends Model
{
    use HasFactory;

    protected $table = 'ordensservico';

    protected $fillable = [
        'cliente_id',
        'numero_ordem',
        'public_token',
        'token_expires_at',
        'aparelho',
        'defeito_relatado',
        'status',
        'orcamento',
        'valor_aprovado',
        'data_entrada',
        'data_saida',
        'observacoes',
        'tecnico_id',
    ];

    protected $casts = [
        'data_entrada' => 'date',
        'data_saida' => 'date',
        'token_expires_at' => 'datetime',
        'orcamento' => 'decimal:2',
        'valor_aprovado' => 'decimal:2',
    ];

    public const STATUS = [
        'analise' => 'Em análise',
        'aguardando_peca' => 'Aguardando peça',
        'em_reparo' => 'Em reparo',
        'concluido' => 'Concluído',
        'entregue' => 'Entregue',
        'cancelado' => 'Cancelado',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class, 'ordem_servico_id');
    }

    public function historico(): HasMany
    {
        return $this->hasMany(OrdemHistorico::class, 'ordem_servico_id');
    }

    public function getTotalPagoAttribute(): float
    {
        return (float) ($this->pagamentos()->sum('valor') ?? 0);
    }

    public function getSaldoReceberAttribute(): float
    {
        $aprovado = (float) ($this->valor_aprovado ?? 0);
        return max(0, $aprovado - $this->total_pago);
    }

    public function getStatusFormatadoAttribute(): string
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    /**
     * Gerar token público único para acesso do cliente
     */
    public function generatePublicToken(): string
    {
        $this->public_token = bin2hex(random_bytes(32)); // 64 caracteres
        $this->token_expires_at = now()->addDays(30); // Token válido por 30 dias
        $this->save();
        
        return $this->public_token;
    }

    /**
     * Verificar se o token ainda é válido
     */
    public function isTokenValid(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isFuture();
    }
}
