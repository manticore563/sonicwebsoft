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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('company')->nullable()->after('last_name');
            $table->string('state')->nullable()->after('country_code');
            $table->string('city')->nullable()->after('state');
            $table->string('phone')->nullable()->after('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('company');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('phone');
        });
    }
};
