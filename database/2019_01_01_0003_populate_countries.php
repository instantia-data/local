<?php

use Webpatser\Countries\CountriesFacade as Countries;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class PopulateCountries extends Migration
{
    
    private $supporteds = [
        'GB', 'PT'
    ];

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
        //Get all of the countries
        $countries = Countries::getList();
        foreach ($countries as $countryId => $country){
            
            DB::table($this->schema_table)->updateOrInsert([
            'id' => $countryId,
            'name' => $country['name'],
            'iso' => $country['iso_3166_2'],
            'currency_code' => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
            'currency_symbol' => ((isset($country['currency_symbol'])) ? $country['currency_symbol'] : null),
            
            'supported' => (in_array($country['iso_3166_2'], $this->supporteds)) ? 1 : null,
            ]);


            /*
            DB::table(\Config::get('countries.table_name'))->insert([
                'id' => $countryId,
                'capital' => ((isset($country['capital'])) ? $country['capital'] : null),
                //'citizenship' => ((isset($country['citizenship'])) ? $country['citizenship'] : null),
                //'country_code' => $country['country-code'],
                //'currency' => ((isset($country['currency'])) ? $country['currency'] : null),
                'currency_code' => ((isset($country['currency_code'])) ? $country['currency_code'] : null),
                //'currency_sub_unit' => ((isset($country['currency_sub_unit'])) ? $country['currency_sub_unit'] : null),
                //'currency_decimals' => ((isset($country['currency_decimals'])) ? $country['currency_decimals'] : null),
                //'full_name' => ((isset($country['full_name'])) ? $country['full_name'] : null),
                'iso' => $country['iso_3166_2'],
                //'iso_3166_2' => $country['iso_3166_2'],
                //'iso_3166_3' => $country['iso_3166_3'],
                'name' => $country['name'],
                //'region_code' => $country['region-code'],
                //'sub_region_code' => $country['sub-region-code'],
                //'eea' => (bool)$country['eea'],
                'calling_code' => $country['calling_code'],
                //'currency_symbol' => ((isset($country['currency_symbol'])) ? $country['currency_symbol'] : null),
                //'flag' =>((isset($country['flag'])) ? $country['flag'] : null),
                ]);
             * 
             */
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
