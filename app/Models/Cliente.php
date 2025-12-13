<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'endereco',
    ];

    public function ordensServico(): HasMany
    {
        return $this->hasMany(OrdemServico::class);
    }
}
