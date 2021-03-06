<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->integer('c_permission');
            $table->integer('r_permission');
            $table->integer('u_permission');
            $table->integer('d_permission');
            $table->integer('c_adv_permission');
            $table->integer('r_adv_permission');
            $table->integer('u_adv_permission');
            $table->integer('d_adv_permission');
            $table->integer('c_max_permission');
            $table->integer('r_max_permission');
            $table->integer('u_max_permission');
            $table->integer('d_max_permission');
            $table->boolean('c_match_all')->default(false);
            $table->boolean('r_match_all')->default(false);
            $table->boolean('u_match_all')->default(false);
            $table->boolean('d_match_all')->default(false);
            $table->boolean('c_adv_match_all')->default(false);
            $table->boolean('r_adv_match_all')->default(false);
            $table->boolean('u_adv_match_all')->default(false);
            $table->boolean('d_adv_match_all')->default(false);
            $table->boolean('c_max_match_all')->default(false);
            $table->boolean('r_max_match_all')->default(false);
            $table->boolean('u_max_match_all')->default(false);
            $table->boolean('d_max_match_all')->default(false);
            $table->boolean('c_by_creator')->default(false);
            $table->boolean('r_by_creator')->default(false);
            $table->boolean('u_by_creator')->default(false);
            $table->boolean('d_by_creator')->default(false);
            $table->boolean('c_adv_by_creator')->default(false);
            $table->boolean('r_adv_by_creator')->default(false);
            $table->boolean('u_adv_by_creator')->default(false);
            $table->boolean('d_adv_by_creator')->default(false);
            $table->boolean('c_max_by_creator')->default(false);
            $table->boolean('r_max_by_creator')->default(false);
            $table->boolean('u_max_by_creator')->default(false);
            $table->boolean('d_max_by_creator')->default(false);
            $table->boolean('c_by_assigned_leader')->default(false);
            $table->boolean('r_by_assigned_leader')->default(false);
            $table->boolean('u_by_assigned_leader')->default(false);
            $table->boolean('d_by_assigned_leader')->default(false);
            $table->boolean('c_adv_by_assigned_leader')->default(false);
            $table->boolean('r_adv_by_assigned_leader')->default(false);
            $table->boolean('u_adv_by_assigned_leader')->default(false);
            $table->boolean('d_adv_by_assigned_leader')->default(false);
            $table->boolean('c_max_by_assigned_leader')->default(false);
            $table->boolean('r_max_by_assigned_leader')->default(false);
            $table->boolean('u_max_by_assigned_leader')->default(false);
            $table->boolean('d_max_by_assigned_leader')->default(false);
            $table->boolean('c_by_assigned_user')->default(false);
            $table->boolean('r_by_assigned_user')->default(false);
            $table->boolean('u_by_assigned_user')->default(false);
            $table->boolean('d_by_assigned_user')->default(false);
            $table->boolean('c_adv_by_assigned_user')->default(false);
            $table->boolean('r_adv_by_assigned_user')->default(false);
            $table->boolean('u_adv_by_assigned_user')->default(false);
            $table->boolean('d_adv_by_assigned_user')->default(false);
            $table->boolean('c_max_by_assigned_user')->default(false);
            $table->boolean('r_max_by_assigned_user')->default(false);
            $table->boolean('u_max_by_assigned_user')->default(false);
            $table->boolean('d_max_by_assigned_user')->default(false);
            $table->boolean('c_by_assigned_client')->default(false);
            $table->boolean('r_by_assigned_client')->default(false);
            $table->boolean('u_by_assigned_client')->default(false);
            $table->boolean('d_by_assigned_client')->default(false);
            $table->boolean('c_adv_by_assigned_client')->default(false);
            $table->boolean('r_adv_by_assigned_client')->default(false);
            $table->boolean('u_adv_by_assigned_client')->default(false);
            $table->boolean('d_adv_by_assigned_client')->default(false);
            $table->boolean('c_max_by_assigned_client')->default(false);
            $table->boolean('r_max_by_assigned_client')->default(false);
            $table->boolean('u_max_by_assigned_client')->default(false);
            $table->boolean('d_max_by_assigned_client')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('object_categories');
    }
}
