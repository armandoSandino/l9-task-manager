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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('description')
            ->nullable()
            ->comment('represents the desciptions');
            $table->unsignedBigInteger('collaborator_id')
            ->comment('represents the collaborators identifier');
            $table->enum('state',['PENDIENTE','PROCESO','FINALIZADA'])
            ->default('PENDIENTE')
            ->comment('represents the state');
            $table->enum('priority', ['ALTA', 'MEDIA', 'BAJA'] )
            ->default('BAJA')
            ->comment('represents priority');
            $table->date('startDate')
            ->comment('represents the start date');
            $table->date('endDate')
            ->comment('represents the end date');
            $table->string('notes')
            ->nullable()
            ->comment('represents the notes of the task');
            $table->foreign('collaborator_id')
            ->references('id')
            ->on('collaborators');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function(Blueprint $table){
            $table->dropForeign(['collaborator_id']);
            $table->dropColumn(['collaborator_id']);
        });
        Schema::dropIfExists('tasks');
    }
};
