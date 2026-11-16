<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("announcements", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("content");
            $table->string("category")->default("info"); // info, warning, danger, update
            $table->string("action_text")->nullable();
            $table->string("action_url")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("announcements");
    }
};
