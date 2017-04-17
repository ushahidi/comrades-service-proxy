<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\RunYodieService;

use Log;

class YodieController extends Controller
{

    public function annotate(Request $request)
    {
        $post = $request->all();
        dispatch(new RunYodieService($post));
        return;
    }
}
