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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id("id_ticket");
            $table->unsignedBigInteger("id_user")->index(); //fk users
            $table->string("title");
            $table->text("description");
            $table->unsignedBigInteger("id_category")->index(); //fk category
            $table->string("attachment")->nullable();
            $table->string("status", 20)->default("open"); // new, progress, resolved
            $table->string("admin_note")->nullable();
            $table->timestamps();


            // fk
            $table->foreign("id_user")->references("id_user")->on("users")->onDelete("cascade");
            $table->foreign("id_category")->references("id_category")->on("category")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
