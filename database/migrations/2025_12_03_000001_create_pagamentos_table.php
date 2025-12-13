<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordem_servico_id');
            $table->decimal('valor', 10, 2);
            $table->string('metodo', 20); // pix, cartao, dinheiro, boleto
            $table->dateTime('data_pagamento');
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->index(['ordem_servico_id']);
            $table->index(['data_pagamento']);
            $table->foreign('ordem_servico_id')
                ->references('id')->on('ordensservico')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
