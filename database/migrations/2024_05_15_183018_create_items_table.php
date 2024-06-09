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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique(); // menentukan bahwa setiap nilai di kolom "slug" harus unik, artinya tidak boleh ada duplikat.

            // Foreign Key atau Relasi dari tabel ke tabel lain
            $table->foreignId('type_id')->constrained(); // foreign key -> type_id to table types
            $table->foreignId('brand_id')->constrained(); // foreign key -> brand_id to table brands

            $table->text('photos')->nullable();
            $table->text('features')->nullable();

            // menunjukkan bahwa kita ingin menambahkan kolom "price" ke dalam tabel dengan tipe data integer, dan jika tidak ada nilai yang diberikan untuk kolom tersebut saat memasukkan data baru, nilainya akan secara otomatis diatur menjadi 0.
            $table->integer('price')->default(0); 
            $table->double('star')->default(0);
            $table->integer('review')->default(0);

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
        Schema::dropIfExists('items');
    }
};
