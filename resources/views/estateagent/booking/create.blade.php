@extends('layouts.admin')

@section('content')

    <h1>Create Booking</h1>
    {{-- Wizard found and adapted from https://bootsnipp.com/snippets/featured/form-wizard-using-tabs --}}

    <table class="table">
       <thead>
         <tr>
          <th>Development Name</th>
          <th>Lastname</th>
          <th>Email</th>
         </tr>
       </thead>
       <tbody>
         <tr>
           <td>{{}}</td>
           <td>Doe</td>
           <td>john@example.com</td>
         </tr>
       </tbody>
    </table>


    <div class="row">
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="fa fa-home"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="fa fa-building"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="fa fa-map-marker"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            {!! Form::open(['method'=>'POST', 'action'=>'EstateAgentBookingsController@store'])!!}
            <div class="tab-content">
                <div class="tab-pane active" role="tabpanel" id="step1">
                    <div class="step1">
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('id', 'ID:')!!}
                                {!! Form::text('id_disabled', $id, ['class'=>'form-control', 'disabled']) !!}
                                {!! Form::text('id', $id, ['class'=>'form-control hidden']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('title', 'Buyer Name:')!!}
                                {!! Form::select('title', ['Mr'=>'Mr', 'Mrs'=>'Mrs', 'Miss'=>'Miss', 'DR.'=>'DR.'], null, ['class'=>'form-control selectPlot']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('user_id', 'Buyer Name:')!!}
                                {!! Form::select('user_id', [''=>'Choose Buyer'] + $users, null, ['class'=>'form-control selectPlot']) !!}
                            </div>
                        </div>
                    </div>
                    <ul class="list-inline pull-right">
                        <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                    </ul>
                </div>
                <div class="tab-pane" role="tabpanel" id="step2">
                    <div class="step2">
                        <div class="step_21">
                            <div class="row">
                                <div class="form-group">
                                    {!! Form::label('correspondence_address', 'Correspondence Address')!!}
                                    {!! Form::text('correspondence_address', null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('telephone_num', 'Telephone Number:')!!}
                                    {!! Form::text('telephone_num', null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('email_address', 'Email Address:')!!}
                                    {!! Form::email('email_address', null, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('buyer_status', 'Buyer Status:')!!}
                                    {!! Form::select('buyer_status',['First Time Buyer'] , null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Create Plot', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
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
        });

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }
    </script>
@endsection
