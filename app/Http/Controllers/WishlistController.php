<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function userAllWishlist()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->get();

        return view('frontend.dashboard.all_wishlist', compact('wishlists'));
    }

    public function userRemoveWishlist(Wishlist $wishlist)
    {
        $wishlist->delete();

        $notification = array(
            'message' => 'Wishlist Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
