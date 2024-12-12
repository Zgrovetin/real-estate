<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RealtorListingAcceptOfferController extends Controller
{
    use AuthorizesRequests;
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);

        // Accept selected offer
        $offer->update(['accepted_at' => now()]);

        // Mark listing as sold out
        $listing->sold_at = now();
        $listing->save();

        // Reject all other offers
        $listing->offers()->except($offer)
        ->update(['rejected_at' => now()]);

        return redirect()->back()
            ->with('success', "Offer #{$offer->id} accepted, all others - rejected");

    }
}
