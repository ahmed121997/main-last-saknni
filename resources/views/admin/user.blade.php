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
        <h1 class="h3 mb-2 text-gray-800">Users Data</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable_user" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Updated_at</th>
                            <th>Created_at</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Updated_at</th>
                            <th>Created_at</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                        </tr>
                        </tfoot>
                       <tbody>
                       @if(isset($users) && count($users) > 0)
                           @foreach($users as $user)
                               <tr class="text-center">
                                   <td>{{$user->name}}</td>
                                   <td>{{$user->email}}</td>
                                   <td>{{$user->phone}}</td>
                                   <td>{{$user->updated_at}}</td>
                                   <td>{{$user->created_at}}</td>
                                   @if($user->status == 'Not verified')<td class="text-danger">{{$user->status}} 
                                    <button class="btn btn-danger btn-sm verify" id="{{$user->id}}">Verify</button>
                                    </td>@else <td class="text-success">{{$user->status}}@endif

                                   @if($user->last_seen == 'online')
                                   <td class="text-success text-center">{{$user->last_seen}}</td>
                                   @else <td class="text-center">{{$user->last_seen}}</td> @endif
                               </tr>
                           @endforeach
                       @endif
                       </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">{{$users->links()}}</div>
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


    <script  src="{{asset('public/js/addProperty.js')}}"></script>

    
    <script>
        $(".verify").click(function(){
            let id = this.id;
            $.ajax({
                type: 'post',
                url: '{{route("admin.verify.user")}}',
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
