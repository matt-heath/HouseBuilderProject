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
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-map-marker fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$plots_count}}</div>
                            <div>Plots Responsible For</div>
                            <br>
                        </div>
                    </div>
                </div>
                <a href="{{route('externalconsultant.plots.index')}}">
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
                            <i class="fa fa-certificate fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$totalCert}}</div>
                            <div>Certificates Responsible For</div>
                        </div>
                    </div>
                </div>
                <a href="{{route('externalconsultant.plots.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">View Certificates</span>
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
                            <div class="huge">{{$certificates}}</div>
                            @if($certificates > 1 || $certificates == 0)
                                <div>Certificates Ready for Inspection</div>
                            @else
                                <div>Certificate Ready for Inspection</div>
                            @endif

                        </div>
                    </div>
                </div>
                <a href="{{route('externalconsultant.plots.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">Manage certificates</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

@endsection