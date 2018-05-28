@extends('layouts.admin')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->count())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$development}}</div>
                            <div>Developments</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('estateagent.developments.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Developments</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-map-marker fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$plots}}</div>
                            <div>Plots</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('estateagent.developments.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Plots</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$houseTypes}}</div>
                            <div>House Types</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('estateagent.developments.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Housetypes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-pencil fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$bookings}}</div>
                            <div>Bookings</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('estateagent.booking.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Bookings</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection