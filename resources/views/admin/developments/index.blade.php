@extends('layouts.admin')

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

    <h1>Developments</h1>


    <table class="table table-striped table-hover">
       <thead>
         <tr>
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

               {{--Declares the variable count as 0 without printing to the screen --}}
               {{--*/ $count = 0 /*--}}
               @foreach($developments as $development)
                     <tr>
                         <td><a href="{{route('admin.developments.edit', $development->id)}}">{{$development->development_name}}</a></td>
                         <td><address>{{$development->development_location}}</address></td>
                         <td>{{$development->development_num_plots}}</td>
                         <td>{{$development->development_description}}</td>
                         <td><a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-{{$count}}" data-title="Example development image for: {{$development->development_name}}">
                                 <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                             </a>
                         </td>
                         <td>{{$development->user->name}}</td>
                         <td>{{$development->created_at->diffForHumans()}}</td>
                         <td>{{$development->updated_at->diffForHumans()}}</td>
                     </tr>
                     {{--*/ $count++ /*--}}
               @endforeach
           @endif
        </tbody>
    </table>

@endsection