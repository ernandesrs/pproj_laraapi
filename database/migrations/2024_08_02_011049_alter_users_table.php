<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn(['name']);

            $table->string('first_name', 25)->fulltext('first_name_fulltext');
            $table->string('last_name', 50)->fulltext('last_name_fulltext');
            $table->string('username', 25)->fulltext('username_fulltext')->unique();
            $table->string('gender', 1)->default('n');
            $table->string('verification_token', 25)->nullable();
            $table->string('avatar')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('name');
            $table->dropFullText(['first_name', 'last_name', 'username']);
            $table->dropColumn(['first_name', 'last_name', 'username', 'gender', 'verification_token', 'avatar']);

        });
    }
};
