<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->onDelete('cascade');
            $table->foreignId('integration_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['trigger', 'action', 'condition']);
            $table->string('integration_action')->nullable();
            $table->string('name');
            $table->json('position')->nullable(); // {x: 200, y: 300}
            $table->json('settings')->nullable(); // form values
            $table->json('output_schema')->nullable(); // to assist mapping
            $table->json('next_node_ids')->nullable(); // for flow branching
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
