<?php

namespace App\Http\Controllers;

// Alternative to using Tinker
//use App\Models\Listing;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        
// Alternative to using Tinker
//        dd(Listing::where('beds', '=', 4)->orderBy('price', 'asc')->first());

        return inertia(
            'Index/Index',
            [
                'message' => 'Hello from Laravel!'
            ]
        );
    }

    public function show() {
        return inertia('Index/Show');
    }
}
