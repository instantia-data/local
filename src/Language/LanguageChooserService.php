<?php

namespace Local\Language;

use App\Model\Entities\Language;

class LanguageChooserService extends \Local\Language\LanguageService
{
    
    
    /**
     *
     * @var \App\Model\Repositories\LanguageRepository 
     */
    protected $repository;
    
    /**
     * Get a container for LanguageService
     * 
     * @return \Local\Language\LanguageChooserService
     */
    public static function get()
    {
        return new LanguageChooserService();
    }
    
    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getCollection() {
        $q = $this->repository->getAll();
        
        return $q->get();
    }
    
    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getSupported() {
        return $this->repository->getSupported();
    }
    
    
    
    
    public function getAppLanguage()
    {
        return Language::where('iso', env('APP_LOCAL'))->first();
    }
    
}
