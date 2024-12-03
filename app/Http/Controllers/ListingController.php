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

        $query = Listing::orderByDesc('created_at');

        if ($filters['priceFrom'] ?? false) {
            $query->where('price', '>=', $filters['priceFrom']);
        }
        if ($filters['priceTo'] ?? false) {
            $query->where('price', '<=', $filters['priceTo']);
        }
        if ($filters['beds'] ?? false) {
            $query->where('beds', $filters['beds']);
        }
        if ($filters['baths'] ?? false) {
            $query->where('baths', $filters['baths']);
        }
        if ($filters['areaFrom'] ?? false) {
            $query->where('area', '>=', $filters['areaFrom']);
        }
        if ($filters['areaTo'] ?? false) {
            $query->where('area', '<=', $filters['areaTo']);
        }

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => $query
                    ->Paginate(10)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->authorize('create', Listing::class);

        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->listings()->create(
            $request->validate([
            'beds' => 'required|integer|min:1|max:20',
            'baths' => 'required|integer|min:1|max:20',
            'area' => 'required|integer|min:15|max:1500',
            'city' => 'required',
            'code' => 'required',
            'street' => 'required',
            'street_nr' => 'required|integer|min:1|max:1000',
            'price' => 'required|integer|min:1|max:20000000'
                ])
        );

        return to_route('listing.index')->with('success', 'Listing has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
//        if (Auth::user()->cannot('view', $listing)) {
//            abort(403);
//        }

        $this->authorize('view', $listing);


        return inertia(
            'Listing/Show',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia(
            'Listing/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {

        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|integer|min:1|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000'
            ])
        );

        return to_route('listing.index')->with('success', 'Listing has been changed.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->back()->with('success', 'Listing has been deleted.');
    }
}
