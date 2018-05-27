@extends('layouts.admin')

@section('title')
    <h1>Create Booking</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Example House Photo</th>
                        <th>Floor Plan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Example house image for: {{$image->house_type_name}}">
                                <img src="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                            </a>
                        </td>
                        <td>
                            <a href="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image" data-title="Floor plan image for: {{$image->house_type_name}}">
                                <img src="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="panel-heading">
                    <div class='page-header' style="margin: 0 !important;">
                        <div class='btn-toolbar pull-right'>
                            <div class='btn-group'>
                                <a href="{{route('admin.plots.edit', $plot->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                        </div>
                        <h3>{{$plot->plot_name}} - Plot Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <td><b>Plot Name</b></td>
                                    <td>{{$plot->plot_name}}</td>
                                </tr>
                                <tr>
                                    <td><b>House Type</b></td>
                                    <td>{{$plot->houseTypes->house_type_name}}</td>
                                </tr>
                                <tr>
                                    <td><b>SqFt</b></td>
                                    <td>{{$plot->sqft ? $plot->sqft : "SqFt not specified."}}</td>
                                </tr>
                                <tr>
                                    <td><b>Plot Phase</b></td>
                                    <td>{{$plot->phase}}</td>
                                </tr>
                                <tr>
                                    <td><b>Plot Status</b></td>
                                    <td>{{$plot->status}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <!-- Nav tabs -->
            <div class="card card-display">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#booking" aria-controls="booking"
                                                              role="tab" data-toggle="tab">Book this plot</a>
                    </li>
                    {{--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>--}}
                    {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>--}}
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="booking">
                        <div class="pull-right">
                            <button type="button" class="btn btn-success" data-toggle='modal' data-target='#myModal' id='modalClick'><i class="fa fa-fw fa-plus"></i> Add user account</button>
                        </div>
                        {!! Form::open(['method'=>'POST', 'action'=>'EstateAgentBookingsController@store', 'data-toggle'=>'validator'])!!}

                        <div class="form-group">
                            {{--{!! Form::label('id', 'ID:')!!}--}}
                            {{--{!! Form::text('id_disabled', $id, ['class'=>'form-control', 'disabled']) !!}--}}
                            {!! Form::text('id', $id, ['class'=>'form-control hidden']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('title', 'Buyer Name:')!!}
                            {!! Form::select('title', [''=>'Choose Title']+ ['Mr'=>'Mr', 'Mrs'=>'Mrs', 'Miss'=>'Miss', 'DR.'=>'DR.'], null, ['class'=>'form-control selectPlot', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('user_id', 'Buyer Name:')!!}
                            {!! Form::select('user_id', [''=>'Choose Buyer'] + $users, null, ['class'=>'form-control selectPlot buyerSelect', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('correspondence_address', 'Correspondence Address')!!}
                            {!! Form::text('correspondence_address', null, ['class'=>'form-control', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('telephone_num', 'Telephone Number:')!!}
                            {!! Form::text('telephone_num', null, ['class'=>'form-control', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('email_address', 'Email Address:')!!}
                            {!! Form::text('email_address_disabled', null, ['class'=>'form-control emailInput', 'disabled']) !!}
                            {!! Form::text('email_address', null, ['class'=>'form-control emailInput hidden', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('buyer_status', 'Buyer Status:')!!}
                            {!! Form::select('buyer_status',[''=> 'Select Buyer Status'] + ['First Time Buyer', 'Owned Previous Properties'] , null, ['class'=>'form-control', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Plot', ['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add User Account</h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['method'=>'POST', 'class'=> 'contact', 'id'=>'contact', 'data-toggle'=>"validator"])!!}
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
                                            {!! Form::select('role_id_disabled', $roles , null, ['class'=>'form-control', 'disabled'])!!}
                                            {!! Form::select('role_id', $roles , null, ['class'=>'form-control hidden'])!!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('is_active', 'Status:') !!}
                                            {!! Form::select('is_active', array(1 => 'Active', 0=> 'Not Active'), 1 , ['class'=>'form-control select', 'required'])!!}
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
                                        {!! Form::button('Add account', ['class'=>'btn btn-primary', 'data-role' => "button",  'id' => 'addUser']) !!}
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('.selectPlot').select2();

            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();

            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                $active.next().removeClass('disabled');
                nextTab($active);
            });
            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });

            $('#addUser').on('click', function (e) {
                e.preventDefault();
                var data = $('form.contact').serialize();

                console.log(data);
                $.ajax({

                    type:"POST",
                    url:'/addBuyer',
                    data: data,
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        console.log('USER ADDED'+ data.id + data.name);
                        $('#myModal').modal('hide');
                        $('.buyerSelect').append('<option value="'+ data.id + '" selected="selected">' + data.name +'('+data.email+') </option>');
                        // location.reload();
                        // table.ajax.reload();
                        // table.ajax.url( '/getUsers' ).load();
                        var buyer_id = $('.buyerSelect').val();

                        findUsersEmail(buyer_id);
                    },
                    error: function(data){

                    }
                })
            });
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

        //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        $(document).on('change', '.buyerSelect', function () {
            // console.log("Changed");
            var buyer_id = $(this).val();
            findUsersEmail(buyer_id);

        });

        function findUsersEmail(buyer_id){

            var option = "";

            $.ajax({
                type: 'get',
                url: '{!! URL::to('findUsersEmail') !!}',
                data: {'id': buyer_id},
                success: function (data) {
                    // console.log('Success!!');
                    // console.log(data);

                    $(".emailInput").html(data).val(data);
                },
                error: function () {
                    console.log("Failed...")
                }
            })
        }
    </script>
@endsection
