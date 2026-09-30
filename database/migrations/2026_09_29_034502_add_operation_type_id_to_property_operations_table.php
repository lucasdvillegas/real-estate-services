<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_operations', function (Blueprint $table) {
            $table->foreignId('operation_type_id')->nullable()->constrained()->nullOnDelete()->after('property_id');
        });
    }

    public function down(): void
    {
        Schema::table('property_operations', function (Blueprint $table) {
            $table->dropForeign(['operation_type_id']);
            $table->dropColumn('operation_type_id');
        });
    }
};
