@extends('layouts.admin')

@section('content')

    @if(Session::has('deleted_user'))
        <p class="bg-danger">{{session('deleted_user')}}</p>
    @endif


    <h1>Buyer Accounts</h1>


    <table id="myTable" width="100%" class="table table-striped table-bordered table-hover table-responsive">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
        </thead>
        <tbody>

        @if($users)
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href="{{route('estateagent.users.edit', $user->id)}}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
                    <td>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
                    <td>{{$user->created_at->diffForHumans()}}</td>
                    <td>{{$user->updated_at->diffForHumans()}}</td>
                </tr>
            @endforeach
        @endif

        </tbody>
    </table>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,

            });
        });
    </script>

@endsection