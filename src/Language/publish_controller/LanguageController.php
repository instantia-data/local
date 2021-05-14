<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Local\Language\LanguageChooserService;
use App\Model\Entities\Language;

class LanguageController extends Controller
{

    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new LanguageChooserService();
        parent::viewShare(lang('menu-library.languages'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $results = $this->service->getSupported();
        return view('backend.settings.language.index', [
            'results' => $results
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choose()
    {
        
        return view('backend.settings.language.form-modal', [
            'action'=>route('language.enable'),
            'languages'=> $this->service->listLanguagesForSelector()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \LanguageForm  $request
     * @return \Illuminate\Http\Response
     */
    public function enable(Request $request)
    {
        $model = Language::find($request->input('language_id'));
        $model->supported = 1;
        $model->save();
        
        memory_monitor();
        return redirect()->route('admin.languages')
                ->with('success', lang('menu-library.language') . ' ' . $model->name . ' '. lang('library::admin.enabled'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        $model = Language::find($id);
        Language::where('id', $id)->update([
            Language::FIELD_SUPPORTED => null
        ]);
        

        return redirect()->route('admin.languages')
                ->with('success', lang('menu-library.language') . ' ' . $model->name . ' '. lang('library::admin.disabled'));
    }
}
