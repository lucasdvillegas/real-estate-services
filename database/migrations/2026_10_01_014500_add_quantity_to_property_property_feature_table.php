<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_property_feature', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->nullable()->after('property_feature_id');
        });
    }

    public function down(): void
    {
        Schema::table('property_property_feature', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
