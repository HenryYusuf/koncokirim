<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;

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
}
