@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">All City</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addCityModal">Add City</button>
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
                                        <th>City Name</th>
                                        <th>City Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($cities as $key => $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->city_name}}</td>
                                            <td>{{$item->city_slug}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#editCityModal" id="{{ $item->id }}"
                                                    onclick="editCity(this.id)">Edit</button>
                                                <a href="{{ route('admin.delete.city', $item->id) }}"
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
    <div id="addCityModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="{{ route('admin.city.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">City Name</label>
                                        <input class="form-control" type="text" name="city_name" id="example-text-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Edit Modal --}}
    <!-- sample modal content -->
    <div id="editCityModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="{{ route('admin.city.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="cityId">
                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <div class="form-group mb-3">
                                        <label for="example-text-input" class="form-label">City Name</label>
                                        <input class="form-control" type="text" name="city_name" id="cityName">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        function editCity(id) {
            $.ajax({
                type: "GET",
                url: '/admin/edit/city/' + id,
                dataType: 'json',

                success: function (data) {
                    // console.log(data);
                    $('#cityId').val(data.id);
                    $('#cityName').val(data.city_name);
                }
            })
        }
    </script>
@endsection