<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_reference_code')->nullable();
            $table->integer('extremely_urgent_id')->nullable();
            $table->date('expected_completion_date')->nullable();
            $table->integer('document_type_id')->nullable();
            $table->integer('document_sub_type_id')->nullable();
            $table->string('document_title')->nullable();
            $table->text('specify_attachments')->nullable();
            $table->text('note')->nullable();
            $table->integer('division_id')->nullable();
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
        Schema::dropIfExists('documents');
    }
}
