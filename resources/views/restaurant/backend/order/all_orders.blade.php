@extends('restaurant.restaurant_dashboard')
@section('restaurant')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">All Orders</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">

                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Invoice</th>
                                            <th>Amount</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItemGroupData as $key => $orderItem)
                                            @php
                                                $firstItem = $orderItem->first();
                                                $order = $firstItem->order;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->order_date }}</td>
                                                <td>{{ $order->invoice_no }}</td>
                                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                                <td>{{ $order->payment_method }}</td>
                                                <td>
                                                    @if ($order->status == 'Pending')
                                                        <span class="badge bg-info">Pending</span>
                                                    @elseif ($order->status == 'Confirm')
                                                        <span class="badge bg-primary">Confirm</span>
                                                    @elseif ($order->status == 'Processing')
                                                        <span class="badge bg-warning">Processing</span>
                                                    @elseif ($order->status == 'Delivered')
                                                        <span class="badge bg-success">Delivered</span>
                                                    @elseif ($order->status == 'Canceled')
                                                        <span class="badge bg-danger">Canceled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('restaurant.order.details', $order->id) }}"
                                                        class="btn btn-info waves-effect waves-light">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


        </div> <!-- container-fluid -->
    </div>
@endsection
