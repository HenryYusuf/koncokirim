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
                        <h4 class="mb-sm-0 font-size-18">Add Gallery</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Gallery</a></li>
                                <li class="breadcrumb-item active">Add Gallery</li>
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
                            <form id="myForm" action="{{ route('restaurant.gallery.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mt-3 mt-lg-0">

                                            <div class="form-group mb-3">
                                                <label for="example-text-input" class="form-label">Gallery Image (800x800 pixels)</label>
                                                <input class="form-control" name="gallery_image[]" type="file"
                                                    id="multiImg" accept="image/jpg, image/png, image/jpeg, image/webp"
                                                    onchange="validateImageSize()" multiple>
                                                <div class="mt-2 row" id="preview_img"></div>
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
            var fileInput = document.getElementById('multiImg');
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
            $('#multiImg').on('change', function() { //on file input change
                if (window.File && window.FileReader && window.FileList && window
                    .Blob) //check File API supported browser
                {
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file) { //loop though each file
                        if (/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file
                                .type)) { //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file) { //trigger function on successful read
                                return function(e) {
                                    var img = $('<img/>').addClass('thumb').attr('src',
                                            e.target.result).width(100)
                                        .height(80); //create image element 
                                    $('#preview_img').append(
                                        img); //append image to output element
                                };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });

                } else {
                    alert("Your browser doesn't support File API!"); //if File API is absent
                }
            });
        });
    </script>
@endsection
