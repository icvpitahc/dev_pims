<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->integer('local')->nullable();
            $table->string('password');
            $table->integer('position_id')->nullable();
            $table->string('employee_id_no')->nullable();
            $table->integer('office_id')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('userlevel_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status_type_id')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
