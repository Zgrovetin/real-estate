<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RealtorListingController extends Controller
{
//    public function __construct()
//    {
//        $this->authorizeResource(Listing::class, 'listing');
//    }
    public function index(Request $request)
    {
        Gate::authorize(
          'viewAny', Listing::class
        );
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        return Inertia::render('Realtor/Index',
            [
                'filters' => $filters,
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

    public function show(Listing $listing): Response
    {
        return Inertia::render('Realtor/Show',
            [
                'listing' => $listing->load(
                    'offers', 'offers.bidder'
                )
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        Gate::authorize(
            'create', Listing::class
        );
        return Inertia::render('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize(
            'create', Listing::class
        );
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

        return redirect()->route('realtor.listing.index')->with('success', 'Listing has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize(
            'update', $listing
        );
        return Inertia::render(
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
        Gate::authorize(
            'update', $listing
        );
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

        return redirect()->route('realtor.listing.index')->with('success', 'Listing has been changed.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize(
            'delete', $listing
        );
        $listing->deleteOrFail();

        return redirect()->back()->with('success', 'Listing has been deleted.');
    }

    public function restore(Listing $listing)
    {
        Gate::authorize(
            'restore', $listing
        );
        $listing->restore();
        return redirect()->back()->with('success', 'Listing has been restored.');
    }
}
