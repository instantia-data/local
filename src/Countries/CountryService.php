<?php

namespace Local\Countries;

use Local\Countries\CountryRepository;
use App\Model\Entities\Country;

class CountryService
{
    
    
    protected $repository;

    /**
     * 
     */
    public function __construct( ) {
        
        $this->repository = new CountryRepository();

    }
    
    /**
     * Get a container for CountryService
     * 
     * @return \Local\Countries
     */
    public static function get()
    {
        return new CountryService();
    }
    
    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getcountries() {
        $q = $this->repository->getAll();
        
        return $q;
    }
    
    /**
     * Get the language for populate drop-down
     * @return array
     */
    public function listAllCountries() {
        return $this->repository->getAll()->pluck('name', 'id');
    }
    
    
    /**
     * Get the language for populate drop-down
     * @return array
     */
    public function listCountriesForSelector() {
        $result = $this->repository->getCountries();

        $arr = [];
        foreach ($result as $row) {
            $arr[$row->id] = $row->name;
        }

        return $arr;
    }
    
    public function getByIso($iso)
    {
        return $this->repository->getByNameOrIso($iso);
    }
    
    public function getDefaultCountry()
    {
        return $this->repository->getByNameOrIso(env('APP_COUNTRY'));
    }
    
    /**
     * 
     * @return string The language iso (en, pt, fr, etc)
     */
    public function getIsoCountry()
    {
        
        $update = false;
        $iso = env('APP_COUNTRY');
        if (request()->get('use_country') != null) {
            $iso = request()->get('use_country');
            $update = true;
        } elseif (session('country') != null) {
            $iso = session('country');
        }
        return $iso;
    }
    
    public static $country = null;


    public function setCountry($iso)
    {
        $country = Country::where('iso', $iso)->first();
        if(null == $country){
            $country = Country::where('iso', env('APP_COUNTRY'))->first();
        }
        self::$country = $country;
    }
    
    /**
     * 
     * @return StdClass
     */
    public function country()
    {
        if(null == self::$country){
            self::$country = $this->getDefaultCountry();
        }
        return self::$country;
    }

}
