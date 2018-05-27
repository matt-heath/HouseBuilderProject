@extends('layouts.admin')

@section('title')
    <h1>Edit Booking</h1>
@endsection

@section('content')
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
                        <a href="{{ $booking->plot->houseTypes->house_photo ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Example house image for: ">
                            <img src="{{ $booking->plot->houseTypes->house_photo ? $booking->plot->houseTypes->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td>
                        <a href="{{$booking->plot->houseTypes->photo ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image" data-title="Example development image for:">
                            <img src="{{$booking->plot->houseTypes->photo ? $booking->plot->houseTypes->photo->file : 'http://placehold.it/400x400' }}"  class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">

            {!! Form::model($booking, ['method'=>'PATCH', 'action'=>['EstateAgentBookingsController@update', $booking->id], 'data-toggle'=>'validator'])!!}

            <div class="form-group">
                {!! Form::label('title', 'Buyer Name:')!!}
                {!! Form::select('title', ['Mr'=>'Mr', 'Mrs'=>'Mrs', 'Miss'=>'Miss', 'DR.'=>'DR.'], $booking->title, ['class'=>'form-control select']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('user_id', 'Buyers Name:')!!}
                {!! Form::text('user_id_disabled', $booking->user->name, ['class'=>'form-control', 'disabled']) !!}
                {!! Form::text('user_id', $booking->user_id, ['class'=>'form-control hidden']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('correspondence_address', 'Correspondence Address')!!}
                {!! Form::text('correspondence_address', null, ['data-error' => "Please enter a correspondence address",'class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('telephone_num', 'Telephone Number:')!!}
                {!! Form::text('telephone_num', null, ['data-error' => "Please enter a telephone number",'class'=>'form-control', 'required']) !!}
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                {!! Form::label('email_address', 'Email Address:')!!}
                {!! Form::email('email_address_disabled', $booking->user->email, ['class'=>'form-control', 'disabled']) !!}
                {!! Form::email('email_address', $booking->user->email, ['class'=>'form-control hidden']) !!}

            </div>
            {{--<div class="form-group">--}}
                {{--{!! Form::label('buyer_status', 'Buyer Status:')!!}--}}
                {{--{!! Form::select('buyer_status',['First Time Buyer'] , null, ['class'=>'form-control select']) !!}--}}
            {{--</div>--}}
            <div class="form-group">
                {!! Form::submit('Update Booking', ['class'=>'btn btn-primary col-sm-6']) !!}
            </div>
            {!! Form::close() !!}

            {!! Form::open(['method'=>'DELETE', 'action'=>['EstateAgentBookingsController@destroy', $booking->id]])!!}

            <div class="form-group">
                {!! Form::submit('Delete Booking', ['class'=>'btn btn-danger col-sm-6']) !!}
            </div>
            {!! Form::close() !!}
        </div>

    </div>
    {{--<div class="row">--}}
        {{--@include('includes.form_error')--}}
    {{--</div>--}}

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
@endsection