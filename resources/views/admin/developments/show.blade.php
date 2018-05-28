@extends('layouts.admin')

@section('title')
    {{--<h1>Developments</h1>--}}
    <h1>{{$development->development_name}}</h1>
@endsection

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{--<div class="col-sm-6">--}}
    {{--<div class="panel-heading"></div>--}}
    {{--<div class="panel-body">--}}
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} "
               data-lightbox="image-1" data-title="Example development image for: {{$development->development_name}}">
                <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}"
                     class="img-responsive img-rounded" alt="">
            </a>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="panel-heading">
                    <div class='page-header' style="margin: 0 !important;">
                        <div class='btn-toolbar pull-right'>
                            <div class='btn-group'>
                                <a href="{{route('admin.developments.edit', $development->id)}}"
                                   class="btn btn-primary"><i
                                            class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                        </div>
                        <h3>{{$development->development_name}} - Development Details</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-striped table-hover table-bordered">
                            <tbody>
                            <tr>
                                <td><b>Development Name</b></td>
                                <td>{{$development->development_name}}</td>
                            </tr>
                            <tr>
                                <td><b>Development Location</b></td>
                                <td><a href="https://www.google.co.uk/maps/place/{{$development->development_location}}"
                                       target="_blank">
                                        <address>{{$development->development_location}}</address>
                                    </a></td>
                            </tr>
                            <tr>
                                <td><b>Number of Plots</b></td>
                                <td>{{$num_of_plots_available->where('development_id', $development->id)->count().'/'.$development->development_num_plots}}</td>
                            </tr>
                            <tr>
                                <td><b>Development Description</b></td>
                                <td>{{$development->development_description}}</td>
                            </tr>
                            <tr>
                                <td><b>Estate Agent Responsible</b></td>
                                <td>{{$estate_agent ? $estate_agent->company_name : "No Estate Agent Set - Edit the development to add one!"}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Plots to Development</h4>
                    </div>
                    <div class="modal-body">
                        {{-- {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>"validator"])!!} --}}
                        {!! Form::open(['method'=>'POST', 'action'=>'AdminPlotsController@store', 'data-toggle'=>'validator'])!!}

                        <div class="form-group">
                            {!! Form::text('id', $development->id, ['class'=>'form-control hidden']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('development_id', 'Development Name:')!!}
                            {!! Form::select('development_id_disabled', $development_select, null, ['class'=>'form-control developmentSelect', 'disabled']) !!}
                            {!! Form::select('development_id', $development_select, null, ['class'=>'form-control selectPlot developmentSelect hidden']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('house_type', 'House Type:')!!}
                            {!! Form::select('house_type', [''=>'Choose House Type'] + $houseTypes_select, null, ['class'=>'form-control selectPlot select houseTypeSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('phase', 'Phase:')!!}
                            {!! Form::select('phase', [''=>'Choose Development Phase'] + $phases, null, ['class'=>'form-control phaseSelect select', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('sqft', 'SqFt:') !!}
                            {!! Form::number('sqft', null, ['data-error' => "Please input a SqFt for the plots", 'class'=>'form-control name_list', 'placeholder' => 'SqFt', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('status', 'Status:') !!}
                            {!! Form::text('status_disabled', 'For Sale', ['class'=>'form-control name_list', 'placeholder' => 'Status', 'disabled']) !!}
                            {!! Form::text('status', 'For Sale', ['class'=>'form-control name_list hidden', 'placeholder' => 'Status']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('num_of_plots', 'Number of plots to generate:') !!}
                            {!! Form::number('num_of_plots', null, ['max'=> 50, 'class' => 'form-control num_of_plots', 'placeholder' => 'Number of plots to generate', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        {{-- {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!} --}}
                        <div class="form-group">
                            {!! Form::submit('Create Plots', ['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <!-- Nav tabs -->
            <br>
            <div class="card card-display">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#plots" aria-controls="plots" role="tab"
                                                              data-toggle="tab">Plots</a></li>
                    <li role="presentation"><a href="#housetypes" aria-controls="housetypes" role="tab"
                                               data-toggle="tab">House Types</a></li>
                    <li role="presentation"><a href="#phases" aria-controls="phases" role="tab"
                                               data-toggle="tab">Phases</a></li>
                    <li role="presentation"><a href="#consultants" aria-controls="consultants" role="tab"
                                               data-toggle="tab">Consultants</a></li>
                    <li role="presentation"><a href="#suppliers" aria-controls="suppliers" role="tab" data-toggle="tab">Suppliers</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="plots">
                        <div class="row">
                            @if($num_of_plots_available->where('development_id', $development->id)->count() !== $development->development_num_plots)
                                <div class='btn-toolbar pull-left'>
                                    <div class='btn-group'>
                                        {{-- <a href="{{route('admin.developments.edit', $development->id)}}" class="btn btn-success"><i class="fa fa-fw fa-plus fa-sm"></i> Add Plots to Development</a> --}}
                                        <button type="button" class="btn btn-success" data-toggle='modal'
                                                data-target='#myModal' id='modalClick'><i class="fa fa-fw fa-plus"></i>
                                            Add Plots to Development
                                        </button>
                                    </div>
                                    <hr>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Plot Name</th>
                                        <th>House Type</th>
                                        <th>SqFt</th>
                                        <th>Phase</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($plots)
                                        {{--Declares the variable count as 0 without printing to the screen--}}
                                        @php ($count = 0)
                                        @foreach($plots as $plot)
                                            <tr>
                                                <td>{{$plot->plot_name}}</td>
                                                <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                                                <td>{{$plot->sqft}}</td>
                                                <td>{{$plot->phases ? $plot->phases->phase_name : "NONE"}}</td>
                                                <td>{{$plot->status}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{route('admin.plots.show', $plot->id)}}"
                                                           class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                                                    </div>
                                                    {{--@if(!$plot->certificates->isEmpty())--}}
                                                    {{--<div class="btn-group">--}}
                                                    {{--<a href="{{route('admin.certificates.edit', $plot->id)}}"--}}
                                                    {{--class="btn btn-warning"><i--}}
                                                    {{--class="fa fa-fw fa-certificate fa-sm"></i></a>--}}
                                                    {{--</div>--}}
                                                    {{--@endif--}}
                                                    <div class="btn-group">
                                                        <a href="{{route('admin.plots.edit', $plot->id)}}"
                                                           class="btn btn-primary"><i
                                                                    class="fa fa-fw fa-edit fa-sm"></i></a>
                                                    </div>
                                                    <div class="btn-group">
                                                        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $plot->id], 'id'=> 'confirm_delete_'.$plot->id]) !!}
                                                        {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$plot->id .')']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                            @php ($count++)
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="housetypes">
                        <div class="row">
                            <div class="modal fade" id="houseTypeModal" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add House Types to Development</h4>
                                        </div>
                                        <div class="modal-body">
                                            {{-- {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>"validator"])!!} --}}
                                            {!! Form::open(['method'=>'POST', 'action'=>'AdminHouseTypesController@store', 'files' => true, 'data-toggle'=>'validator'])!!}

                                            <div class="form-group">
                                                {!! Form::label('development_id', 'Development Name:')!!}
                                                {!! Form::select('development_id_disabled', $development_select, 'default', ['class'=>'form-control', 'id'=>'developments', 'style'=>'height: 34px !important', 'disabled']) !!}
                                                {!! Form::select('development_id', $development_select, 'default', ['class'=>'form-control hidden', 'id'=>'developments', 'style'=>'height: 34px !important']) !!}
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('house_type_name', 'House Type Name:')!!}
                                                {!! Form::text('house_type_name', null, ['data-error' => "Please input the house type name",'class'=>'form-control', 'required']) !!}
                                                <div class="help-block with-errors"></div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('house_type_desc', 'House Type Description:')!!}
                                                {!! Form::text('house_type_desc', null, ['data-error' => "Please input the house type description",'class'=>'form-control', 'required']) !!}
                                                <div class="help-block with-errors"></div>
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('floor_plan', 'Floor Plan Image:')!!}
                                                {!! Form::file('floor_plan', null, ['class'=>'form-control']) !!}
                                            </div>

                                            <div class="form-group">
                                                {!! Form::label('house_img', 'House Image:')!!}
                                                {!! Form::file('house_img', null, ['class'=>'form-control']) !!}
                                            </div>

                                            <div class="form-group">
                                                {!! Form::submit('Create House Type', ['class'=>'btn btn-primary']) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='btn-toolbar pull-left'>
                                <div class='btn-group'>
                                    {{-- <a href="{{route('admin.developments.edit', $development->id)}}" class="btn btn-success"><i class="fa fa-fw fa-plus fa-sm"></i> Add Plots to Development</a> --}}
                                    <button type="button" class="btn btn-success" data-toggle='modal'
                                            data-target='#houseTypeModal' id='modalClick'><i
                                                class="fa fa-fw fa-plus"></i>
                                        Add House Types to Development
                                    </button>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="houseTypesTable" width="100%"
                                       class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Development Name</th>
                                        <th>House Type Name</th>
                                        <th>House Type Description</th>
                                        <th>House Image</th>
                                        <th>Floor Plan Image</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($houseTypes)

                                        {{--Declares the variable count as 0 without printing to the screen --}}
                                        @php($count = 0)
                                        @foreach($houseTypes as $houseType)
                                            {{--{{ $houseType->photo}}--}}
                                            {{--{{$houseType}}--}}
                                            <tr>
                                                <td>
                                                    {{$houseType->development_id ? $houseType->development->development_name : "Development Not Set" }}
                                                </td>
                                                <td>
                                                    {{$houseType->house_type_name}}
                                                </td>
                                                <td>
                                                    {{$houseType->house_type_desc}}
                                                </td>
                                                <td>
                                                    <a href="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}"
                                                       data-lightbox="image-{{$count}}"
                                                       data-title="Example house image for: {{$houseType->house_type_name}} ">
                                                        <img src="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}"
                                                             class="img-responsive img-rounded" alt="">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}"
                                                       data-lightbox="image-{{$count}}"
                                                       data-title="Floor plan image for: {{$houseType->house_type_name}}">
                                                        <img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}"
                                                             class="img-responsive img-rounded" alt="">
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{route('admin.housetypes.show', $houseType->id)}}"
                                                           class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                                                    </div>
                                                    <div class="btn-group-vertical">
                                                        <a href="{{route('admin.housetypes.edit', $houseType->id)}}"
                                                           class="btn btn-primary"><i
                                                                    class="fa fa-fw fa-edit fa-sm"></i></a>
                                                    </div>
                                                    <div class="btn-group-vertical">
                                                        {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminHouseTypesController@destroy', $houseType->id], 'id'=> 'confirm_delete_'.$houseType->id]) !!}
                                                        {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$houseType->id .')']) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                            @php($count++)

                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="phases">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success" data-toggle='modal' data-target='#addPhaseModal'
                                    id='addPhaseClick'><i class="fa fa-fw fa-plus"></i> Add Phase to Development
                            </button>
                        </div>
                        <div class="modal fade" id="addPhaseModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Phase to Development</h4>
                                    </div>
                                    <div class="modal-body">
                                        {{-- {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>"validator"])!!} --}}
                                        {!! Form::open(['method'=>'POST', 'action'=>'AdminDevelopmentsController@addPhase', 'data-toggle'=>'validator'])!!}

                                        <div class="form-group">
                                            {!! Form::label('num_plots', 'Number of Plots in New Phase:')!!}
                                            {!! Form::number('num_plots', null, ['class'=>'form-control', 'style'=>'height: 34px !important']) !!}
                                            {!! Form::text('development_id', $development->id,['class'=>'form-control hidden', 'style'=>'height: 34px !important']) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::submit('Create Phase', ['class'=>'btn btn-primary']) !!}
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive">
                            <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Phase Name</th>
                                    <th>Number of Plots</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($phaseDetails as $detail)
                                        <td>{{$detail->phase_name}}</td>
                                        <td>{{$detail->num_plots}}</td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="consultants">
                        <div class="tab-content" style="padding-top: 0px">
                            @if($phase)
                                <ul class="nav nav-tabs" id="dashboard_tabs">
                                    @php($first = true)
                                    @php($count = 0)
                                    {{--                                @foreach($allPhases as $phase)--}}
                                    @php($str = str_replace(' ','',$phase->phase_name))
                                    @if($first)
                                        <li role="presentation" class="active"><a
                                                    href="#{{$str}}"
                                                    aria-controls="{{$str}}"
                                                    role="tab"
                                                    data-toggle="tab">{{$phase->phase_name}}</a></li>
                                        @php($first = false)
                                        @php($count++)
                                    @else
                                        <li role="presentation"><a href="#{{$str}}"
                                                                   aria-controls="{{$str}}"
                                                                   role="tab"
                                                                   data-toggle="tab">{{$phase->phase_name}}</a></li>
                                        @php($count++)
                                    @endif

                                    {{--@endforeach--}}
                                </ul>

                                <div class="tab-content">
                                    <div class="modal fade" id="addConsultantModal" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title">Add Consultant Account</h4>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>'validator'])!!}
                                                    <div class="form-group">
                                                        {!! Form::label('name', 'Name:') !!}
                                                        {!! Form::text('name', null, ['class'=>'form-control', 'required'])!!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>


                                                    <div class="form-group">
                                                        {!! Form::label('email', 'Email:') !!}
                                                        {!! Form::email('email', null, ['class'=>'form-control', 'required'])!!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('role_id', 'Role:') !!}
                                                        {!! Form::text('role_id_disabled', $roles, ['class'=>'form-control', 'disabled'])!!}
                                                        {!! Form::text('role_id', $roles, ['class'=>'form-control name_list hidden']) !!}
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('consultant_description', 'Consultant Description:') !!}
                                                        {!! Form::textarea('consultant_description', null, ['class'=>'form-control name_list', 'placeholder' => 'Consultant Description', 'rows' => 2, 'cols' => 40, 'required']) !!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>


                                                    <div class="form-group">
                                                        {!! Form::label('is_active', 'Status:') !!}
                                                        {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 1 , ['class'=>'form-control', 'required'])!!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('password', 'Password:') !!}
                                                        {!! Form::password('password', ['data-minlength'=>'6','required','class'=>'form-control', 'placeholder'=>'Password'])!!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('inputPasswordConfirm', 'Confirm Password:') !!}
                                                        {!! Form::password('inputPasswordConfirm', ['data-match'=>'#password','data-match-error'=>"Whoops, these passwords don't match",'required','class'=>'form-control', 'placeholder'=>'Confirm Password'])!!}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="form-group">
                                                        {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php($firstTab = true)
                                    @php($str1 = str_replace(' ','',$phase->phase_name))
                                    @if($firstTab)
                                        <div role="tabpanel" class="tab-pane active"
                                             id="{{$str1}}">

                                            @else
                                                <div role="tabpanel" class="tab-pane" id="{{$str1}}">
                                                    @endif
                                                    {{--{{$str1}}--}}
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-success"
                                                                data-toggle='modal' data-target='#addConsultantModal'
                                                                id='addConsultant'><i class="fa fa-fw fa-plus"></i> Add
                                                            consultant account
                                                        </button>
                                                    </div>
                                                    <br><br>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Consultant Description</th>
                                                            <th>Select a consultant</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php ($count = 0)
                                                        {!! Form::open(['method'=>'POST', 'action'=>'AdminCertificatesController@store', 'files' => true, 'data-toggle'=>'validator'])!!}

                                                        @foreach($certificates as $certificate)
                                                            <tr>
                                                                <td>
                                                                    {!! Form::text('certificate_name_disabled', null, ['class'=>'form-control name_list', 'name'=>'certificate_name[]', 'placeholder' =>  $certificate->certificate_name,'disabled']) !!}
                                                                    {!! Form::text('certificate_name', $certificate->id, ['class'=>'form-control name_list hidden', 'name'=>'certificate_name[]']) !!}
                                                                    {!! Form::text('phase', $phase->id, ['class'=>'hidden']) !!}
                                                                    {!! Form::text('development_id', $development->id, ['class'=>'hidden']) !!}
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        {!! Form::select('consultant_id', ['' => 'Select Consultant Responsible'] + $consultants, null, ['class'=>'form-control consultantSelect select', 'name' => 'consultant_id[]', 'required'])!!}
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                    <div class="form-group" id="consultantDetails">

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @php ($count++)
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group">
                                                        {!! Form::submit('Add consultants to phase', ['class'=>'btn btn-primary']) !!}
                                                    </div>
                                                    {!! Form::close() !!}
                                                    {{--{{$str1}}--}}
                                                </div>
                                                @php($firstTab = false)

                                        </div>
                                    @else
                                        <h5 style="color: green">All phases have been assigned consultants!</h5>
                                    @endif
                                </div>
                        </div>


                        <div role="tabpanel" class="tab-pane" id="suppliers">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Supplier Type</th>
                                    <th>Supplier Name</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--TODO: Remove foreach variables into controller?--}}
                                @php($arr = array())
                                @php($assigned_supplier_arr = array())

                                @foreach($supplier_types as $type)
                                    @php($arr[] = $type)
                                @endforeach

                                @foreach($development->suppliers as $assigned_supplier)
                                    @php($assigned_supplier_arr[] = $assigned_supplier)
                                @endforeach

                                @php($count = 0)
                                @foreach($arr as $type )
                                    @php($bool = false)
                                    <tr>
                                        <td>
                                            {{$type->category_name}}
                                        </td>
                                        @php($count2=0)
                                        @foreach($assigned as $assigned_category)
                                            @if($type->category_name == $assigned_category['category_name'])
                                                <td>{{$assigned_supplier_arr[$count2]->supplier_company_name}}</td>
                                                @php($bool = true)
                                                <td>
                                                    <a href="{{route('admin.developments.assignSupplier', [$development->id, $type->id])}}"
                                                       class="btn btn-primary"><i
                                                                class="fa fa-fw fa-edit fa-sm"></i></a>
                                                </td>
                                                {{--@elseif($bool !== true)--}}
                                                {{--@php($bool = false)--}}
                                            @endif

                                            @php($count2++)
                                        @endforeach

                                        @if($bool == false && $count <= count($arr))
                                            <td style="color: #ff0000;">{{"No supplier assigned to this category"}}</td>
                                            <td>
                                                <a href="{{route('admin.developments.assignSupplier', [$development->id, $type->id])}}"
                                                   class="btn btn-success"><i class="fa fa-fw fa-plus"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                    @php($count++)
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        {{--</div>--}}
        {{--<div class="panel-footer">--}}
        {{--HI--}}
        {{--</div>--}}
        {{--</div>--}}



        @endsection

        @section('script')

            <script>
                var dev_id = $('.developmentSelect').val();
                $(document).ready(function () {
                    // $("ul.nav-tabs a").click(function (e) {
                    //     e.preventDefault();
                    //     $(this).tab('active');
                    // });
                    $('.select').select2();
                    $('#myTable').DataTable({
                        "columnDefs": [
                            {"orderable": false, "targets": 5}
                        ]

                    });
                    $('#houseTypesTable').DataTable({
                        "columnDefs": [
                            {"orderable": false, "targets": 5}
                        ]

                    });
                });

                function confirmDelete(id) {
                    event.preventDefault();

                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        buttonsStyling: true
                    }).then((result) => {
                        if (result.value) {
                            swal({
                                title: 'Deleted!',
                                text: 'Successfully deleted.',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function () {
                                $("#confirm_delete_" + id).off("submit").submit()
                            })
                            // $("#confirm_delete_"+id).off("submit").submit()
                            // result.dismiss can be 'cancel', 'overlay',
                            // 'close', and 'timer'
                        } else if (result.dismiss === 'cancel') {

                        }
                    })
                }

                $(document).on('change', '.phaseSelect', function () {
                    console.log("DROP A LOG" + dev_id);
                    $.ajax({
                        type: 'get',
                        url: '{!! URL::to('findNumPlots') !!}',
                        data: {'id': dev_id},
                        success: function (data) {
                            console.log('Success!!');
                            console.log(data);
                            // console.log(data.length);
                            // if (data.length != 0) {
                            //     option += '<option value="" selected disabled>Choose House Type</option>';
                            // } else {
                            //     option += '<option value="" selected disabled>No House types available - Create one!</option>';
                            // }
                            // for (var i = 0; i < data.length; i++) {
                            //     option += '<option value="' + data[i].id + '">' + data[i].house_type_name + '</option>';
                            // }
                            // $(".houseTypeSelect").html(" ").append(option);
                            $(".num_of_plots").attr({
                                "min": 0,
                                "max": data,        // substitute your own
                            });
                        },
                        error: function () {
                            console.log("Failed...")
                        }
                        // });
                    });
                });

                $('#addUser').on('click', function (e) {
                    e.preventDefault();
                    var data = $('form.contact').serialize();
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        url: '/addUser',
                        data: data,
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            console.log('USER ADDED' + data.id + data.name);
                            $('.consultantSelect').append('<option value="' + data.id + '">' + data.name + '(' + data.email + ') </option>');
                            $('#addConsultantModal').modal('hide');
                            $('#addConsultantModal form :input').val("");
                        },
                        error: function (data) {

                        }
                    })
                });
            </script>

@endsection

