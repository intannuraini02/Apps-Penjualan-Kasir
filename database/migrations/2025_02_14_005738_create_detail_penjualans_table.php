    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up()
        {
            Schema::create('detail_penjualans', function (Blueprint $table) {
                $table->id('DetailPenjualanID'); // Primary Key
                $table->unsignedBigInteger('PenjualanID'); // Foreign Key ke Penjualan
                $table->unsignedBigInteger('ProdukID'); // Foreign Key ke Produk
                $table->integer('Jumlah')->nullable(); // Jumlah bisa null
                $table->decimal('Subtotal', 10, 2); // HargaSatuan * Jumlah
                $table->timestamps();

            });
        }

        public function down()
        {
            Schema::dropIfExists('detail_penjualans');
        }
    };
