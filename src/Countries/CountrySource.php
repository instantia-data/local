<?php


namespace Local\Countries;

/**
 * Description of CountrySource
 *
 * @author luispinto
 */
class CountrySource 
{
    
    public static function getJson() 
    {
        return json_decode(file_get_contents(__DIR__ . '/../../data/countries.json'), true);
    }
}
