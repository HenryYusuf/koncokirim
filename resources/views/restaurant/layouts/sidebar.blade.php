@php
    $id = Auth::guard('restaurant')->id();
    $restaurant = App\Models\Restaurant::find($id);
    $status = $restaurant->status;
@endphp

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('restaurant.dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                @if ($status == 1)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Menu</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('restaurant.all.menu') }}">
                                    <span data-key="t-calendar">All Menu</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('restaurant.add.menu') }}">
                                    <span data-key="t-chat">Add Menu</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Product</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('restaurant.all.product') }}">
                                    <span data-key="t-calendar">All Product</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('restaurant.add.product') }}">
                                    <span data-key="t-chat">Add Product</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Gallery</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('restaurant.all.gallery') }}">
                                    <span data-key="t-calendar">All Gallery</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('restaurant.add.gallery') }}">
                                    <span data-key="t-chat">Add Gallery</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Coupon</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('restaurant.all.coupon') }}">
                                    <span data-key="t-calendar">All Coupon</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('restaurant.add.coupon') }}">
                                    <span data-key="t-chat">Add Coupon</span>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Manage Orders</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('restaurant.all.orders') }}">
                                    <span data-key="t-calendar">All Orders</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @else
                @endif

            </ul>

            <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>