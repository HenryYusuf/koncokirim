@extends('restaurant.restaurant_dashboard')
@section('restaurant')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Product</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                                <li class="breadcrumb-item active">Edit Product</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12 col-lg-12">

                    <div class="card">
                        <div class="card-body p-4">
                            <form id="myForm" action="{{ route('restaurant.product.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                            <input type="hidden" name="id" value="{{ $product->id }}">

                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Category Name</label>
                                            <select class="form-select" name="category_id">
                                                <option selected disabled>Select</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Menu Name</label>
                                            <select class="form-select" name="menu_id">
                                                <option selected disabled>Select</option>
                                                @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}" {{ $menu->id == $product->menu_id ? 'selected' : '' }}>{{$menu->menu_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">City Name</label>
                                            <select class="form-select" name="city_id">
                                                <option selected disabled>Select</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id == $product->city_id ? 'selected' : '' }}>{{$city->city_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Product Name</label>
                                            <input class="form-control" type="text" name="name" id="example-text-input"
                                                value="{{ $product->name }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Price</label>
                                            <input class="form-control" type="text" name="price" id="example-text-input"
                                                value="{{ $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Discount Price</label>
                                            <input class="form-control" type="text" name="discount_price"
                                                id="example-text-input" value="{{ $product->discount_price }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Size</label>
                                            <input class="form-control" type="text" name="size" id="example-text-input"
                                                value="{{ $product->size }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Product Quantity</label>
                                            <input class="form-control" type="text" name="quantity" id="example-text-input"
                                                value="{{ $product->quantity }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="example-text-input" class="form-label">Product Image (508x320 pixels)</label>
                                            <input class="form-control" name="image" type="file" id="image" accept="image/jpg, image/png, image/jpeg, image/webp"
                                                onchange="validateImageSize()">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="mb-3">
                                                <img id="showImage" src="{{ asset($product->image) }}" alt=""
                                                    class="rounded-circle p-1 bg-primary" width="110">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="best_seller" value="1"
                                                id="formCheck1" {{ $product->best_seller == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="formCheck1">Best Seller</label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="most_popular" value="1"
                                                id="formCheck2" {{ $product->most_popular == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="formCheck2">Most Popular</label>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <script>
        function validateImageSize() {
            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];

            if (file) {
                var maxSizeMB = 1; // batas ukuran dalam MB
                var maxSizeBytes = maxSizeMB * 1024 * 1024; // konversi ke bytes

                if (file.size > maxSizeBytes) {
                    alert("Ukuran gambar terlalu besar! Maksimal " + maxSizeMB + " MB.");
                    fileInput.value = ""; // Reset input
                }
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#image').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0'])
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#myForm').validate({
                rules: {
                    category_id: {
                        required: true,
                    },
                    menu_id: {
                        required: true,
                    },
                    city_id: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },

                },
                messages: {
                    category_id: {
                        required: "Please Select One Category",
                    },
                    menu_id: {
                        required: "Please Select One Menu",
                    },
                    city_id: {
                        required: "Please Select One City",
                    },
                    name: {
                        required: 'Please Enter Product Name',
                    },


                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>
@endsection