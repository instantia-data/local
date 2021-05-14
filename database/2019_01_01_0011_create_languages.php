<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguages extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $schema_table = 'local_language';

    /**
     * Run the migrations.
     * @table policy
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->schema_table)) {
            return;
        }
        Schema::create($this->schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->char('iso', 3)->nullable(false);
            $table->boolean('supported')->nullable()->default(null);
            $table->string('name', 100)->nullable(false);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->schema_table);
     }
}
