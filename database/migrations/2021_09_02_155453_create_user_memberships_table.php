<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_memberships', function (Blueprint $table) {
            $table->id();

            $table->string('membership');
            $table->string('user');            
            $table->string('hashUSDT')->unique();
            $table->string('hashBTC')->unique();          
            $table->string('detail');
            $table->string('status');
            $table->string('image')->nullable();
            $table->date('closedAt');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_memberships');
    }
}
