<?php

namespace Local\Countries;

use App\Model\Entities\Country;

class CountryRepository
{
    
    
    /**
     * @var $model
     */
    private $model;
    
    /**
     * EloquentPackage constructor.
     *
     * @return \Local\Countries\CountryRepository
     */
    public function __construct() {
        $this->model = new Country();
    }
    
    /**
     * 
     * @param string $alias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function start($alias = null)
    {
        if($alias == null){
            $alias = Country::TABLE_NAME;
        }
        return Country::from(Country::TABLE_NAME . ' AS ' .$alias)->select($alias . '.*');
    }
    
    /**
     * Get all Countries
     * @return type
     */
    public function getAll()
    {
        return $this->model->orderBy('name')->get();
    }
    
    /**
     * Get supported Countries
     * @return \Illuminate\Support\Collection
     */
    public function getCountries()
    {
        return $this->start()
                ->orderBy(Country::FIELD_NAME)
                ->where(Country::FIELD_SUPPORTED, 1)->get();
    }
    
    /**
     * Get country by name or iso
     * @param string $country
     * @return \Country
     */
    public function getByNameOrIso($country)
    {
        return $this->model
                ->where(Country::FIELD_NAME, $country)
                ->orWhere(Country::FIELD_ISO, $country)
                ->first();
    }
    
    /**
     * 
     * @return \App\Model\Repositories\CountryRepository
     */
    public static function get()
    {
        return new CountryRepository();
    }
    
    

}
