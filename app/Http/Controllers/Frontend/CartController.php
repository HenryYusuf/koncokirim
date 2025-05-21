<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart($id)
    {
        $product = Product::find($id);

        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $priceToShow = isset($product->discount_price) ? $product->discount_price : $product->price;
            $cart[$id] = [
                'id' => $id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $priceToShow,
                'restaurant_id' => $product->restaurant_id,
                'quantity' => 1
            ];
        }

        Session::put('cart', $cart);

        // return response()->json($cart);

        $notifiaction = array(
            'message' => 'Add to Cart Successful',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notifiaction);
    }

    public function cartUpdateQuantity(Request $request) {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }

        return response()->json([
            'message' => 'Quantity Updated Successful',
            'alert-type' => 'success'
        ]);
    }

    public function cartDelete(Request $request)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'message' => 'Product Deleted Successful',
            'alert-type' => 'success'
        ]);
    }
}
