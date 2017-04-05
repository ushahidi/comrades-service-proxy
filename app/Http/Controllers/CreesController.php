<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Crees;

use Log;

class CreesController extends Controller
{

    public function eventRelated(Request $request)
    {
        $post = $request->all();
        $source_field = config('options.ushahidi.survey_source_field');

        //$source_text = $post['values'][$source_field][0];
        $source_text = $post[$source_field];
        dispatch(new Crees($post['id'], $source_text, 'eventRelated'));

        return;
    }

    public function eventType(Request $request)
    {
        $post = $request->all();
        $source_field = config('options.ushahidi.survey_source_field');

        //$source_text = $post['values'][$source_field][0];
        $source_text = $post[$source_field];
        dispatch(new EventType($post['id'], $source_text, 'eventType'));

        return;
    }

    public function infoType(Request $request)
    {
        $post = $request->all();
        $source_field = config('options.ushahidi.survey_source_field');

        //$source_text = $post['values'][$source_field][0];
        $source_text = $post[$source_field];
        dispatch(new InfoType($post['id'], $source_text, 'infoType'));

        return;
    }    
}
