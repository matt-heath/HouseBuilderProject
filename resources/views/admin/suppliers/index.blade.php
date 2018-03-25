@extends('layouts.admin')

@section('title')
    <h1>All Suppliers</h1>
@endsection

@section('content')
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

    {{--{{count($consultant_names)}}--}}
    <div class="row">
        <div class="col-sm-12">
            @if($suppliers)
                {{--{{$suppliers}}--}}
                <table class="table" id="myTable">
                    <thead>
                    <tr>
                        <th>Supplier Contact</th>
                        <th>Supplier Name</th>
                        <th>Supplier Type</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($suppliers as $supplier)
                        {{--{{$plot->phases ? $plot->phases->plot_name : "NOT FOUND"}}--}}
                        <tr>
                            <td>{{$supplier->user->name}}</td>
                            <td>{{$supplier->supplier_company_name}}</td>
                            <td>{{$supplier->selectionCategory->category_name}}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('admin.suppliers.show', $supplier->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a href="{{route('admin.suppliers.edit', $supplier->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                                </div>
                                <div class="btn-group">
                                    {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminPlotsController@destroy', $supplier->id], 'id'=> 'confirm_delete_'.$supplier->id]) !!}
                                    {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$supplier->id .')']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            // e.preventDefault();
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 3 }
                ]

            });
            // $('#smartwizard').smartWizard();
            // $('.consultantSelect').select2();
            // $('.selectPlot').select2();
            // $('.selectMultiple').select2();

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

        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Adapted from: https://gitlab.com/Bons/laravel5.3_dynamic_dropdown/blob/master/readme.md
            $(document).on('change', '.developmentSelect', function(){
                // console.log("Changed");

                var dev_id=$(this).val();
                console.log(dev_id);
                // var option = "";
                var phase_option = "";

                {{--$.ajax({--}}
                    {{--type: 'get',--}}
                    {{--url: '{!! URL::to('getHouseTypes') !!}',--}}
                    {{--data: {'id': dev_id},--}}
                    {{--success: function (data) {--}}
                        {{--console.log('Success!!');--}}
                        {{--console.log(data);--}}
                        {{--console.log(data.length);--}}
                        {{--if(data.length != 0){--}}
                            {{--$(".houseTypeSelect").prop("disabled", false);--}}
                            {{--option +='<option value="" selected disabled>Choose House Type</option>';--}}
                        {{--}else{--}}
                            {{--$(".houseTypeSelect").prop("disabled", true);--}}
                            {{--option +='<option value="" selected disabled>No House types available - Create one!</option>';--}}
                        {{--}--}}

                        {{--for(var i = 0; i < data.length; i++){--}}
                            {{--option+='<option value="'+data[i].id+'">'+data[i].house_type_name+'</option>';--}}
                        {{--}--}}


                        {{--$(".houseTypeSelect").html(" ").append(option);--}}
                        {{--$("#typeSelect").removeClass("hidden");--}}

                        {{--// console.log(option);--}}

                    {{--},--}}
                    {{--error: function () {--}}
                        {{--console.log("Failed...")--}}
                    {{--}--}}
                {{--});--}}
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('getPhases') !!}',
                    data: {'id': dev_id},
                    success: function (phases) {
                        console.log('Success!!');
                        console.log(phases);
                        console.log(phases.length);
                        if(phases.length != 0){
                            phase_option +='<option value="" selected disabled>Choose Development Phase</option>';
                        }else{
                            phase_option +='<option value="" selected disabled>No phases available - Create one!</option>';
                        }

                        for(var i = 0; i < phases.length; i++){
                            phase_option+='<option value="'+phases[i].id+'">'+phases[i].phase_name+'</option>';
                        }


                        $(".phaseSelect").html(" ").append(phase_option);
                        $("#phaseSelect").removeClass("hidden");

                        console.log(phase_option);

                    },
                    error: function () {
                        console.log("Failed...")
                    }
                })
            });

            $(document).on('change', '.phaseSelect', function(){
                console.log("Changed");

                var phase_id=$(this).val();
                console.log(phase_id);
                var option = "";
                var dataObject = JSON.stringify({
                    'phase_id': $(this).val(),
                    'development_id': $('.developmentSelect').val(),
                });

                var development_id = $('.developmentSelect').val();

                // console.log(dataObject);

                {{--$.ajax({--}}
                    {{--type: 'get',--}}
                    {{--url: '{!! URL::to('findPlots') !!}',--}}
                    {{--data: {'id': phase_id, 'dev_id': development_id },--}}
                    {{--success: function (data) {--}}
                        {{--console.log('Success!!');--}}
                        {{--console.log(data);--}}
                        {{--console.log(data.length);--}}
                        {{--if(data.length == 0){--}}
                            {{--$(".plotSelect").prop("disabled", false);--}}
                            {{--option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';--}}
                            {{--option +='{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect', 'placeholder'=>'No plots available to assign to']) !!}';--}}

                        {{--}else{--}}
                            {{--$(".plotSelect").prop("disabled", true);--}}
                            {{--option += '{!! Form::label('selected_plots', 'Number of plots to assign to:')!!}';--}}
                            {{--option += '{!! Form::number('selected_plots', null, ['class'=>'form-control plotSelect']) !!}';--}}
                        {{--}--}}

                        {{--// for(var i = 0; i < data.length; i++){--}}
                        {{--//     option+='<option value="'+data[i].plot_name_id+'">'+data[i].plot_name_id+'</option>';--}}
                        {{--// }--}}


                        {{--$("#plotSelect").html(" ").append(option);--}}
                        {{--$("#plotSelect").removeClass("hidden");--}}

                        {{--// console.log(option);--}}

                    {{--},--}}
                    {{--error: function () {--}}
                        {{--console.log("Failed...")--}}
                    {{--}--}}
                {{--})--}}
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
                        $('.consultantSelect').append('<option value="'+ data.id + '">' + data.name +'('+data.email+') </option>');
                        $('#myModal').modal('hide');
                        $('#myModal form :input').val("");
                    },
                    error: function(data){

                    }
                })
            });
        });
    </script>

@endsection
