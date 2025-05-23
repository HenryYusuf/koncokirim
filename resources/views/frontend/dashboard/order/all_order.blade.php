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
                                <h4 class="font-weight-bold mt-0 mb-4">All Order</h4>

                                <div class="bg-white card mb-4 order-list shadow-sm">
                                    <div class="gold-members p-4">
                                        <div class="table-responsive">
                                            <table class="table table-bordered dt-responsive nowrap w-100">
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
                                                    @foreach ($allUserOrder as $key => $item)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $item->order_date }}</td>
                                                            <td>{{ $item->invoice_no }}</td>
                                                            <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                                                            <td>{{ $item->payment_method }}</td>
                                                            <td>
                                                                @if ($item->status == 'Pending')
                                                                    <span class="badge bg-info text-white">Pending</span>
                                                                @elseif ($item->status == 'Confirm')
                                                                    <span class="badge bg-primary text-white">Confirm</span>
                                                                @elseif ($item->status == 'Processing')
                                                                    <span class="badge bg-warning text-white">Processing</span>
                                                                @elseif ($item->status == 'Delivered')
                                                                    <span class="badge bg-success text-white">Delivered</span>
                                                                @elseif ($item->status == 'Canceled')
                                                                    <span class="badge bg-danger text-white">Canceled</span>
                                                                @endif
                                                            </td>
                                                            <td class="d-flex">
                                                                <a href="{{ route('admin.order.details', $item->id) }}"
                                                                    class="mx-2 text-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('admin.order.details', $item->id) }}"
                                                                    class="mx-2 text-black">
                                                                    <i class="fas fa-download"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
