<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ordensservico', function (Blueprint $table) {
            $table->dateTime('data_saida')->nullable()->after('data_entrada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordensservico', function (Blueprint $table) {
            $table->dropColumn('data_saida');
        });
    }
};
