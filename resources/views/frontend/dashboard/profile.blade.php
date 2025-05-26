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
                                <h4 class="font-weight-bold mt-0 mb-4">User Profile</h4>

                                <div class="bg-white card mb-4 order-list shadow-sm">
                                    <div class="gold-members p-4">
                                        <form action="{{ route('profile.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Name</label>
                                                            <input class="form-control" type="text" name="name"
                                                                value="{{ $profileData->name }}" id="example-text-input">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Email</label>
                                                            <input class="form-control" type="email" name="email"
                                                                value="{{ $profileData->email }}" id="example-text-input">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Phone</label>
                                                            <input class="form-control" type="text" name="phone"
                                                                value="{{ $profileData->phone }}" id="example-text-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mt-3 mt-lg-0">
                                                        <div class="mb-3">
                                                            <label for="example-text-input"
                                                                class="form-label">Address</label>
                                                            <input class="form-control" name="address" type="text"
                                                                value="{{ $profileData->address }}" id="example-text-input">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Profile
                                                                Image (300x300 pixels)</label>
                                                            <input class="form-control" name="photo" type="file"
                                                                id="image"
                                                                accept="image/jpg, image/png, image/jpeg, image/webp"
                                                                onchange="validateImageSize()">
                                                        </div>
                                                        <div class="mb-3">
                                                            <img id="showImage"
                                                                src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('upload/no_image.jpg') }}"
                                                                alt="" class="rounded-circle p-1 bg-primary"
                                                                width="110">
                                                        </div>
                                                        <div class="mt-4">
                                                            <button type="submit"
                                                                class="btn btn-primary waves-effect waves-light">Save
                                                                Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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
@endsection
