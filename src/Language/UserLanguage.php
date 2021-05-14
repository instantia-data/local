<?php


namespace Local\Language;

use Local\Language\LanguageService;

/**
 *
 * @author luispinto
 */
trait UserLanguage
{
    
    
    /**
     * 
     * @return StdClass
     */
    public function lang()
    {
        return LanguageService::get()->lang();
    }
    
    /**
     * 
     * @return array
     */
    public function languages()
    {
        return LanguageService::get()->languages();
    }
}
