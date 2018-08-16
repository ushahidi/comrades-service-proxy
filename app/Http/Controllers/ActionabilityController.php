<?php

namespace App\Http\Controllers;

use App\Jobs\RunActionabilityService;
use Illuminate\Http\Request;

use Log;

class ActionabilityController extends Controller
{

    public function annotate(Request $request)
    {
        $post = $request->all();
        dispatch(new RunActionabilityService($post));
        return;
    }

    public function all(Request $request)
    {
        $post = $request->all();
        dispatch(new RunActionabilityService($post, 'all'));

        return;
    }
}
