<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdemHistorico extends Model
{
    use HasFactory;

    protected $table = 'ordem_historico';

    protected $fillable = [
        'ordem_servico_id',
        'user_id',
        'campo_alterado',
        'valor_anterior',
        'valor_novo',
        'descricao',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function ordem(): BelongsTo
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
