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

        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return inertia('Realtor/Index',
            [   'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    ->filter($filters)
                    ->withCount('images')
                    ->withCount('offers')
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }

    public function show(Listing $listing)
    {
        return inertia('Realtor/Show',
            ['listing' => $listing->load('offers', 'offers.bidder')]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $this->authorize('create', Listing::class);

        return inertia('Realtor/Create');
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

        return to_route('realtor.listing.index')->with('success', 'Listing has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia(
            'Realtor/Edit',
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

        return to_route('realtor.listing.index')->with('success', 'Listing has been changed.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()->with('success', 'Listing has been deleted.');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();
        return redirect()->back()->with('success', 'Listing has been restored.');
    }
}
