<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RenameColumnHashBTCToUserMemberships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_memberships', function (Blueprint $table) {
            //$table->renameColumn('hashBTC', 'hashPSIV');
            DB::statement("ALTER TABLE user_memberships CHANGE hashBTC hashPSIV varchar(255)");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_memberships', function (Blueprint $table) {
            //$table->renameColumn('hashPSIV', 'hashBTC');
            DB::statement("ALTER TABLE user_memberships CHANGE hashPSIV hashBTC varchar(255)");
        });
    }
}
