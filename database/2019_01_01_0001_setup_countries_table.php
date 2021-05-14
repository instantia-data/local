<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupCountriesTable extends Migration
{
    
    /**
     * Schema table name to migrate
     * @var string
     */
    public $schema_table = 'local_country';

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Creates the users table
        Schema::create($this->schema_table, function($table) {
            $table->engine = 'InnoDB';
            $table->integer('id')->unsigned()->index();
            $table->string('name', 100)->default('');
            $table->char('iso', 2)->default('');
            //$table->char('iso_3166_2', 2)->default('');
            //$table->char('iso_3166_3', 3)->default('');
            $table->string('currency_code', 20)->nullable();
            //$table->char('country_code', 3)->default('');
            //$table->string('currency', 50)->nullable();
            //$table->string('currency_sub_unit', 80)->nullable();
            $table->char('currency_symbol', 3)->nullable();
            //$table->integer('currency_decimals')->nullable();

            //$table->string('capital', 100)->nullable();
            //$table->string('citizenship', 100)->nullable();
            //$table->string('full_name', 100)->nullable();
            //$table->string('region_code', 3)->default('');
            //$table->char('sub_region_code', 3)->default('');
            //$table->boolean('eea')->default(0);
            //$table->char('calling_code', 3)->nullable();
            //$table->char('flag', 6)->nullable();

            $table->primary('id');
        });

        Schema::table($this->schema_table, function (Blueprint $table) {
            $table->boolean('supported')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop($this->schema_table);
    }

}
