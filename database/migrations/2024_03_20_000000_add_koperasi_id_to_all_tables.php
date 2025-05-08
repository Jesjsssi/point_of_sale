<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $tables = [
            'categories',
            'products',
            'suppliers',
            'customers',
            'employees',
            'orders',
            'order_details',
            'attendences',
            'advance_salaries',
            'pay_salaries'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('koperasi_id')->nullable()->constrained('koperasi')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        $tables = [
            'categories',
            'products',
            'suppliers',
            'customers',
            'employees',
            'orders',
            'order_details',
            'attendences',
            'advance_salaries',
            'pay_salaries'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['koperasi_id']);
                $table->dropColumn('koperasi_id');
            });
        }
    }
}; 