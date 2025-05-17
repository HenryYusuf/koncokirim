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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->after('address', function ($table) {
                $table->integer('city_id')->nullable();
                $table->text('shop_info')->nullable();
                $table->string('cover_photo')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('shop_info');
            $table->dropColumn('cover_photo');
        });
    }
};
