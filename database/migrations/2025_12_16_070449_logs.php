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
        Schema::create('logs', function (Blueprint $table) {
            $table->id("id_log");
            $table->unsignedBigInteger("id_ticket")->index(); //fk tickets
            $table->unsignedBigInteger("id_user")->index(); //fk users
            $table->string("action");
            $table->text("details")->nullable();
            $table->timestamps();

            // fk
            $table->foreign("id_ticket")->references("id_ticket")->on("tickets")->onDelete("cascade");
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
