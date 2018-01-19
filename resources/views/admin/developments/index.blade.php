@extends('layouts.admin')

@section('content')

    <h1>Developments</h1>


    <table class="table table-striped table-hover">
       <thead>
         <tr>
              <th>Development ID</th>
              <th>Development Name</th>
              <th>Development Location</th>
              <th>Number of plots</th>
              <th>Development Description</th>
              <th>Photo</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Updated At</th>
         </tr>
       </thead>
        <tbody>
           @if($developments)
               @foreach($developments as $development)
                     <tr>
                         <td>{{$development->id}}</td>
                         <td>{{$development->development_name}}</td>
                         <td><address>{{$development->development_location}}</address></td>
                         <td>{{$development->development_num_plots}}</td>
                         <td>{{$development->development_description}}</td>
                         <td><img height="50" src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " alt=""></td>
                         <td>{{$development->user->name}}</td>
                         <td>{{$development->created_at->diffForHumans()}}</td>
                         <td>{{$development->updated_at->diffForHumans()}}</td>
                     </tr>
               @endforeach
           @endif
        </tbody>
    </table>

@endsection