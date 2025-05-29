@extends('restaurant.restaurant_dashboard')
@section('restaurant')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">All Product</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <a href="{{ route('restaurant.add.product') }}"
                                    class="btn btn-primary waves-effect waves-light">Add
                                    Product</a>
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
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Menu</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Discount</th>
                                            <th>Status</th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->menu->menu_name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    @if ($item->discount_price == NULL)
                                                        <span class="badge bg-danger">No Discount</span>
                                                    @else
                                                        @php
                                                            $amount = $item->price - $item->discount_price;
                                                            $discount = ($amount / $item->price) * 100;
                                                        @endphp
                                                        <span class="badge bg-success">{{ round($discount) }}%</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span id="status-text-{{ $item->id }}">
                                                        @if ($item->status == 1)
                                                            <span class="text-success"><b>Active</b></span>
                                                        @else
                                                            <span class="text-danger"><b>Inactive</b></span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('restaurant.edit.product', $item->id) }}"
                                                        class="btn btn-info waves-effect waves-light">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('restaurant.delete.product', $item->id) }}"
                                                        class="btn btn-danger waves-effect waves-light" id="delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <input data-id="{{ $item->id }}" class="toggle-class" type="checkbox"
                                                        data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                        data-on="Active" data-off="Inactive" {{ $item->status ? 'checked' : '' }}>
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

    <script type="text/javascript">
        $(function () {
            $('.toggle-class').change(function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var productId = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/restaurant/change-status-product',
                    data: { 'status': status, 'product_id': productId },
                    success: function (data) {
                        // console.log(data.success)

                        // Start Message 

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        if ($.isEmptyObject(data.error)) {

                            Toast.fire({
                                type: 'success',
                                title: data.success,
                            })

                        } else {

                            Toast.fire({
                                type: 'error',
                                title: data.error,
                            })
                        }

                        let statusHtml = '';
                        if (status === 1) {
                            statusHtml = '<span class="text-success"><b>Active</b></span>';
                        } else {
                            statusHtml = '<span class="text-danger"><b>Inactive</b></span>';
                        }
                        $('#status-text-' + productId).html(statusHtml);
                        // End Message   


                    }
                });
            })
        })
    </script>

@endsection