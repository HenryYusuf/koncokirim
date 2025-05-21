@extends('frontend.dashboard.dashboard')
@section('user')
    <style>
        .fixed-size-img {
            width: 300px;
            height: 200px;
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

    <section class="section pt-4 pb-4 osahan-account-page">
        <div class="container">
            <div class="row">

                @include('frontend.dashboard.sidebar')

                <div class="col-md-9">
                    <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">

                        <div class="tab-pane" id="favourites" role="tabpanel" aria-labelledby="favourites-tab">
                            <h4 class="font-weight-bold mt-0 mb-4">Favourites</h4>
                            <div class="row">

                                @foreach ($wishlists as $wishlist)
                                    <div class="col-md-4 col-sm-6 mb-4 pb-2">
                                        <div
                                            class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                            <div class="list-card-image">
                                                <a href="{{ route('user.restaurant.details', $wishlist->restaurant_id) }}">
                                                    <img src="{{ asset($wishlist->restaurant->photo !== null ? 'upload/restaurant_images/' . $wishlist->restaurant->photo : 'upload/no_image.jpg') }}"
                                                        class="img-fluid item-img fixed-size-img">
                                                </a>
                                            </div>
                                            <div class="p-3 position-relative">
                                                <div class="list-card-body">
                                                    <h6 class="mb-1"><a
                                                            href="{{ route('user.restaurant.details', $wishlist->restaurant_id) }}"
                                                            class="text-black">{{ $wishlist->restaurant->name }}
                                                        </a>
                                                    </h6>
                                                    <div style="float: right; margin-bottom: 5px;">
                                                        <a href="{{ route('user.remove.wishlist', $wishlist->id) }}"
                                                            class="badge badge-danger">
                                                            <i class="icofont-ui-delete"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection