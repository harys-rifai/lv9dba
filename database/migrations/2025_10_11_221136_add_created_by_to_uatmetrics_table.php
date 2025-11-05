<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
public function up()
{
    Schema::table('uatmetrics', function (Blueprint $table) {
        $table->integer('pru_id')->default(0)->after('LongQueryCount');
        $table->string('created_by', 150)->nullable()->after('updated_at');
    });
}
 
 

public function down()
{
    Schema::table('uatmetrics', function (Blueprint $table) {
        $table->dropColumn(['pru_id', 'created_by']);
    });

}

};
