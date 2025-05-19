@extends('frontend.main')
@section('content')
    <style>
        .fixed-size-img {
            width: 500px;
            height: 320px;
            object-fit: cover;
        }

        @media (max-width: 576px) {
            .fixed-size-img {
                width: 500px;
                /* Full lebar kontainer */
                height: 320px;
                /* Tinggi menyesuaikan rasio gambar */
                object-fit: cover;
            }
        }
    </style>

    <section class="section pt-5 pb-5 products-section">
        <div class="container">
            <div class="section-header text-center">
                <h2>Popular Restaurants</h2>
                <p>Top restaurants, cafes, pubs, and bars in Munjungan, based on trends</p>
                <span class="line"></span>
            </div>
            <div class="row">

                @php
                    $restaurants = App\Models\Restaurant::where('status', 1)->latest()->get();
                @endphp

                @foreach ($restaurants as $key => $restaurant)

                    @php
                        $products = App\Models\Product::where('restaurant_id', $restaurant->id)->limit(3)->get();
                        $menuNames = $products->map(function ($product) {
                            return $product->menu->menu_name;
                        })->toArray();
                        $menuNamesString = implode(' | ', $menuNames);

                        $coupon = App\Models\Coupon::where('restaurant_id', $restaurant->id)->where('status', 1)->first();
                    @endphp

                    <div class="col-md-3">
                        <div class="item pb-3">
                            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                <div class="list-card-image">
                                    <div class="star position-absolute"><span class="badge badge-success"><i
                                                class="icofont-star"></i> 3.1 (300+)</span></div>
                                    <div class="favourite-heart text-danger position-absolute"><a href="detail.html"><i
                                                class="icofont-heart"></i></a></div>
                                    @if ($coupon)
                                        <div class="member-plan position-absolute">
                                            <span class="badge badge-dark">Promoted</span>
                                        </div>
                                    @else
                                    @endif
                                    <a href="detail.html">
                                        <img src="{{ asset($restaurant->photo !== null ? 'upload/restaurant_images/' . $restaurant->photo : 'upload/no_image.jpg') }}"
                                            class="img-fluid item-img fixed-size-img">
                                    </a>
                                </div>
                                <div class="p-3 position-relative">
                                    <div class="list-card-body">
                                        <h6 class="mb-1"><a href="detail.html" class="text-black">{{$restaurant->name}}</a></h6>
                                        <p class="text-gray mb-3">{{$menuNamesString}}</p>
                                        <p class="text-gray mb-3 time"><span
                                                class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i
                                                    class="icofont-wall-clock"></i> 20–25 min</span></p>
                                    </div>
                                    <div class="list-card-badge">
                                        @if ($coupon)
                                            <span class="badge badge-success">OFFER</span>
                                            <small>{{$coupon->discount}}% off | Use Coupon <b>{{$coupon->coupon_name}}</b></small>
                                        @else
                                            <span class="badge badge-success">OFFER</span>
                                            <small>Right Now There Have No Coupon</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection