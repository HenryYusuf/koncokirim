<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function restaurantDetails(Restaurant $restaurant)
    {
        $menus = Menu::where('restaurant_id', $restaurant->id)->get()->filter(function ($menus) {
            return $menus->products->isNotEmpty();
        });

        $galleries = Gallery::where('restaurant_id', $restaurant->id)->get();

        return view('frontend.details_page', compact('restaurant', 'menus', 'galleries'));
    }

    public function addWishList(Request $request, $id)
    {
        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('restaurant_id', $id)->first();

            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'restaurant_id' => $id,
                    'created_at' => Carbon::now()
                ]);

                return response()->json(['success' => 'Your Wishlist Added Succesful']);
            } else {
                return response()->json(['error' => 'This Restaurant/Product has already on your wishlist']);
            }

        } else {
            return response()->json(['error' => 'First Login Your Account']);
        }
    }
}
