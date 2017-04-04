<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Annotate;

use Log;

class AnnotationController extends Controller
{

    public function annotate(Request $request)
    {
        $post = $request->all();
        $source_field = config('options.ushahidi.survey_source_field');

        //$source_text = $post['values'][$source_field][0];
        $source_text = $post[$source_field];
        dispatch(new Annotate($post['id'], $source_text));

        return;
    }
}
