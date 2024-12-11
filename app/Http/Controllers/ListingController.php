<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingController extends Controller
{
    use AuthorizesRequests;
    public function __construct() {
        $this->authorizeResource(Listing::class, 'listing');
//        Gate::authorize('update', $listing);
    }
    /**
     * Alternative to specifying middleware in the file with routes!
     */
//    public function __construct() {
//        $this->middleware('auth')->except(['index', 'show']);
//    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filters = request()->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->Paginate(10)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
//        if (Auth::user()->cannot('view', $listing)) {
//            abort(403);
//        }
//        $this->authorize('view', $listing);

        $listing->load(['images']);
        $offer = !Auth::user() ?
            null : $listing->offers()->byMe()->first();

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }

}
