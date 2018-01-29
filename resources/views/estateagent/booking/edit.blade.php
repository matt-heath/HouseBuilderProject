@extends('layouts.admin')


@section('content')

    <h1>Edit Booking</h1>

    <div class="row">
        <div class="col-sm-6">
            {{--{{dd($booking->plot->houseTypes->house_photo->file)}}--}}
            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Example House Photo</th>
                    <th>Floor Plan</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="{{$booking->plot_id ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Example house image for: ">
                            <img src="{{$booking->plot_id ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td>
                        <a href="{{$booking->plot_id ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image" data-title="Example development image for:">
                            <img src="{{$booking->plot_id ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400' }}"  class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">

            {!! Form::model($booking, ['method'=>'PATCH', 'action'=>['EstateAgentBookingsController@update', $booking->id]])!!}

            <div class="form-group">
                {!! Form::label('user_id', 'Buyers Name:')!!}
                {!! Form::text('user_id', $booking->user->name, ['class'=>'form-control']) !!}
            </div>

            {{--<div class="form-group">--}}
                {{--{!! Form::label('development_location', 'Development Location:')!!}--}}
                {{--{!! Form::text('development_location', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('development_num_plots', 'Number of Plots:')!!}--}}
                {{--{!! Form::number('development_num_plots', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('development_description', 'Development Description:')!!}--}}
                {{--{!! Form::text('development_description', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::label('photo_id', 'Example Development Photo:')!!}--}}
                {{--{!! Form::file('photo_id', null, ['class'=>'form-control']) !!}--}}
            {{--</div>--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::submit('Update Development', ['class'=>'btn btn-primary col-sm-6']) !!}--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}

            {{--{!! Form::open(['method'=>'DELETE', 'action'=>['AdminDevelopmentsController@destroy', $development->id]])!!}--}}

            {{--<div class="form-group">--}}
                {{--{!! Form::submit('Delete Post', ['class'=>'btn btn-danger col-sm-6']) !!}--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}
        </div>

    </div>
    <div class="row">
        @include('includes.form_error')
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.selectHouseType').select2();
        });
    </script>
@endsection