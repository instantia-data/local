<?php

namespace Local\Language;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

/**
 * Description of LanguageTools
 *
 * @author luispinto
 */
class LanguageTools
{
    
    
    
    
    /**
     * 
     * @param string $index
     * @param string $input
     * @return string
     */
    public static function translateError($index, $input)
    {
        $message = Lang::get($index);
        return self::replaceAttributePlaceholder($message, $input);
    }
    
    
    /**
     * Replace the :attribute placeholder in the given message.
     *
     * @param  string  $message
     * @param  string  $value
     * @return string
     */
    protected static function replaceAttributePlaceholder($message, $value)
    {
        return str_replace(
            [':attribute', ':ATTRIBUTE', ':Attribute'],
            [$value, Str::upper($value), Str::ucfirst($value)],
            $message
        );
    }
}
