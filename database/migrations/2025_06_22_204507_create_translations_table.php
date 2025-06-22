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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_key_id')->constrained()->onDelete('cascade');
            $table->foreignId('locale_id')->constrained()->onDelete('cascade');
            $table->text('value');
            $table->timestamps();

            $table->unique(['translation_key_id', 'locale_id'], 'translations_key_locale_unique');
            $table->index(['locale_id', 'updated_at']);
            $table->index(['translation_key_id', 'updated_at']);
            $table->softDeletes();
            $table->index(['key', 'tag', 'context']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
