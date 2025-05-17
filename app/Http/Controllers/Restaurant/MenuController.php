<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MenuController extends Controller
{
    public function restaurantAllMenu()
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $menus = Menu::where('restaurant_id', $restaurantId)->orderBy('menu_name', 'asc')->get();
        return view('restaurant.backend.menu.all_menu', compact('menus'));
    }

    public function restaurantAddMenu()
    {
        return view('restaurant.backend.menu.add_menu');
    }

    public function restaurantAddMenuStore(Request $request)
    {
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $nameGen));
            $saveUrl = 'upload/menu/' . $nameGen;

            Menu::create([
                'menu_name' => $request->menu_name,
                'image' => $saveUrl,
                'restaurant_id' => Auth::guard('restaurant')->id()
            ]);
        }

        $notification = array(
            'message' => 'Menu Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.menu')->with($notification);
    }

    public function restaurantEditMenu(Menu $menu)
    {
        return view('restaurant.backend.menu.edit_menu', compact('menu'));
    }

    public function restaurantEditMenuUpdate(Request $request)
    {
        $menuId = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $nameGen));
            $saveUrl = 'upload/menu/' . $nameGen;

            Menu::find($menuId)->update([
                'menu_name' => $request->menu_name,
                'image' => $saveUrl
            ]);

            $notification = array(
                'message' => 'Menu Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('restaurant.all.menu')->with($notification);
        } else {
            Menu::find($menuId)->update([
                'menu_name' => $request->menu_name,
            ]);

            $notification = array(
                'message' => 'Menu Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('restaurant.all.menu')->with($notification);
        }
    }

    public function restaurantDeleteMenu(Menu $menu)
    {
        $fullPath = public_path($menu->image);
        if(file_exists($fullPath))
        {
            unlink($fullPath);
        }

        $menu->delete();

        $notification = array(
            'message' => 'Menu Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('restaurant.all.menu')->with($notification);
    }
}
