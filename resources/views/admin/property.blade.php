@extends('admin.layouts.app')
@section('links')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/admin/all.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Properties Data</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Properties</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable_property" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-center">
                            <td>#</td>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Price</th>
                            <th># Rooms</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr class="text-center">
                            <td>#</td>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Price</th>
                            <th># Rooms</th>
                            <th>Status</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(isset($properties) && count($properties) > 0)
                            @foreach($properties as $property)
                                <tr class="text-center">
                                    <td>{{$property->id}}</td>
                                    <td>{{$property->des->title}}</td>
                                    <td>{{$property->typeProperty->type_en}}</td>
                                    <td>{{$property->area}}</td>
                                    <td>{{$property->price}}</td>
                                    <td>{{$property->num_rooms}}</td>

                                    <td>
                                        @if($property->status === 'active')<span class="text-success">{{$property->status}}</span>
                                        @else
                                        <span class="text-danger">{{$property->status}}</span>
                                        <button class="btn btn-danger btn-sm verify" id="{{$property->id}}">Verify</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{$properties->links()}}</div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('public/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('public/js/admin/demo/datatables-demo.js')}}"></script>

    <script>
        $(".verify").click(function(){
            let id = this.id;
            console.log(id);
            $.ajax({
                type: 'post',
                url: '{{route("admin.verify.property")}}',
                data: {
                    '_token' : '{{csrf_token()}}',
                    'id' : id,
                },
                success: function(data) {
                    $('#'+id).parent().html('<span class="btn text-success">Verified</span>');
                },
                error: function(reject) {

                },
            });
        });

    </script>
@endsection
