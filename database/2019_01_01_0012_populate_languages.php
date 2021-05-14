<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PopulateLanguages extends Migration
{
    
    private $supporteds = [
        'en', 'pt'
    ];

    /**
     * Schema table name to migrate
     * @var string
     */
    public $schema_table = 'local_language';

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        //Get all of the languages
        $languages = \PeterColes\Languages\LanguagesFacade::lookup();
        foreach($languages as $key=>$lang){
            DB::table($this->schema_table)->updateOrInsert([
            'iso' => $key,
            'name'=>$lang,
            'supported'=>(in_array($key, $this->supporteds))? 1:0
            ]);
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        return;
    }

}
