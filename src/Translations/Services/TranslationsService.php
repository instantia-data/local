<?php

namespace Local\Translations\Services;

use Illuminate\Http\Request;
use App\Model\Repositories\TranslationsRepository;
use App\Model\Entities\TranslationIndex;
use App\Model\Entities\Translations;
use Local\Debuggy\ExceptionLog;

class TranslationsService
{
    
    use \Library\Validators\ValidatorTools;
    use \Library\DataTables\ListTools;
    
    /**
     *
     * @var \App\Model\Repositories\TranslationsRepository 
     */
    protected $repository;
    
    /**
     *
     * @var array 
     */
    public static $library = [];

    /**
     * 
     */
    public function __construct( ) {
        
        $this->repository = new TranslationsRepository();
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
    
    /**
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getCollection($key)
    {
        $index = $this->getIndex($key);
        $translations = $this->getRecords($index);
        
        return $translations;
    }
    
    private function getRecords($index)
    {
        $translations = [];
        $source = self::$collection[$index->code];
        $source_file = base_path() . $index->path;
        if(!is_file($source_file)){
            $source_file = $source['dirname'] . '/en/' . $source['basename'];
        }
        $originals = include($source['dirname'] . '/en/' . $source['basename']);
        
        foreach ($originals as $key => $text) {
            if(is_int($key) || is_array($text)){
                continue;
            }
            $model = Translations::firstOrCreate([
                        'index_id' => $index->id, 'code' => $key,
                            ], [
                        'translation' => $text
            ]);
            $model->original = $text;
            $model->makeVisible('original');
            //$model->translation = $text;
            $translations[] = $model;
            
        }
        return $translations;
    }
    
    private function getIndex($key)
    {
        $path = self::$collection[$key];
        $dir = $path['dirname'] . '/' . user()->lang()->iso;
        if (!is_dir($dir)) {
            try {
                mkdir($dir);
            } catch (\Exception $e) {
                $exception = ExceptionLog::get($e);
                echo $exception->error_message;
                dd($dir);
            }
        }
        $file = $dir . '/' . $path['basename'];
        if(!is_file($file)){
            copy($path['dirname'] . '/en/' . $path['basename'], $file);
        }
        return TranslationIndex::firstOrCreate([
            'language_id'=>user()->lang()->id, 'code'=>$key
        ], [
            'path'=> str_replace(base_path(), '', $file)
        ]);
    }
    
    

    private $limit = 200;

    /**
     * 
     * @param Request $request
     * @return Translations
     */
    public function save(Request $request, $name)
    {
        $index = $this->getIndex($name);
        $translations = $this->getRecords($index);
        $inputs = $request->input('translation');
        $array = [];
        foreach($translations as $row){
            $array[$row->code] = $row->translation;
            if(isset($inputs[$row->code])){
                Translations::where('id', $row->id)->update([
                    'translation'=>$inputs[$row->code]
                ]);
                $array[$row->code] = $inputs[$row->code];
            }
        }
        
        if(is_file(base_path() . $index->path)){
            $this->writeFile($index, $array);
        }
        
        return (object) [
            'message'=> lang('library::admin.updated'), 
            'inputs'=>$request->input(), 
            'success'=> true,
            'index'=>$index
                ];
    }
    
    private function writeFile($index, $translations)
    {
        $file = base_path() . $index->path;

        $string = "<?php \n\n return [\n";
        foreach ($translations as $key => $value) {
            $string .= "\t'" . $key . "' => '" . addslashes($value) . "',\n";
        }
        $string .= "\n];\n";
        file_put_contents($file, $string);
        
        $pathinfo = pathinfo($file);
        if(!is_file($pathinfo['dirname'] . '/.gitignore')){
            copy(base_path() . '/packages/instantia/library/resources/utils/gitignore.txt', 
                    $pathinfo['dirname'] . '/.gitignore');
        }
    }
    
    /**
     * Get the Translationss for populate drop-down
     * @return array
     */
    public function listTranslationssForSelector()
    {
        $result = $this->repository->getCollection()->get();
        $arr = [0 => ''];
        foreach ($result as $row) {
            $arr[$row->id] = $row->name;
        }
        //asort($arr);
        return $arr;
    }
    
    /**
     * 
     * @param Translations $model
     */
    public function delete($model)
    {
        $model->delete();
    }
    
    
    /**
     * 
     * @param Collection $results
     * @param int $offset
     * @param int $draw
     * @return array
     */
    public function getJson($results, $offset, $draw = 1)
    {
        $json = [
            'draw' => (count($results) < $this->limit) ? 0 : $draw,
            'offset' => $offset + count($results),
            'data' => []
        ];
        foreach ($results as $row) {
            $json['data'][] = array_merge($row->toArray(), [
                '', 'DT_RowAttr'=>(object) $this->getButtons($row->id, $row->name, [
                   'edit'=>route('translations.edit', $row->id),
                   'delete'=>route('translations.destroy', $row->id)
               ])]);
        }
        //log_print('results', $json);
        memory_monitor();
        return $json;
    }
    
}
