@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Order Details</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">
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
                                <span class="text-primary">Invoice: {{ $order->invoice_no }}</span>
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
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th width="50%">Order Status: </th>
                                            <td>
                                                <span class="badge bg-info">{{ $order->status }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="50%"></th>
                                            <td>
                                                @if ($order->status == 'Pending')
                                                    <a href="{{ route('admin.order.pending_to_confirm', $order->id) }}"
                                                        class="btn btn-block btn-success" id="confirmOrder">Confirm
                                                        Order</a>
                                                    <a href="{{ route('admin.order.cancel', $order->id) }}" class="btn btn-block btn-danger" id="cancelOrder">Cancel Order</a>
                                                @elseif ($order->status == 'Confirm')
                                                    <a href="{{ route('admin.order.confirm_to_processing', $order->id) }}" class="btn btn-block btn-success" id="processingOrder">Processing Order</a>
                                                    <a href="{{ route('admin.order.cancel', $order->id) }}" class="btn btn-block btn-danger" id="cancelOrder">Cancel Order</a>
                                                @elseif ($order->status == 'Processing')
                                                    <a href="{{ route('admin.order.processing_to_delivered', $order->id) }}" class="btn btn-block btn-success" id="deliveredOrder">Delivered Order</a>
                                                    <a href="{{ route('admin.order.cancel', $order->id) }}" class="btn btn-block btn-danger" id="cancelOrder">Cancel Order</a>
                                                @endif
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
                                                    Rp {{ number_format($item->price, 0, ',', '.') }} <br> Total = Rp
                                                    {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mx-2">
                                <h4>Total Price: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
