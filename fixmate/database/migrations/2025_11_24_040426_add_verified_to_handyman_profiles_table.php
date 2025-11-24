<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('handyman_profiles', function (Blueprint $table) {
        $table->boolean('verified')->default(false)->after('average_rating');
    });
}

public function down()
{
    Schema::table('handyman_profiles', function (Blueprint $table) {
        $table->dropColumn('verified');
    });
}

};
