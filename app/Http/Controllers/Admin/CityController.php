<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function adminAllCity()
    {
        $cities = City::latest()->get();
        return view('admin.backend.city.all_city', compact('cities'));
    }

    public function adminAddCityStore(Request $request)
    {
        City::create([
            'city_name' => $request->city_name,
            'city_slug' => strtolower((str_replace(' ', '-', $request->city_name)))
        ]);

        $notification = array(
            'message' => 'City Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.city')->with($notification);
    }

    public function adminEditCity(City $city)
    {
        return response()->json($city);
    }

    public function adminEditCityUpdate(Request $request)
    {
        $id = $request->id;

        City::find($id)->update([
            'city_name' => $request->city_name,
            'city_slug' => strtolower((str_replace(' ', '-', $request->city_name)))
        ]);

        $notification = array(
            'message' => 'City Updated Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.city')->with($notification);
    }

    public function adminDeleteCityUpdate(City $city)
    {
        $city->delete();

        $notification = array(
            'message' => 'City Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.city')->with($notification);
    }
}
