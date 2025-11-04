<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('detail');
            $table->integer('stock')->default(0)->after('price');
            $table->string('image')->nullable()->after('stock');
            $table->boolean('is_active')->default(true)->after('image');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'stock', 'image', 'is_active']);
        });
    }
};
