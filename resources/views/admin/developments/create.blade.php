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
    </div>
    <div class="row">

        {!! Form::open(['method'=>'POST', 'action'=>'AdminDevelopmentsController@store', 'files' => true])!!}
        <div id="smartwizard">
            <ul>
                <li><a href="#step-1">Create Development<br /><small>Input development details</small></a></li>
                <li><a href="#step-2">Add House Types<br /><small>Input house type details</small></a></li>
                <li><a href="#step-3">Assign Consultants to Development<br /><small>Input consultant details</small></a></li>
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

                    <div class="form-group">
                        {!! Form::label('development_num_plots', 'Number of Plots:')!!}
                        {!! Form::number('development_num_plots', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('development_description', 'Development Description:')!!}
                        {!! Form::text('development_description', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('photo_id', 'Example Development Photo:')!!}
                        {!! Form::file('photo_id', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div id="step-2" class="">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dynamic_field">
                            <tr>
                                <td class="col-xs-3">{!! Form::text('house_type_name', null, ['class'=>'form-control name_list', 'name'=>'house_type_name[]', 'placeholder' => 'House type name']) !!}</td>
                                <td class="col-xs-3">{!! Form::textarea('house_type_desc', null, ['class'=>'form-control name_list', 'name' => 'house_type_desc[]', 'placeholder' => 'Description']) !!}</td>
                                {{--<td class="col-xs-2">{!! Form::file('floor_plan', null, ['class'=>'form-control', 'name'=>'floor_plan[]', 'id'=>'floor_plan_0', 'placeholder'=>'']) !!}</td>--}}
                                {{--<td class="col-xs-2">{!! Form::file('house_img', null, ['class'=>'form-control', 'name'=>'house_img[]', 'id'=>'house_img_0', 'placeholder'=>'']) !!}</td>--}}
                                <td class="col-xs-2"><input type="file" id="floor_plan_0" name="floor_plan[]" class="form-control"/></td>
                                <td class="col-xs-2"><input type="file" id="house_img_0" name="house_img[]" class="form-control" /></td>
                                <td><button type="button" name="add" id="add" class="btn btn-success"><i class="fa fa-fw fa-plus"></i></button></td>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="step-3" class="">
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal' id='modalClick'><i class="fa fa-fw fa-plus"></i> Add consultant account</button>
                    </div>
                    <br><br>
                    <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
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
                                        {{$certificate->name}}
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {!! Form::select('consultant_id_'.$count, ['' => 'Select Constulant'] + $consultants, null, ['class'=>'form-control consultantSelect select'])!!}
                                        </div>
                                        <div class="form-group" id="consultantDetails">

                                        </div>
                                    </td>
                                </tr>
                                @php ($count++)
                            @endforeach
                        </tbody>
                    </table>
                    {!! Form::submit('Create Development', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
                {{--<div id="step-4" class="">--}}
                    {{--Step Content--}}
                {{--</div>--}}
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#smartwizard').smartWizard();
            $('.select').select2();
            // $('#developments').select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('' +
                '<tr id="row'+i+'" class="dynamic-added">' +
                '  <td class="col-xs-3">{!! Form::text('house_type_name', null, ['class'=>'form-control name_list', 'name'=>'house_type_name[]', 'placeholder' => 'House type name']) !!}</td>'+
                '  <td class="col-xs-3">{!! Form::textarea('house_type_desc', null, ['class'=>'form-control name_list', 'name' => 'house_type_desc[]', 'placeholder' => 'Description']) !!}</td>'+
                '  <td class="col-xs-2"><input type="file" id="floor_plan_'+i+'" name="floor_plan[]" class="form-control"/></td>'+
                '  <td class="col-xs-2"><input type="file" id="house_img'+i+'" name="house_img[]" class="form-control"/></td>'+
                '   <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"><i class="fa fa-fw fa-minus"></i></button></td></tr>'
            );
        });
        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });


        $('#addUser').on('click', function (e) {
            e.preventDefault();
            var data = $('form.contact').serialize();

            $.ajax({

                type:"POST",
                url:'/addUser',
                data: data,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    console.log('USER ADDED'+ data.id + data.name);
                    $('.consultantSelect').append('<option value="'+ data.id + '" selected="selected">' + data.name +'('+data.email+') </option>');
                    $('#myModal').modal('hide');



                },
                error: function(data){

                }
            })
        });
    </script>
@endsection