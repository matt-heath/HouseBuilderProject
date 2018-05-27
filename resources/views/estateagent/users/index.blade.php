@extends('layouts.admin')

@section('title')
    <h1>Buyer Accounts</h1>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table id="myTable" width="100%" class="table table-striped table-bordered table-hover table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @if($users)
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role ? $user->role->name : 'User has no role'}}</td>
                        <td>{{$user->is_active == 1 ? 'Active' : 'Not Active' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('estateagent.users.edit', $user->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({

            });
        });
    </script>

@endsection