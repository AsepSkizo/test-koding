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
        Schema::create('harians', function (Blueprint $table) {
            $table->id();
            $table->string("rekening_id");
            // $table->string("")
            $table->enum("via", ["Bendahara", "Bank"]);
            $table->date("tanggal");
            $table->integer("jumlah");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harians');
    }
};
