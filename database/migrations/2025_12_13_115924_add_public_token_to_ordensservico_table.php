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
            $table->string('public_token', 64)->unique()->nullable()->after('numero_ordem');
            $table->timestamp('token_expires_at')->nullable()->after('public_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordensservico', function (Blueprint $table) {
            $table->dropColumn(['public_token', 'token_expires_at']);
        });
    }
};
