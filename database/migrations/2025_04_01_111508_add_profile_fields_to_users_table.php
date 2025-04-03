<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable();
            $table->string('full_name')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->text('description')->nullable();
            $table->string('profile_picture')->nullable(); // stores the file path
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nickname', 'full_name', 'address', 'occupation', 'description', 'profile_picture']);
        });
    }
}
