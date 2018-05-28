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

@section('title')
    <h1>Dashboard</h1>
@endsection

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
                            <div class="huge">1</div>
                            <div>Your House</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('buyer.plot.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Your House</span>
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
                            <i class="fa fa-certificate fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$variation_count}}</div>
                                <div>Your Selections</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="/buyer/variations/{{$booking}}/edit">
                {{--<a href="/buyer/variations/".$development."/edit">--}}
                    <div class="panel-footer">
                        <span class="pull-left">Manage property selections</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection