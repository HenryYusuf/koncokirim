<nav class="navbar navbar-expand-lg navbar-dark osahan-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}"><img alt="logo"
                src="{{ asset('frontend/img/favicon.png') }}" width="125px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('index') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="offers.html"><i class="icofont-sale-discount"></i> Offers <span
                            class="badge badge-warning">New</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        Restaurants
                    </a>
                </li> --}}

                @auth
                    @php
                        $id = Auth::user()->id;
                        $profileData = App\Models\User::find($id);
                    @endphp

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img alt="Generic placeholder image"
                                src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                class="nav-osahan-pic rounded-pill">
                            My Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                            <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="icofont-home"></i>
                                Dashboard</a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i class="icofont-logout"></i>
                                Logout</a>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            Register
                        </a>
                    </li>
                @endauth

                @php
                    $total = 0;
                    $carts = Session::get('cart', []);
                    $groupedCart = [];

                    foreach ($carts as $key => $cart) {
                        $groupedCart[$cart['restaurant_id']][] = $cart;
                    }

                    $restaurants = App\Models\Restaurant::whereIn('id', array_keys($groupedCart))->get()->keyBy('id');
                @endphp

                <li class="nav-item dropdown dropdown-cart">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-basket"></i> Cart
                        <span class="badge badge-success">{{ count((array) Session::get('cart')) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">
                        @foreach ($groupedCart as $restaurantId => $items)
                            @if (isset($restaurants[$restaurantId]))
                                @php
                                    $restaurant = $restaurants[$restaurantId];
                                @endphp
                                <div class="dropdown-cart-top-header p-4">
                                    <img class="img-fluid mr-3" alt="osahan"
                                        src="{{ asset($restaurant->photo !== null ? 'upload/restaurant_images/' . $restaurant->photo : 'upload/no_image.jpg') }}">
                                    <h6 class="mb-0">{{ $restaurant->name }}</h6>
                                    <p class="text-secondary mb-0">{{ $restaurant->address }}</p>
                                    <small><a class="text-primary font-weight-bold"
                                            href="{{ route('user.restaurant.details', $restaurant->id) }}">View Full
                                            Menu</a></small>
                                </div>
                            @endif
                        @endforeach
                        <div class="dropdown-cart-top-body border-top p-4">

                            @php
                                $total = 0;
                            @endphp

                            @if (Session::get('cart'))
                                @foreach (Session::get('cart') as $id => $details)
                                    @php
                                        $total += $details['price'] * $details['quantity'];
                                    @endphp
                                    <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i>
                                        {{ $details['name'] }} x {{ $details['quantity'] }}
                                        <span
                                            class="float-right text-secondary">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                    </p>
                                @endforeach
                            @endif

                        </div>
                        <div class="dropdown-cart-top-footer border-top p-4">
                            <p class="mb-0 font-weight-bold text-secondary">Sub Total <span
                                    class="float-right text-dark">
                                    @if (Session::has('coupon'))
                                        Rp {{ number_format(Session::get('coupon')['discount_amount'], 0, ',', '.') }}
                                    @else
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    @endif
                                </span></p>
                            <small class="text-info">Extra charges may apply</small>
                        </div>
                        <div class="dropdown-cart-top-footer border-top p-2">
                            <a class="btn btn-success btn-block btn-lg" href="{{ route('user.checkout') }}"> Checkout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
