<?php

namespace Local\Translations\Forms;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Model\Entities\Translations;

class TranslationsForm extends FormRequest
{
    use \App\Model\Helpers\TranslationsHelper;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->defaultRules();
    }
    
    /**
     * 
     * @param \App\Model\Entities\Translations $model
     * @param string $action
     * @param string $title
     * 
     * @return array
     */
    public static function view(Translations $model, $action, $title)
    {
        return [
           'model'=> $model,
           'action'=>$action,
           'title'=>$title
                
        ];
    }
    
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        return $validator;
        /**
        throw (new ValidationException($validator))
                    ->errorBag($this->errorBag)
                    ->redirectTo($this->getRedirectUrl());
         * 
         */
    }
    
    
    public function getValidator()
    {
        return \Illuminate\Support\Facades\Validator::make($this->all(), $this->rules());
    }

}
