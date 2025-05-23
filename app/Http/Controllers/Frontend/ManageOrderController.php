<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    public function userAllOrders()
    {
        $userId = Auth::user()->id;

        $allUserOrder = Order::where('user_id', $userId)->orderBy('id', 'asc')->get();

        return view('frontend.dashboard.order.all_order', compact('allUserOrder'));
    }
}
