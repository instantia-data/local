<?php

namespace Local\Language;

use Local\Language\LanguageRepository;
use App\Model\Entities\Language;
use App\User;

class LanguageService
{
    
    protected $repository;

    /**
     * 
     */
    public function __construct( ) {
        
        $this->repository = new LanguageRepository();

    }
    
    /**
     * Get a container for LanguageService
     * 
     * @return \App\Domains\Language\Services\LanguageService
     */
    public static function get()
    {
        return new LanguageService();
    }
    
    /**
     * Get the language for populate drop-down
     * @return array
     */
    public function listLanguageForSelector() {
        $result = $this->repository->getAll();

        $arr = [0 => ''];
        foreach ($result as $row) {
            $arr[$row->id] = $row->name;
        }

        return $arr;
    }
    
    /**
     * Get the language for populate drop-down
     * @return array
     */
    public function listSupportedLanguagesForSelector() {
        $result = self::$supported;

        $arr = [];
        foreach ($result as $row) {
            $arr[$row->id] = lang('library::languages.lang-' . $row->iso);
        }
        info('langs array: ' . count($arr));

        return $arr;
    }

    /**
     * Get the language for populate drop-down
     * @return array
     */
    public static function getLanguageSelector()
    {
        $obj = new LanguageService();
        return $obj->listLanguageForSelector();
    }
    
    public function getSupportedLangs()
    {
        $locale = env('APP_LOCAL');
        $langs = [];
        $langs[] = Language::where('iso', $locale)->first();
        $others = self::$supported;
        foreach($others as $lang){
            if($lang->iso == $locale){
                continue;
            }
            $langs[] = $lang;
        }
        //info('langs: ' . count($langs));
        return $langs;
    }
    
    public function getIsoColumns()
    {
        $arr = [];
        $supported = $this->getSupportedLangs();
        foreach ($supported as $lang){
            $arr[] = $lang->iso;
        }
        return $arr;
    }
    
    /**
     * Call by middleware \Local\Language\CheckLanguage
     * @param User $user
     */
    public function setUserLanguage(User $user = null)
    {
        $this->setLanguages($this->getLanguage($user));
        //log_print('setup user language', 1);
    }
    

    
    /**
     * Define the default language or the language that user has chosen
     * 
     * @param User $user
     * @return string The language iso (en, pt, fr, etc)
     */
    public function getLanguage(User $user = null)
    {
        
        $update = false;
        $iso = env('APP_LOCAL');
        if (request()->get('use_lang') != null) {
            $iso = request()->get('use_lang');
            $update = true;
        } elseif (session('lang') != null) {
            $iso = session('lang');
        } elseif(null != $user) {
            $row = Language::find($user->language_id);
            if(null != $row){
                $iso = $row->iso;
            }
        }
        if(true == $update && null != $user){
            $language = Language::where('iso', $iso)->first();
            if(null != $language){
                $user->language_id = $language->id;
                $user->save();
            }
        }
        return $iso;
    }
    
    public static $lang = null;
    
    public static $languages = [];
    
    public static $supported = [];


    /**
     * Define the languages that user has access
     * @param type $iso
     * @param User $user
     * @return type
     */
    public function setLanguages($iso, User $user = null)
    {
        $languages = (!count(self::$supported))? Language::where('supported', 1)->get(): self::$supported;
        foreach ($languages as $lang) {
            $lang->flag = '/vendor/flags/flags/4x3/' . $lang->iso . '.svg';
            if ($lang->iso == $iso) {
                self::$lang = $lang;
                app()->setLocale($iso);
                session(['lang' => $iso]);
            }
            self::$languages[$lang->iso] = $lang->name;
        }
        if (null != $user) {
            $user->setLang(self::$lang);
        }
        self::$supported = $languages;
        return self::$languages;
    }
    
    public function chooseDefaultLanguage()
    {
        return $this->repository->getByIso(app()->getLocale());
    }
    
    /**
     * 
     * @param Language $lang
     */
    public function setLang($lang)
    {
        self::$lang = $lang;
    }
    
    /**
     * 
     * @return StdClass
     */
    public function lang()
    {
        if(null == self::$lang){
            $this->setLanguages($this->getLanguage());
        }
        return self::$lang;
    }
    
    /**
     * 
     * @return array
     */
    public function languages()
    {
        return self::$languages;
    }
    
    
    /**
     * 
     * @param string $iso
     * @return \App\Model\Entities\Language
     */
    public function getByIso($iso)
    {
        
        return $this->repository->getByIso($iso);
    }
    
    /**
     * 
     * @return \App\Model\Entities\Language
     */
    public function getDefaultLanguage()
    {
        
        return $this->repository->getByIso(env('APP_LOCAL'));
    }
    
}
