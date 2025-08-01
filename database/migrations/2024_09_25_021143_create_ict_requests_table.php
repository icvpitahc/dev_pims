<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIctRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ict_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_status_type_id')->nullable();
            $table->string('ticket_no')->nullable();
            $table->integer('request_type_id')->nullable();
            $table->integer('sub_request_type_id')->nullable();
            $table->text('request_details')->nullable();
            $table->integer('technical_support_representative_id')->nullable();
            $table->text('technical_support_representative_findings')->nullable();
            $table->text('reason_for_cancellation')->nullable();
            $table->dateTime('action_taken_datetime')->nullable();
            $table->text('action_taken')->nullable();
            $table->dateTime('resolved_datetime')->nullable();
            $table->dateTime('cancelled_datetime')->nullable();
            $table->dateTime('acknowledged_datetime')->nullable();      
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable(); 
            $table->integer('deleted_by')->nullable();
            $table->datetime('deleted_at')->nullable();   
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
        Schema::dropIfExists('ict_requests');
    }
}
