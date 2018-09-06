<?php

namespace App\Http\Controllers;

use App\Jobs\RunVeracityService;
use Illuminate\Http\Request;

use Log;

class VeracityController extends Controller
{

    public function annotate(Request $request)
    {
        $post = $request->all();
        dispatch(new RunVeracityService($post));
        return;
    }

    public function all(Request $request)
    {
        $post = $request->all();
        dispatch(new RunVeracityService($post, 'all'));

        return;
    }
}
