<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**.0
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fundsource', function (Blueprint $table) {
            //
            $table->string('created_by', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fundsource', function (Blueprint $table) {
            //
        });
    }
};

