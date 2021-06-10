<?php

namespace Local\Translations\Services;


class TranslationsService
{
    
    
    
    /**
     *
     * @var array 
     */
    public static $library = [];

    /**
     * 
     */
    public function __construct( ) {
        
        self::$library['resources'] = resource_path() . '/lang';

    }
    
    private static $collection = [];
    
    public function collect()
    {
        //self::$collection['0'] = lang('library::menu.choose-translation-file');
        foreach (self::$library as $key=>$path){
            $dir = str_replace('/src', '/resources/lang', $path);
            if(!is_dir($dir . '/en')){
                continue;
            }
            $files = scandir($dir . '/en');
            foreach($files as $file){
                if(is_dir($file) 
                        || $file == '.gitignore'
                        || ($key == 'library' && $file == 'locales.php')
                        || ($key == 'resources' && $file == 'validation.php')){
                    continue;
                }
                $info = pathinfo($dir . '/' . $file);
                self::$collection[$key . '-' . $info['filename']] = $info;
                
            }
            
        }
        
        return self::$collection;
    }
    
    
    
    /**
     * Get a container for TranslationsService
     * 
     * @return \App\Domains\Translations\Services\TranslationsService
     */
    public static function get()
    {
        return new TranslationsService();
    }
    


    
}
