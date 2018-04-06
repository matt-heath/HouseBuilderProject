@extends('layouts.admin')

@section('title')
    <h1>Create Development</h1>
@endsection

@section('content')
    <div class="row">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Consultant Account</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact'])!!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', 'Role:') !!}
                            {!! Form::select('role_id', $roles, null, ['class'=>'form-control roleSelect select'])!!}
                            {{--                                                            {!! Form::select('role_id', $roles , null, ['class'=>'form-control roleSelect hidden'])!!}--}}
                        </div>

                        <div class="form-group">
                            {!! Form::label('consultant_description', 'Consultant Description:') !!}
                            {!! Form::textarea('consultant_description', null, ['class'=>'form-control name_list', 'placeholder' => 'Consultant Description', 'rows' => 2, 'cols' => 40]) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('is_active', 'Status:') !!}
                            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 0 , ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!}
                        </div>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalSupplier" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Consultant Account</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method'=>'POST', 'class'=> 'supplier', 'id'=>'contact'])!!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', 'Role:') !!}
                            {!! Form::select('role_id_disabled', $supplierRoles, null, ['class'=>'form-control', 'disabled'])!!}
                            {!! Form::select('role_id', $supplierRoles , null, ['class'=>'form-control roleSelect hidden'])!!}
                        </div>

                        <div class="form-group" id="supplierDetails">
                            {!! Form::label('supplier_company_name', 'Supplier Company Name') !!}
                            {!! Form::text('supplier_company_name', null, ['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group" id="supplierName">
                            {!! Form::label('supplier_type', 'Supplier Type') !!}
                            {!! Form::select('supplier_type', ['' => 'Select a supplier type'] + $supplier_types_select, null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('is_active', 'Status:') !!}
                            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 0 , ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addSupplier']) !!}
                        </div>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModalEstAgent" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Estate Agent Account</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['method'=>'POST', 'class'=> 'supplier', 'id'=>'contact'])!!}
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name', null, ['class'=>'form-control'])!!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', 'Role:') !!}
                            {!! Form::select('role_id_disabled', $estate_select, null, ['class'=>'form-control', 'disabled'])!!}
                            {!! Form::select('role_id', $estate_select , null, ['class'=>'form-control roleSelect hidden'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('is_active', 'Status:') !!}
                            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 0 , ['class'=>'form-control'])!!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addEstateAgent']) !!}
                        </div>
                        {!! Form::close() !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        {!! Form::open(['method'=>'POST', 'action'=>'AdminDevelopmentsController@store', 'files' => true])!!}
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">Create Development<br/>
                        <small>Input development details</small>
                    </a></li>
                <li><a href="#step-2">Add Phases in Development<br/>
                        <small>Input several phases in development</small>
                    </a></li>
                <li><a href="#step-3">Add House Types<br/>
                        <small>Input house type details</small>
                    </a></li>
                <li><a href="#step-4">Assign Consultants to Development<br/>
                        <small>Input consultant details</small>
                    </a></li>
                <li><a href="#step-5">Assign Suppliers to Development<br/>
                        <small>Input supplier details</small>
                    </a></li>
                {{--<li><a href="#step-4">Step Title<br /><small>Step description</small></a></li>--}}
            </ul>

            <div>
                <div id="step-1" class="">

                    <div class="form-group">
                        {!! Form::label('development_name', 'Development Name:')!!}
                        {!! Form::text('development_name', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('development_location', 'Development Location:')!!}
                        {!! Form::text('development_location', null, ['class'=>'form-control']) !!}
                    </div>

                    {{--<div class="form-group">--}}
                    {{--{!! Form::label('development_num_plots', 'Number of Plots:')!!}--}}
                    {{--{!! Form::number('development_num_plots', null, ['class'=>'form-control']) !!}--}}
                    {{--</div>--}}

                    <div class="form-group">
                        {!! Form::label('development_description', 'Development Description:')!!}
                        {!! Form::text('development_description', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('estate_agent_responsible', 'Estate Agent Responsible:')!!}
                        {!! Form::select('estate_agent_responsible', ['' => 'Select Estate Agent Responsible'] + $estate_select, null, ['class'=>'form-control consultantSelect select', 'name' => 'consultant_id[]'])!!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('photo_id', 'Example Development Photo:')!!}
                        {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div id="step-2" class="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dynamic_field_phase">
                            <tr>
                                <td>
                                    {!! Form::text('phase_name_disabled', null, ['class'=>'form-control phase_name_list', 'name'=>'phase_name[]', 'placeholder' => 'Phase 1', 'disabled']) !!}
                                    {!! Form::text('phase_name', 'Phase 1', ['class'=>'form-control phase_name_list hidden', 'name'=>'phase_name[]', 'placeholder' => 'Phase 1']) !!}
                                </td>
                                <td>{!! Form::number('phase_num_plots', null, ['class'=>'form-control phase_name_list', 'name'=>'phase_num_plots[]', 'placeholder' => 'Number of plots']) !!}</td>
                                {{--<td class="col-xs-3">{!! Form::textarea('house_type_desc', null, ['class'=>'form-control name_list', 'name' => 'house_type_desc[]', 'placeholder' => 'Description']) !!}</td>--}}
                                {{--<td class="col-xs-2">{!! Form::file('floor_plan', null, ['class'=>'form-control', 'name'=>'floor_plan[]', 'id'=>'floor_plan_0', 'placeholder'=>'']) !!}</td>--}}
                                {{--<td class="col-xs-2">{!! Form::file('house_img', null, ['class'=>'form-control', 'name'=>'house_img[]', 'id'=>'house_img_0', 'placeholder'=>'']) !!}</td>--}}
                                {{--<td class="col-xs-2"><input type="file" id="floor_plan_0" name="floor_plan[]" class="form-control"/></td>--}}
                                {{--<td class="col-xs-2"><input type="file" id="house_img_0" name="house_img[]" class="form-control" /></td>--}}
                                <td>
                                    <button type="button" name="add_phase" id="add_phase" class="btn btn-success"><i
                                                class="fa fa-fw fa-plus"></i></button>
                                </td>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="step-3" class="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dynamic_field">
                            <tr>
                                <td class="col-xs-3">{!! Form::text('house_type_name', null, ['class'=>'form-control name_list', 'name'=>'house_type_name[]', 'placeholder' => 'House type name']) !!}</td>
                                <td class="col-xs-3">{!! Form::textarea('house_type_desc', null, ['class'=>'form-control name_list', 'name' => 'house_type_desc[]', 'placeholder' => 'Description']) !!}</td>
                                {{--<td class="col-xs-2">{!! Form::file('floor_plan', null, ['class'=>'form-control', 'name'=>'floor_plan[]', 'id'=>'floor_plan_0', 'placeholder'=>'']) !!}</td>--}}
                                {{--<td class="col-xs-2">{!! Form::file('house_img', null, ['class'=>'form-control', 'name'=>'house_img[]', 'id'=>'house_img_0', 'placeholder'=>'']) !!}</td>--}}
                                <td class="col-xs-2"><input type="file" id="floor_plan_0" name="floor_plan[]"
                                                            class="form-control"/></td>
                                <td class="col-xs-2"><input type="file" id="house_img_0" name="house_img[]"
                                                            class="form-control"/></td>
                                <td>
                                    <button type="button" name="add" id="add" class="btn btn-success"><i
                                                class="fa fa-fw fa-plus"></i></button>
                                </td>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="step-4" class="">
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal'
                                id='modalClick'><i class="fa fa-fw fa-plus"></i> Add consultant account
                        </button>
                    </div>
                    <br><br>
                    <table id="myTable" width="100%" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Consultant Description</th>
                            <th>Select a consultant</th>
                            {{--<th>Add new consultant to dropdown</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @php ($count = 0)
                        @foreach($certificates as $certificate)
                            <tr>
                                <td>
                                    {!! Form::text('certificate_name_disabled', null, ['class'=>'form-control name_list', 'name'=>'certificate_name[]', 'placeholder' =>  $certificate->name,'disabled']) !!}
                                    {!! Form::text('certificate_name', $certificate->id, ['class'=>'form-control name_list hidden', 'name'=>'certificate_name[]']) !!}

                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::select('consultant_id', ['' => 'Select Consultant Responsible'] + $consultants, null, ['class'=>'form-control consultantSelect select', 'name' => 'consultant_id[]'])!!}
                                    </div>
                                    <div class="form-group" id="consultantDetails">

                                    </div>
                                </td>
                            </tr>
                            @php ($count++)
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="step-5" class="">
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModalSupplier'
                                id='modalClick'><i class="fa fa-fw fa-plus"></i> Add supplier account
                        </button>
                    </div>
                    <br><br>
                    <table id="myTable" width="100%" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Supplier Type</th>
                            <th>Select a supplier</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php ($count = 0)
                        @foreach($supplier_types as $type)
                            {{--                            {{$type}}--}}
                            <tr>
                                <td>
                                    {!! Form::text('category_name_disabled', null, ['class'=>'form-control name_list', 'name'=>'category_name[]', 'placeholder' =>  $type->category_name,'disabled']) !!}
                                    {!! Form::text('category_name', $type->id, ['class'=>'form-control name_list hidden', 'name'=>'category_name[]']) !!}

                                </td>
                                <td>
                                    <div class="form-group">
                                        {!! Form::select('supplier_id', ['' => 'Select Supplier Responsible'] + $suppliers, null, ['class'=>'form-control select supplier_select', 'name' => 'supplier_id[]'])!!}
                                    </div>
                                </td>
                            </tr>
                            @php ($count++)
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#smartwizard').smartWizard();
            $('.select').select2();
            // $('#developments').select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        var i = 1;
        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('' +
                '<tr id="row' + i + '" class="dynamic-added">' +
                '  <td class="col-xs-3">{!! Form::text('house_type_name', null, ['class'=>'form-control name_list', 'name'=>'house_type_name[]', 'placeholder' => 'House type name']) !!}</td>' +
                '  <td class="col-xs-3">{!! Form::textarea('house_type_desc', null, ['class'=>'form-control name_list', 'name' => 'house_type_desc[]', 'placeholder' => 'Description']) !!}</td>' +
                '  <td class="col-xs-2"><input type="file" id="floor_plan_' + i + '" name="floor_plan[]" class="form-control"/></td>' +
                '  <td class="col-xs-2"><input type="file" id="house_img' + i + '" name="house_img[]" class="form-control"/></td>' +
                '   <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-fw fa-minus"></i></button></td></tr>'
            );
        });
        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        var x = 1;
        $('#add_phase').click(function () {
            x++;
            $('#dynamic_field_phase').append('' +
                '<tr id="row' + x + '" class="dynamic-added">' +
                '  <td>' +
                '<input type="text" id="phase_name_' + x + '_disabled" name="phase_name[]" class="form-control" placeholder="Phase ' + x + '" disabled/>' +
                '<input type="text" id="phase_name_' + x + '" name="phase_name[]" class="form-control hidden" placeholder="Phase ' + x + '" value="Phase ' + x + '"/>' +
                '</td><td>' +
                '{!! Form::number('phase_num_plots', null, ['class'=>'form-control phase_name_list', 'name'=>'phase_num_plots[]', 'placeholder' => 'Number of plots']) !!}' +
                // '<input id="phase_name_disabled'+i+'" name="phase_name[]" class="form-control"placeholder="Phase "'+x+' disabled/>'+
                // '<input id="phase_name'+i+'" name="phase_name[]" class="form-control" placeholder="Phase "'+x+'"/>'+
                '  </td>' +
                '   <td class="remove_phase"><button type="button" name="remove" id="' + x + '" class="btn btn-danger btn_remove_phase"><i class="fa fa-fw fa-minus"></i></button></td></tr>'
            );
            var previousRow = 'row' + (x - 1);
            // console.log(previousRow);
            $('#' + previousRow).find(".btn_remove_phase").remove();
        });
        $(document).on('click', '.btn_remove_phase', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
            x--;
            $('#row' + x).find('.remove_phase').append('<button type="button" name="remove" id="' + x + '" class="btn btn-danger btn_remove_phase"><i class="fa fa-fw fa-minus"></i></button>')
        });


        $('#addUser').on('click', function (e) {
            e.preventDefault();
            var data = $('form.contact').serialize();

            $.ajax({

                type: "POST",
                url: '/addUser',
                data: data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    console.log('USER ADDED' + data.id + data.name);
                    $('.consultantSelect').append('<option value="' + data.id + '">' + data.name + '(' + data.email + ') </option>');
                    $('#myModal').modal('hide');
                },
                error: function (data) {

                }
            })
        });

        $('#addSupplier').on('click', function (e) {
            e.preventDefault();
            var data = $('form.supplier').serialize();
            // console.log(data);
            $.ajax({

                type: "POST",
                url: '/addUser',
                data: data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    console.log('USER ADDED' + data.id + data.name);
                    $('.supplier_select').append('<option value="' + data.id + '">' + data.name + '(' + data.email + ') </option>');
                    $('#myModalSupplier').modal('hide');
                },
                error: function (data) {

                }
            })
        });

        $('#addEstateAgent').on('click', function (e) {
            e.preventDefault();
            var data = $('form.supplier').serialize();
            // console.log(data);
            $.ajax({

                type: "POST",
                url: '/addUser',
                data: data,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    console.log('USER ADDED' + data.id + data.name);
                    $('.supplier_select').append('<option value="' + data.id + '">' + data.name + '(' + data.email + ') </option>');
                    $('#myModalSupplier').modal('hide');
                },
                error: function (data) {

                }
            })
        });
    </script>
@endsection