<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDefaultStatusInOrdersTable extends Migration
{
    public function up()
    {
        // Untuk MySQL
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')
                  ->default('pending')
                  ->change();
        });

        // Update data existing yang NULL (jika ada)
        \DB::table('orders')->whereNull('status')->update(['status' => 'pending']);
    }

    public function down()
    {
        // Optional: untuk rollback
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')
                  ->default(null)
                  ->change();
        });
    }
}