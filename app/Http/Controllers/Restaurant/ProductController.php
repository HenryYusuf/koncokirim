<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function restaurantAllProduct()
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $products = Product::where('restaurant_id', $restaurantId)->orderBy('name', 'asc')->get();
        return view('restaurant.backend.product.all_product', compact('products'));
    }

    public function restaurantAddProduct()
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $categories = Category::orderBy('category_name', 'asc')->get();
        $cities = City::orderBy('city_name', 'asc')->get();
        $menus = Menu::where('restaurant_id', $restaurantId)->orderBy('menu_name', 'asc')->get();

        return view('restaurant.backend.product.add_product', compact('categories', 'cities', 'menus'));
    }

    public function restaurantAddProductStore(Request $request)
    {
        $pCode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 10, 'prefix' => 'PC-']);

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(508, 320)->save(public_path('upload/product/' . $nameGen));
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
                'restaurant_id' => Auth::guard('restaurant')->id(),
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

        return redirect()->route('restaurant.all.product')->with($notification);
    }

    public function restaurantEditProduct(Product $product)
    {
        $restaurantId = Auth::guard('restaurant')->id();
        $categories = Category::orderBy('category_name', 'asc')->get();
        $cities = City::orderBy('city_name', 'asc')->get();
        $menus = Menu::where('restaurant_id', $restaurantId)->orderBy('menu_name', 'asc')->get();

        return view('restaurant.backend.product.edit_product', compact('categories', 'cities', 'menus', 'product'));
    }

    public function restaurantEditProductUpdate(Request $request)
    {
        $productId = $request->id;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $nameGen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(508, 320)->save(public_path('upload/product/' . $nameGen));
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
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('restaurant.all.product')->with($notification);
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
                'most_popular' => $request->most_popular,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Product Updated Successful',
                'alert-type' => 'success'
            );

            return redirect()->route('restaurant.all.product')->with($notification);
        }
    }

    public function restaurantDeleteProduct(Product $product)
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

        return redirect()->route('restaurant.all.product')->with($notification);
    }

    public function restaurantChangeStatusProduct(Request $request)
    {
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => 'Status Change Successful']);
    }
}
