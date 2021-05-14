<?php

use Illuminate\Database\Migrations\Migration;
use Local\Countries\CountryService;
use Illuminate\Support\Facades\DB;

class PopulateLocalRegionPt extends Migration {

    /**
     * Schema table name to migrate
     * @var string
     */
    public $schema_table = 'local_region';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        $regions = $this->regions();
        foreach ($regions as $region) {
            DB::table($this->schema_table)->updateOrInsert([
                'country_id' => CountryService::get()->getByIso($region['country_code'])->id,
                'name' => $region['name'], 'slug' => $region['slug'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
    }

    /**
     * Get country regions.
     *
     * @return array
     */
    public function regions() {
        return [
            ['country_code' => 'PT', 'name' => 'Açores', 'active' => 1, 'slug' => 'acores'],
            ['country_code' => 'PT', 'name' => 'Aveiro', 'active' => 1, 'slug' => 'aveiro'],
            ['country_code' => 'PT', 'name' => 'Beja', 'active' => 1, 'slug' => 'beja'],
            ['country_code' => 'PT', 'name' => 'Braga', 'active' => 1, 'slug' => 'braga'],
            ['country_code' => 'PT', 'name' => 'Bragança', 'active' => 1, 'slug' => 'braganca'],
            ['country_code' => 'PT', 'name' => 'Castelo Branco', 'active' => 1, 'slug' => 'castelo-branco'],
            ['country_code' => 'PT', 'name' => 'Coimbra', 'active' => 1, 'slug' => 'coimbra'],
            ['country_code' => 'PT', 'name' => 'Évora', 'active' => 1, 'slug' => 'evora'],
            ['country_code' => 'PT', 'name' => 'Faro', 'active' => 1, 'slug' => 'faro'],
            ['country_code' => 'PT', 'name' => 'Guarda', 'active' => 1, 'slug' => 'guarda'],
            ['country_code' => 'PT', 'name' => 'Leiria', 'active' => 1, 'slug' => 'leiria'],
            ['country_code' => 'PT', 'name' => 'Lisboa', 'active' => 1, 'slug' => 'lisboa'],
            ['country_code' => 'PT', 'name' => 'Madeira', 'active' => 1, 'slug' => 'madeira'],
            ['country_code' => 'PT', 'name' => 'Portalegre', 'active' => 1, 'slug' => 'portalegre'],
            ['country_code' => 'PT', 'name' => 'Porto', 'active' => 1, 'slug' => 'porto'],
            ['country_code' => 'PT', 'name' => 'Santarém', 'active' => 1, 'slug' => 'santarem'],
            ['country_code' => 'PT', 'name' => 'Setúbal', 'active' => 1, 'slug' => 'setubal'],
            ['country_code' => 'PT', 'name' => 'Viana do Castelo', 'active' => 1, 'slug' => 'viana-do-castelo'],
            ['country_code' => 'PT', 'name' => 'Vila Real', 'active' => 1, 'slug' => 'vila-real'],
            ['country_code' => 'PT', 'name' => 'Viseu', 'active' => 1, 'slug' => 'viseu']
        ];
    }

}
