<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('css_responses', function (Blueprint $table) {
            $table->id();
            $table->integer('status_type_id')->nullable();
            $table->date('date_transacted')->nullable();
            $table->date('date_accomplished')->nullable();
            $table->string('client_name')->nullable();
            $table->string('contact_details')->nullable();
            $table->integer('sex_type_id')->nullable();
            $table->integer('client_group_id')->nullable();
            $table->integer('client_type_id')->nullable();
            $table->string('specify_client_type')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('transacting_office_id')->nullable();
            $table->integer('availed_service_id')->nullable();
            $table->text('other_service_availed')->nullable();
            $table->integer('awareness_response_id')->nullable();
            $table->integer('visibility_response_id')->nullable();
            $table->integer('helpfulness_response_id')->nullable();
            $table->integer('responsiveness_rate_id')->nullable();
            $table->text('responsiveness_remarks')->nullable();
            $table->integer('reliability_rate_id')->nullable();
            $table->text('reliability_remarks')->nullable();
            $table->integer('facility_access_rate_id')->nullable();
            $table->text('facility_access_remarks')->nullable();
            $table->integer('communication_rate_id')->nullable();
            $table->text('communication_remarks')->nullable();
            $table->integer('cost_rate_id')->nullable();
            $table->text('cost_remarks')->nullable();
            $table->integer('integrity_rate_id')->nullable();
            $table->text('integrity_remarks')->nullable();
            $table->integer('assurance_rate_id')->nullable();
            $table->text('assurance_remarks')->nullable();
            $table->integer('outcome_rate_id')->nullable();
            $table->text('outcome_remarks')->nullable();
            $table->integer('overall_rate_id')->nullable();
            $table->text('overall_remarks')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('css_responses');
    }
};
