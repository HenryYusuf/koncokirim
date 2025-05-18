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
                        <h4 class="mb-sm-0 font-size-18">All Banner</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addBannerModal">Add Banner</button>
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

                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Banner Image</th>
                                        <th>Banner Url</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($banners as $key => $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>
                                                <img src="{{asset($item->image)}}" alt="" style="width: 70px; height: 40px;" />
                                            </td>
                                            <td>{{$item->url}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#editBannerModal"
                                                    id="{{ $item->id }}" onclick="editBanner(this.id)">Edit</button>
                                                <a href="{{ route('admin.delete.banner', $item->id) }}"
                                                    class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    {{-- Add Modal --}}
    <!-- sample modal content -->
    <div id="addBannerModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="{{ route('admin.banner.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Banner Url</label>
                                        <input class="form-control" type="text" name="url" id="example-text-input">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Banner Image</label>
                                        <input class="form-control" name="image" type="file" id="image">
                                    </div>
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt=""
                                            class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Edit Modal --}}
    <!-- sample modal content -->
    <div id="editBannerModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="{{ route('admin.banner.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="bannerId">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Banner Url</label>
                                        <input class="form-control" type="text" name="url" id="bannerUrl">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">Banner Image</label>
                                        <input class="form-control" name="image" type="file" id="editImage">
                                    </div>
                                    <div class="form-group mb-3">
                                        <img id="bannerImage" alt=""
                                            class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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

    <script>
        $(document).ready(function () {
            $('#editImage').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#bannerImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0'])
            })
        })
    </script>

    <script>
        function editBanner(id) {
            $.ajax({
                type: "GET",
                url: '/admin/edit/banner/' + id,
                dataType: 'json',

                success: function (data) {
                    // console.log(data);
                    $('#bannerId').val(data.id);
                    $('#bannerUrl').val(data.url);
                    $('#bannerImage').attr('src', data.image);
                }
            })
        }
    </script>
@endsection