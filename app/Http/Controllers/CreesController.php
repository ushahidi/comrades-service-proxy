<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\RunCreesService;

use Log;

class CreesController extends Controller
{

    public function all(Request $request)
    {
        $post = $request->all();
        dispatch(new RunCreesService($post, 'all'));

        return;
    }

    public function eventRelated(Request $request)
    {
        $post = $request->all();
        dispatch(new RunCreesService($post, 'eventRelated'));

        return;
    }

    public function eventType(Request $request)
    {
        $post = $request->all();
        dispatch(new RunCreesService($post, 'eventType'));

        return;
    }

    public function infoType(Request $request)
    {
        $post = $request->all();
        dispatch(new RunCreesService($post, 'infoType'));

        return;
    }
}
