@extends('layouts.admin')

@section('title')
    {{--<h1>Developments</h1>--}}
    <h1>{{$plot->plot_name}}</h1>
@endsection

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <table class="table table-responsive">
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
                        <table class="table table-responsive table-striped table-hover table-bordered">
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

    <div class="row">
        <div class="col-sm-12">
            <!-- Nav tabs -->
            <div class="card card-display">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#certificates" aria-controls="certificates" role="tab" data-toggle="tab">Certificate Management</a></li>
                    <li role="presentation"><a href="#booking" aria-controls="booking" role="tab" data-toggle="tab">Plot Booking Details</a></li>
                    {{--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>--}}
                    {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>--}}
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="certificates">
                        <div class="table-responsive">
                            <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Certificate Name</th>
                                    <th>Build Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($certificates as $certificate)
                                    {{--{{$certificate}}--}}
                                    <tr>
                                        <td>{{$certificate->certificatesRequired[0]->certificate_name}}</td>
                                        <td>{{$certificate->build_status}}</td>
                                        <td>{!! "<a href='' data-toggle='modal' data-target='#myModal' id='modalClick' class='modalClick' data-id='$certificate->id'>Update Status</a>"!!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="booking">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Property ready to be inspected?</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model($certificate, ['method'=>'PATCH', 'class'=> 'modalPlot', 'action'=>['AdminCertificatesController@update', $certificate->id]])!!}

                    <div class="form-group">
                        {{ Form::label('status', 'Can the consultant inspect this aspect of the property?') }}
                        <div class="form-inline">
                            <div class="radio">
                                {{ Form::radio('status', 'yes') }}
                                {{ Form::label('yes', 'Yes') }}
                            </div>
                            <div class="radio">
                                {{ Form::radio('status', 'no', true) }}
                                {{ Form::label('no', 'No') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        {!! Form::submit('Update status', ['class'=>'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                    { "orderable": false, "targets": 2 }
                ]

            });
        });

        function modalClick() {

        }

        $('.modalClick').on('click', function () {

            console.log($(this).data());

            $('.modalPlot').attr('action', '/admin/certificates/'+$(this).data('id'));
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

