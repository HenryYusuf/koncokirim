<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Restaurant;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ManageController extends Controller
{
    public function adminAllProduct()
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('admin.backend.product.all_product', compact('products'));
    }

    public function adminAddProduct()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        $cities = City::orderBy('city_name', 'asc')->get();
        $menus = Menu::orderBy('menu_name', 'asc')->get();
        $restaurants = Restaurant::orderBy('name', 'asc')->get();

        return view('admin.backend.product.add_product', compact('categories', 'cities', 'menus', 'restaurants'));
    }

    public function adminAddProductStore(Request $request)
    {
        $pCode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 10, 'prefix' => 'PC-']);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $nameGen));
            $saveUrl = 'upload/product/' . $nameGen;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'code' => $pCode,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'image' => $saveUrl,
                'restaurant_id' => $request->restaurant_id,
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product Inserted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.product')->with($notification);
    }

    public function adminEditProduct(Product $product)
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        $cities = City::orderBy('city_name', 'asc')->get();
        $menus = Menu::orderBy('menu_name', 'asc')->get();
        $restaurants = Restaurant::orderBy('name', 'asc')->get();

        return view('admin.backend.product.edit_product', compact('categories', 'cities', 'menus', 'product', 'restaurants'));
    }

    public function adminEditProductUpdate(Request $request)
    {
        $productId = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $nameGen));
            $saveUrl = 'upload/product/' . $nameGen;

            Product::find($productId)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'image' => $saveUrl,
                'restaurant_id' => $request->restaurant_id,
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.product')->with($notification);
        } else {
            Product::find($productId)->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'restaurant_id' => $request->restaurant_id,
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.all.product')->with($notification);
        }
    }

    public function adminDeleteProduct(Product $product)
    {
        $fullPath = public_path($product->image);
        if(file_exists($fullPath))
        {
            unlink($fullPath);
        }

        $product->delete();

        $notification = array(
            'message' => 'Product Deleted Successful',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.all.product')->with($notification);
    }

    public function adminChangeStatusProduct(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => 'Status Change Successful']);
    }

    public function adminAllPendingRestaurant()
    {
        $restaurants = Restaurant::where('status', 0)->get();

        return view('admin.backend.restaurant.pending_restaurant', compact('restaurants'));
    }

    public function adminAllApproveRestaurant()
    {
        $restaurants = Restaurant::where('status', 1)->get();

        return view('admin.backend.restaurant.approve_restaurant', compact('restaurants'));
    }

    public function adminChangeStatusRestaurant(Request $request)
    {
        $restaurant = Restaurant::find($request->restaurant_id);
        $restaurant->status = $request->status;
        $restaurant->save();

        return response()->json(['success' => 'Status Change Successful']);
    }
}
