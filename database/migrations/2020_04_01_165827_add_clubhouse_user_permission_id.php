<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClubhouseUserPermissionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redmine_clubhouse_users', function (Blueprint $table) {
            $table->string('clubhouse_user_permissions_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redmine_clubhouse_users', function (Blueprint $table) {
            $table->dropColumn('clubhouse_user_permissions_id');
        });
    }
}
