<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

             // Name
             $table->string('name')->nullable(); // Ketika booking input nama bisa kosong

             // Start and end date
             $table->date('start_date')->nullable();
             $table->date('end_date')->nullable();
 
             // Address
             $table->text('address')->nullable();
             $table->string('city')->nullable();
             $table->string('zip')->nullable();
 
             $table->string('status')->default('pending');
 
             // Payment 
             $table->string('payment_method')->default('midtrans');
             $table->string('payment_status')->default('pending');
             $table->string('payment_url')->nullable();
 
             // Total Price
             $table->integer('total_price')->default(0);
 
             // Relation to Item and User
             // Foreign Key atau Relasi dari tabel ke tabel lain
             $table->foreignId('item_id')->constrained(); // foreign key -> item_id to table items
             $table->foreignId('user_id')->constrained(); // foreign key -> user_id to table users
 
             $table->softDeletes();
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
        Schema::dropIfExists('bookings');
    }
};
