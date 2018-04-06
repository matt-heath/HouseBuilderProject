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
                    <th>House Photo</th>
                    <th>Floor Plan</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a href="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}"
                           data-lightbox="image" data-title="Example house image for: {{$image->house_type_name}}">
                            <img src="{{$image->house_img ? $image->house_photo->file : 'http://placehold.it/400x400' }}"
                                 class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                    <td>
                        <a href="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}"
                           data-lightbox="image" data-title="Floor plan image for: {{$image->house_type_name}}">
                            <img src="{{$image->floor_plan ? $image->photo->file : 'http://placehold.it/400x400' }}"
                                 class="img-responsive img-rounded" alt="">
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card card-display">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#plot" aria-controls="plot" role="tab"
                                                              data-toggle="tab">Your Plot Details</a></li>
                    <li role="presentation"><a href="#accountDetails" aria-controls="accountDetails" role="tab"
                                               data-toggle="tab">Plot Booking Details</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="plot">
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
                                    <td>{{$plot->phases->phase_name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Plot Status</b></td>
                                    <td>{{$plot->status}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="accountDetails">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped table-hover table-bordered">
                                <tbody>
                                <tr>
                                    {{--{{$booking}}--}}
                                    <td><b>Name</b></td>
                                    <td>{{$booking->title." ".$booking->user->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Correspondence Address</b></td>
                                    <td>
                                        <address>{{$booking->correspondence_address}}</address>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Telephone Number</b></td>
                                    <td>{{$booking->telephone_num}}</td>
                                </tr>
                                <tr>
                                    <td><b>Email Address</b></td>
                                    <td>{{$booking->email_address}}</td>
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
            <br>

            <div class="card card-display">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#selections" aria-controls="selections"
                                                              role="tab"
                                                              data-toggle="tab">Your Selections</a></li>

                </ul>

                <!-- Tab panes -->

                {!! Form::open(array('action' => 'VariationController@assignToHouseType', 'method' => 'post')); !!}
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="selections">
                        <div class="row">
                            <div class='btn-toolbar pull-left'>
                                <div class='btn-group'>
                                    <a href="{{route('buyer.variations.edit', $booking->id)}}"
                                       class="btn btn-primary">Edit your selections <i
                                                class="fa fa-fw fa-edit fa-sm"></i></a>
                                </div>
                            </div>
                        </div>

                        {{--{{$booking->variations}}--}}
                        <div class="row">
                            <br>
                            <div class="table-responsive">
                                <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Variation Name</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--@foreach($value->variations as $variation)--}}
                                    {{--{{$variation}}--}}


                                    {{--{{$houseType}}--}}
                                    {{--{{$houseType->variations()->variation_id}}--}}
                                    @php($count1 = 0)
                                    @foreach($booking->variations as $value)
                                        @foreach($value->selectionType as $type)
                                            {{--{{$type->type_name}}--}}
                                            @php($typeName = $type->type_name)
                                        @endforeach
                                        <tr>
                                            <td>{{$value->name}}</td>
                                            <td>{{$typeName}}</td>
                                            <td>{{$value->description}}</td>
                                            <td>£{{$value->price}}</td>
                                            <td>
                                                <a href="{{$value->extra_img ? $value->photo->file : 'http://placehold.it/400x400' }} "
                                                   data-lightbox="image-1"
                                                   data-title="Example image for: {{$value->name}}">
                                                    <img src="{{$value->extra_img ? $value->photo->file : 'http://placehold.it/400x400' }}"
                                                         class="img-responsive img-rounded" alt=""
                                                         style="max-height: 50px; max-width: 50px;">
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    {!! Form::text('house_type_id', $houseType->id, ['class'=>'form-control hidden', 'name'=>'house_type_id']) !!}
                                </div>
                            </div>
                        </div>


                        {{--@foreach($booking->variations as $value)--}}

                        {{--{{$value}}--}}
                        {{--@endforeach--}}
                        {{--@foreach($value->variations as $variation)--}}
                        {{--{{$variation}}--}}
                        {{--@foreach($variation->selectionType as $type)--}}
                        {{--                                            {{$type->type_name}}--}}
                        {{--@php($typeName = $type->type_name)--}}
                        {{--<div class="panel-group" id="accordion">--}}
                        {{--<div class="panel panel-default">--}}
                        {{--<div class="panel-heading">--}}
                        {{--<h4 class="panel-title">--}}
                        {{--<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">--}}
                        {{--{{$typeName}}</a>--}}
                        {{--</h4>--}}
                        {{--</div>--}}
                        {{--<div id="collapse1" class="panel-collapse collapse in">--}}
                        {{--<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,--}}
                        {{--sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad--}}
                        {{--minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea--}}
                        {{--commodo consequat.</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@endforeach--}}
                        {{--@endforeach--}}
                        {{--<div class="table-responsive">--}}
                        {{--<table id="myTable" width="100%" class="table table-striped table-bordered table-hover">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                        {{--<th></th>--}}
                        {{--<th>Variation Name</th>--}}
                        {{--<th>Type</th>--}}
                        {{--<th>Description</th>--}}
                        {{--<th>Price</th>--}}
                        {{--<th>Status</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--@foreach($value->variations as $variation)--}}
                        {{--{{$variation}}--}}
                        {{--@foreach($variation->selectionType as $type)--}}
                        {{--                                            {{$type->type_name}}--}}
                        {{--@php($typeName = $type->type_name)--}}
                        {{--@endforeach--}}

                        {{--{{$houseType}}--}}
                        {{--{{$houseType->variations()->variation_id}}--}}
                        {{--<tr>--}}
                        {{--@if(in_array($variation->id, $items))--}}
                        {{--<td>{!! Form::checkbox('variations[]', $variation->id, true); !!}</td>--}}

                        {{--@else--}}
                        {{--<td>{!! Form::checkbox('variations[]', $variation->id); !!}</td>--}}
                        {{--@endif--}}

                        {{--<td>{{$val}}</td>--}}
                        {{--@foreach($val->var_id as $value)--}}
                        {{--{{$value}}--}}
                        {{--@endforeach--}}


                        {{--@if(in_array($variation->id, $items) )--}}
                        {{--<td>{{"HI"}}</td>--}}
                        {{--@endif--}}

                        {{--<td>{{$typeName}}</td>--}}
                        {{--<td>{{$variation->name}}</td>--}}
                        {{--<td>{{$variation->description}}</td>--}}
                        {{--<td>£{{$variation->price}}</td>--}}
                        {{--<td>--}}
                        {{--<a href="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }} "--}}
                        {{--data-lightbox="image-1"--}}
                        {{--data-title="Example image for: {{$variation->name}}">--}}
                        {{--<img src="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }}"--}}
                        {{--class="img-responsive img-rounded" alt="">--}}
                        {{--</a>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                        {{--</table>--}}
                        {{--<div class="form-group">--}}
                        {{--{!! Form::text('house_type_id', $houseType->id, ['class'=>'form-control hidden', 'name'=>'house_type_id']) !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                {{--{!! Form::submit('Next'); !!}--}}
                {{--{!! Form::close(); !!}--}}
                @php($count1++)
                {{--@endforeach--}}
            </div>
            {{--<div role="tabpanel" class="tab-pane" id="timeline">--}}
                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<i class="fa fa-clock-o fa-fw"></i> Responsive Timeline--}}
                    {{--</div>--}}
                    {{--<!-- /.panel-heading -->--}}
                    {{--<div class="panel-body">--}}
                        {{--<ul class="timeline">--}}
                            {{--<li>--}}
                                {{--<div class="timeline-badge"><i class="fa fa-check"></i>--}}
                                {{--</div>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                        {{--<p>--}}
                                            {{--<small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via--}}
                                                {{--Twitter--}}
                                            {{--</small>--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero laboriosam--}}
                                            {{--dolor perspiciatis omnis exercitationem. Beatae, officia pariatur? Est cum--}}
                                            {{--veniam excepturi. Maiores praesentium, porro voluptas suscipit facere rem--}}
                                            {{--dicta, debitis.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="timeline-inverted">--}}
                                {{--<div class="timeline-badge warning"><i class="fa fa-credit-card"></i>--}}
                                {{--</div>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolorem--}}
                                            {{--quibusdam, tenetur commodi provident cumque magni voluptatem libero, quis--}}
                                            {{--rerum. Fugiat esse debitis optio, tempore. Animi officiis alias, officia--}}
                                            {{--repellendus.</p>--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium maiores--}}
                                            {{--odit qui est tempora eos, nostrum provident explicabo dignissimos debitis--}}
                                            {{--vel! Adipisci eius voluptates, ad aut recusandae minus eaque facere.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div class="timeline-badge danger"><i class="fa fa-bomb"></i>--}}
                                {{--</div>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus numquam--}}
                                            {{--facilis enim eaque, tenetur nam id qui vel velit similique nihil iure--}}
                                            {{--molestias aliquam, voluptatem totam quaerat, magni commodi quisquam.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="timeline-inverted">--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates est--}}
                                            {{--quaerat asperiores sapiente, eligendi, nihil. Itaque quos, alias sapiente--}}
                                            {{--rerum quas odit! Aperiam officiis quidem delectus libero, omnis ut--}}
                                            {{--debitis!</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div class="timeline-badge info"><i class="fa fa-save"></i>--}}
                                {{--</div>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis minus modi--}}
                                            {{--quam ipsum alias at est molestiae excepturi delectus nesciunt, quibusdam--}}
                                            {{--debitis amet, beatae consequuntur impedit nulla qui! Laborum, atque.</p>--}}
                                        {{--<hr>--}}
                                        {{--<div class="btn-group">--}}
                                            {{--<button type="button" class="btn btn-primary btn-sm dropdown-toggle"--}}
                                                    {{--data-toggle="dropdown">--}}
                                                {{--<i class="fa fa-gear"></i> <span class="caret"></span>--}}
                                            {{--</button>--}}
                                            {{--<ul class="dropdown-menu" role="menu">--}}
                                                {{--<li><a href="#">Action</a>--}}
                                                {{--</li>--}}
                                                {{--<li><a href="#">Another action</a>--}}
                                                {{--</li>--}}
                                                {{--<li><a href="#">Something else here</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="divider"></li>--}}
                                                {{--<li><a href="#">Separated link</a>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi fuga odio--}}
                                            {{--quibusdam. Iure expedita, incidunt unde quis nam! Quod, quisquam. Officia--}}
                                            {{--quam qui adipisci quas consequuntur nostrum sequi. Consequuntur,--}}
                                            {{--commodi.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            {{--<li class="timeline-inverted">--}}
                                {{--<div class="timeline-badge success"><i class="fa fa-graduation-cap"></i>--}}
                                {{--</div>--}}
                                {{--<div class="timeline-panel">--}}
                                    {{--<div class="timeline-heading">--}}
                                        {{--<h4 class="timeline-title">Lorem ipsum dolor</h4>--}}
                                    {{--</div>--}}
                                    {{--<div class="timeline-body">--}}
                                        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt obcaecati,--}}
                                            {{--quaerat tempore officia voluptas debitis consectetur culpa amet, accusamus--}}
                                            {{--dolorum fugiat, animi dicta aperiam, enim incidunt quisquam maxime neque--}}
                                            {{--eaque.</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<!-- /.panel-body -->--}}
                {{--</div>--}}
            {{--</div>--}}
            <div role="tabpanel" class="tab-pane" id="phases">
                HI0
            </div>

            <div role="tabpanel" class="tab-pane" id="suppliers">

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    {"orderable": false, "targets": 2}
                ]

            });
        });

        function modalClick() {

        }

        $('.modalClick').on('click', function () {

            console.log($(this).data());

            $('.modalPlot').attr('action', '/admin/certificates/' + $(this).data('id'));
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
                        $("#confirm_delete_" + id).off("submit").submit()
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

