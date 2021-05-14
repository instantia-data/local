<?php

namespace Local\Language;

use Illuminate\Database\Seeder;
use App\Model\Entities\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::where('supported', 1)->update(['supported'=>null]);
        Language::whereIn('iso', config('library.languages'))->update(['supported'=>1]);
        Language::where('iso', 'pt')->update(['name'=>'Português']);
    }
}
