<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
//use Request;

class RealtorListingController extends Controller
{

    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        //        dd($request->all('deleted'));
        //        dd(Auth::user()->listings);

        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];
//        dd($filters);

        return inertia('Realtor/Index',
            [   'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    //pagination
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()->with('success', 'Listing has been deleted.');
    }
}
