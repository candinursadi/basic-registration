<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender', 10)->nullable();
            $table->string('hobby', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('username', 10)->unique();
            $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('hobby');
            $table->dropColumn('phone');
            $table->dropColumn('username');
            $table->softDeletes();
        });
    }
};
