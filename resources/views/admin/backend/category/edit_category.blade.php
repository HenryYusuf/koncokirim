@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Category</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Category</a></li>
                                <li class="breadcrumb-item active">Edit Category</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-9 col-lg-8">

                    <div class="card">
                        <div class="card-body p-4">
                            <form id="myForm" action="{{ route('admin.category.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div>
                                            <div class="form-group mb-3">
                                                <label for="example-text-input" class="form-label">Category Name</label>
                                                <input class="form-control" type="text" name="category_name"
                                                    value="{{ $category->category_name }}" id="example-text-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="form-group mb-3">
                                                <label for="example-text-input" class="form-label">Category Image (300x300 pixels)</label>
                                                <input class="form-control" name="image" type="file" id="image"
                                                    accept="image/jpg, image/png, image/jpeg, image/webp"
                                                    onchange="validateImageSize()">
                                            </div>
                                            <div class="mb-3">
                                                <img id="showImage" src="{{ asset($category->image) }}" alt=""
                                                    class="rounded-circle p-1 bg-primary" width="110">
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect waves-light">Save</button>
                                            </div>
                                        </div>
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
        $(document).ready(function() {
            $('#image').change(function(e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0'])
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    category_name: {
                        required: true,
                    },

                },
                messages: {
                    category_name: {
                        required: 'Please Enter Category Name',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endsection
