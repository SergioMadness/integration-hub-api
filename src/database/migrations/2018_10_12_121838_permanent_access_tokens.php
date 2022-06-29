<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermanentAccessTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('permanent_access_tokens', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('application_id');
            $table->timestamp('since');
            $table->timestamp('till');

            $table->foreign(['application_id'])
                ->on('applications')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('permanent_access_tokens');
    }
}
