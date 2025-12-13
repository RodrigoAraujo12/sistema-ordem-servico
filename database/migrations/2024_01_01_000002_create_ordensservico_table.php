<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordensservico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero_ordem')->unique();
            $table->string('aparelho');
            $table->text('defeito_relatado');
            $table->enum('status', ['analise', 'aguardando_peca', 'em_reparo', 'concluido', 'entregue', 'cancelado'])->default('analise');
            $table->decimal('orcamento', 10, 2)->nullable();
            $table->decimal('valor_aprovado', 10, 2)->nullable();
            $table->date('data_entrada');
            $table->date('data_conclusao')->nullable();
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('cliente_id');
            $table->index('tecnico_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordensservico');
    }
};
