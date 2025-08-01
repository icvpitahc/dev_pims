<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->nullable();
            $table->integer('status_type_id')->nullable(); // Active / Inactive
            $table->integer('action_id')->nullable(); // Forward / Discard / Complete
            $table->integer('from_division_id')->nullable();
            $table->integer('to_division_id')->nullable();
            $table->string('remarks')->nullable();
            $table->datetime('received_date')->nullable();
            $table->integer('received_by')->nullable();
            $table->datetime('forwarded_date')->nullable();
            $table->integer('forwarded_by')->nullable();
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
        Schema::dropIfExists('document_logs');
    }
}
