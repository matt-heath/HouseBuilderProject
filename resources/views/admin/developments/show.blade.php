@extends('layouts.admin')

@section('title')
    {{--<h1>Developments</h1>--}}
    <h1>{{$development->development_name}}</h1>
@endsection

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

        {{--<div class="col-sm-6">--}}
                {{--<div class="panel-heading"></div>--}}
                {{--<div class="panel-body">--}}
                    <div class="col-md-4 col-sm-12">
                        <a href="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }} " data-lightbox="image-1" data-title="Example development image for: {{$development->development_name}}">
                            <img src="{{$development->photo_id ? $development->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                        </a>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="panel-heading">
                                <div class='page-header' style="margin: 0 !important;">
                                    <div class='btn-toolbar pull-right'>
                                        <div class='btn-group'>
                                            <a href="{{route('admin.developments.edit', $development->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
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
                                            <td><a href="https://www.google.co.uk/maps/place/{{$development->development_location}}" target="_blank"><address>{{$development->development_location}}</address></a></td>
                                        </tr>
                                        <tr>
                                            <td><b>Number of Plots</b></td>
                                            <td>{{$num_of_plots_available->where('development_id', $development->id)->count().'/'.$development->development_num_plots}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Development Description</b></td>
                                            <td>{{$development->development_description}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Nav tabs -->
                            <br>
                            <div class="card card-display">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#plots" aria-controls="plots" role="tab" data-toggle="tab">Plots</a></li>
                                    <li role="presentation"><a href="#housetypes" aria-controls="housetypes" role="tab" data-toggle="tab">House Types</a></li>
                                    <li role="presentation"><a href="#phases" aria-controls="phases" role="tab" data-toggle="tab">Phases</a></li>
                                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
                                </ul>

                                        <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="plots">
                                        <div class="table-responsive">
                                            <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Development Name</th>
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
                                                            <td><a href="{{route('admin.plotsbydevelopment', ['id'=>$plot->development_id])}}">{{$plot->development ? $plot->development->development_name : "Development Not Set"}}</a></td>
                                                            <td>{{$plot->plot_name}}</td>
                                                            <td>{{$plot->houseTypes ? $plot->houseTypes->house_type_name : "NOT FOUND"}}</td>
                                                            <td>{{$plot->sqft}}</td>
                                                            <td>{{$plot->phases ? $plot->phases->phase_name : "SHIT"}}</td>
                                                            <td>{{$plot->status}}</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <a href="{{route('admin.plots.show', $plot->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-eye fa-sm"></i></a>
                                                                </div>
                                                                @if(!$plot->certificates->isEmpty())
                                                                    <div class="btn-group">
                                                                        <a href="{{route('admin.certificates.edit', $plot->id)}}" class="btn btn-warning"><i class="fa fa-fw fa-certificate fa-sm"></i></a>
                                                                    </div>
                                                                @endif
                                                                <div class="btn-group">
                                                                    <a href="{{route('admin.plots.edit', $plot->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
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
                                    <div role="tabpanel" class="tab-pane" id="housetypes">
                                        <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
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
                                                            <a href="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Example house image for: {{$houseType->house_type_name}} ">
                                                                <img src="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                                                            </a>
                                                        </td>
                                                        <td><a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" data-lightbox="image-{{$count}}" data-title="Floor plan image for: {{$houseType->house_type_name}}">
                                                                <img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}" class="img-responsive img-rounded" alt="">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group-vertical">
                                                                <a href="{{route('admin.housetypes.edit', $houseType->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
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
                                    <div role="tabpanel" class="tab-pane" id="phases">
                                        HI
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="settings">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passage..</div>
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
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
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
                    text: 'Plot has been deleted.',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 3000
                }).then(function () {
                    $("#confirm_delete_"+id).off("submit").submit()
                })
                // $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            } else if (result.dismiss === 'cancel') {

            }
        })
        }
    </script>

@endsection

