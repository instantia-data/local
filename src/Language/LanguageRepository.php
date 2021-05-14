<?php

namespace Local\Language;

use App\Model\Entities\Language;

class LanguageRepository
{
    
    
    /**
     * @var $model
     */
    private $model;
    
    /**
     * EloquentPackage constructor.
     *
     * @return \App\Model\Repositories\LanguageRepository
     */
    public function __construct() {
        $this->model = new Language();
    }
    
    /**
     * 
     * @param string $alias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function start($alias = null)
    {
        if($alias == null){
            $alias = Language::TABLE_NAME;
        }
        return Language::from(Language::TABLE_NAME . ' AS ' .$alias)->select($alias . '.*');
    }
    
    /**
     * 
     * @return \App\Model\Repositories\LanguageRepository
     */
    public static function get()
    {
        return new LanguageRepository();
    }
    
    /**
     * 
     * @param string $iso
     * @return \App\Model\Entities\Language
     */
    public function getByIso($iso)
    {
        
        return $this->start()->where(Language::FIELD_ISO, $iso)->first();
    }
    
    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getLanguages()
    {
        return $this->start()->get();
    }
    
    
    public function getAll()
    {
        return $this->model->orderBy('name')->get();
    }
    
    public function getSupported()
    {
        info('langs query ');
        return $this->model->where('supported', 1)->orderBy('name')->get();
    }
    
}
