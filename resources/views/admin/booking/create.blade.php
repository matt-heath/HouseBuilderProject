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
        {!! Form::open(['method'=>'POST', 'action'=>'EstateAgentBookingsController@store'])!!}

        <div class="form-group">
            {{--{!! Form::label('id', 'ID:')!!}--}}
            {{--{!! Form::text('id_disabled', $id, ['class'=>'form-control', 'disabled']) !!}--}}
            {!! Form::text('id', $id, ['class'=>'form-control hidden']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('title', 'Buyer Name:')!!}
            {!! Form::select('title', ['Mr'=>'Mr', 'Mrs'=>'Mrs', 'Miss'=>'Miss', 'DR.'=>'DR.'], null, ['class'=>'form-control selectPlot']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('user_id', 'Buyer Name:')!!}
            {!! Form::select('user_id', [''=>'Choose Buyer'] + $users, null, ['class'=>'form-control selectPlot buyerSelect']) !!}
        </div>
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
            {!! Form::text('email_address_disabled', null, ['class'=>'form-control emailInput', 'disabled']) !!}
            {!! Form::text('email_address', null, ['class'=>'form-control emailInput hidden']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('buyer_status', 'Buyer Status:')!!}
            {!! Form::select('buyer_status',['First Time Buyer'] , null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Create Plot', ['class'=>'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
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

        //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
        $(document).on('change', '.buyerSelect', function(){
            // console.log("Changed");
            var buyer_id=$(this).val();
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
        });
    </script>
@endsection
