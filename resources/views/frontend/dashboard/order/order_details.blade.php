@extends('frontend.dashboard.dashboard')
@section('user')
    @php
        $id = Auth::user()->id;
        $profileData = App\Models\User::find($id);
    @endphp

    <section class="section pt-4 pb-4 osahan-account-page">
        <div class="container">
            <div class="row">

                @include('frontend.dashboard.sidebar')

                <div class="col-md-9">
                    <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <h4 class="font-weight-bold mt-0 mb-4">Order Details</h4>

                                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2 mb-4">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Shipping Details</h4>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered border-primary mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th width="50%">Shipping Name: </th>
                                                                <td>{{ $order->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Shipping Phone: </th>
                                                                <td>{{ $order->phone }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Shipping Email: </th>
                                                                <td>{{ $order->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Shipping Address: </th>
                                                                <td>{{ $order->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Order Date: </th>
                                                                <td>{{ $order->order_date }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Order Details |
                                                    <span class="text-primary">Invoice:
                                                        {{ $order->invoice_no }}</span>
                                                </h4>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered border-primary mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th width="50%"> Name: </th>
                                                                <td>{{ $order->user->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%"> Phone: </th>
                                                                <td>{{ $order->user->phone }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%"> Email: </th>
                                                                <td>{{ $order->user->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Payment Method: </th>
                                                                <td>{{ $order->payment_method }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Transaction Id: </th>
                                                                <td>{{ $order->transaction_id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Invoice: </th>
                                                                <td>{{ $order->invoice_no }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Order Amount: </th>
                                                                <td>Rp
                                                                    {{ number_format($order->amount, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Service Fee: </th>
                                                                <td>Rp {{ number_format(2000, 0, ',', '.') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Discount: </th>
                                                                <td><span class="text text-info fw-bold">Discount
                                                                        may applied</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Total: </th>
                                                                <td>Rp
                                                                    {{ number_format($order->total_amount, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">Order Status: </th>
                                                                <td>
                                                                    <span class="badge bg-info">{{ $order->status }}</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row row-cols-1 row-cols-md-1 row-cols-lg row-cols-xl">
                                    <div class="col">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="col-md-1">
                                                                <label>Image</label>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <label>Product Name</label>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <label>Restaurant Name</label>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <label>Product Code</label>
                                                            </td>
                                                            <td class="col-md-1">
                                                                <label>Quantity</label>
                                                            </td>
                                                            <td class="col-md-3">
                                                                <label>Price</label>
                                                            </td>
                                                        </tr>
                                                        @foreach ($orderItem as $item)
                                                            <tr>
                                                                <td class="col-md-1">
                                                                    <label>
                                                                        <img src="{{ asset($item->product->image) }}"
                                                                            alt="{{ $item->product->name }}"
                                                                            style="width: 50px; height: 50px;">
                                                                    </label>
                                                                </td>
                                                                <td class="col-md-2">
                                                                    <label>
                                                                        {{ $item->product->name }}
                                                                    </label>
                                                                </td>
                                                                @if ($item->restaurant_id == null)
                                                                    <td class="col-md-2">
                                                                        <label>
                                                                            Owner
                                                                        </label>
                                                                    </td>
                                                                @else
                                                                    <td class="col-md-2">
                                                                        <label>
                                                                            {{ $item->product->restaurant->name }}
                                                                        </label>
                                                                    </td>
                                                                @endif
                                                                <td class="col-md-2">
                                                                    <label>
                                                                        {{ $item->product->code }}
                                                                    </label>
                                                                </td>
                                                                <td class="col-md-1">
                                                                    <label>
                                                                        {{ $item->quantity }}
                                                                    </label>
                                                                </td>
                                                                <td class="col-md-2">
                                                                    <label>
                                                                        Rp
                                                                        {{ number_format($item->price, 0, ',', '.') }}
                                                                        <br> Total = Rp
                                                                        {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <hr>
                                                <div class="mx-2 float-right">
                                                    <h4>Total Price: Rp
                                                        {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
