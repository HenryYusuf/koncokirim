<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .font {
            font-size: 15px;
        }

        .authority {
            /*text-align: center;*/
            float: right
        }

        .authority h5 {
            margin-top: -10px;
            color: green;
            /*text-align: center;*/
            margin-left: 35px;
        }

        .thanks p {
            color: green;
            ;
            font-size: 16px;
            font-weight: normal;
            font-family: serif;
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
        <tr>
            <td valign="top">
                <!-- {{-- <img src="" alt="" width="150"/> --}} -->
                <h2 style="color: green; font-size: 26px;"><strong>KoncoKirim</strong></h2>
            </td>
            <td align="right">
                <pre class="font">
               KoncoKirim
               Email:baharhenry10@gmail.com
               Phone Number: +6282244859815
               Singgihan, Masaran
            </pre>
            </td>
        </tr>

    </table>


    <table width="100%" style="background:white; padding:2px;"></table>

    <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
        <tr>
            <td>
                <p class="font" style="margin-left: 20px;">
                    <strong>Name:</strong> {{ $order->name }} <br>
                    <strong>Email:</strong> {{ $order->email }} <br>
                    <strong>Phone:</strong> {{ $order->phone }} <br>
                    <strong>Address:</strong> {{ $order->address }} <br>
                </p>
            </td>
            <td align="right">
                <p class="font">
                <h3 style="margin-top: 0;">
                    <span style="color: green;">Invoice:</span> #{{ $order->invoice_no }}
                </h3>
                Order Date: {{ $order->order_date }} <br>
                Delivery Date: {{ Carbon\Carbon::parse($order->delivered_date)->format('d-m-Y H:i:s', ) }} <br>
                Payment Type : {{ $order->payment_method }} </span>
                </p>
            </td>
        </tr>
    </table>
    <br />
    <h3>Products</h3>


    <table width="100%">
        <thead style="background-color: green; color:#FFFFFF;">
            <tr class="font">
                <th>Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Code</th>
                <th>Quantity</th>
                <th>Restaurant Name</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orderItem as $item)
                <tr class="font">
                    <td align="center">
                        <img src="{{ public_path($item->product->image) }}" height="60px;" width="60px;"
                            alt="">
                    </td>
                    <td align="center">{{ $item->product->name }}</td>
                    <td align="center">{{ $item->product->size }}</td>
                    <td align="center">{{ $item->product->code }}</td>
                    <td align="center">{{ $item->quantity }}</td>
                    <td align="center">{{ $item->product->restaurant->name }}</td>
                    <td align="center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <br>
    <table style="margin-left: auto; margin-right: 0; padding: 0 10px;">
        <tr>
            <td align="right">
                <h2>
                    <span style="color: green;">Subtotal:</span>
                </h2>
            </td>
            <td align="right">
                <h2>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h2>
            </td>
        </tr>
        <tr>
            <td align="right">
                <h2>
                    <span style="color: green;">Discount:</span>
                </h2>
            </td>
            <td align="right">
                <h2 style="color: #17A2B8">Discount May Applied</h2>
            </td>
        </tr>
        <tr>
            <td align="right">
                <h2>
                    <span style="color: green;">Service Fee:</span>
                </h2>
            </td>
            <td align="right">
                <h2>Rp {{ number_format($serviceFee, 0, ',', '.') }}</h2>
            </td>
        </tr>
        <tr>
            <td align="right">
                <h2>
                    <span style="color: green;">Total:</span>
                </h2>
            </td>
            <td align="right">
                <h2>Rp {{ number_format($totalPayment, 0, ',', '.') }}</h2>
            </td>
        </tr>
    </table>
    {{-- <tr>
        <td align="right">
            <h2><span style="color: green;">Subtotal:</span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</h2>
            <h2><span style="color: green;">Discount:</span>Discount May Applied</h2>
            <h2><span style="color: green;">Service Fee:</span>Rp {{ number_format($serviceFee, 0, ',', '.') }}
            </h2>
            <h2><span style="color: green;">Total:</span>Rp {{ number_format($totalPayment, 0, ',', '.') }}</h2>
        </td>
    </tr> --}}
    <div class="thanks mt-3">
        <p>Thanks For Buying Products..!!</p>
    </div>
    <div class="authority float-right mt-5">
        <p>Trenggalek, {{ Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <h5>Authority Signature:</h5>
        <img src="{{ public_path('frontend/img/signature.png') }}" style="margin-left: 20px;" width="150" height="auto">
    </div>
</body>

</html>
