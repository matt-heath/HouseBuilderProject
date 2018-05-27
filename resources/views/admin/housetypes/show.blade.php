@extends('layouts.admin')

@section('title')
    {{--<h1>Developments</h1>--}}
    <h1>{{$houseType->house_type_name}}</h1>
@endsection

@section('content')

    @if(Session::has('deleted_development'))
        <p class="bg-danger">{{session('deleted_development')}}</p>
    @endif

    {{--<div class="btn-group-vertical">--}}
    {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminHouseTypesController@destroy', $houseType->id], 'id'=> 'confirm_delete_'.$houseType->id]) !!}--}}
    {{--{!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$houseType->id .')']) !!}--}}
    {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    {{--</td>--}}
    {{--</tr>--}}

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
                    <a href="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}"
                       data-lightbox="image" data-title="Example house image for: {{$houseType->house_type_name}} ">
                        <img src="{{$houseType->house_img ? $houseType->house_photo->file : 'http://placehold.it/400x400' }}"
                             class="img-responsive img-rounded" alt="">
                    </a>
                </td>
                <td>
                    <a href="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}"
                       data-lightbox="image" data-title="Floor plan image for: {{$houseType->house_type_name}}">
                        <img src="{{$houseType->floor_plan ? $houseType->photo->file : 'http://placehold.it/400x400' }}"
                             class="img-responsive img-rounded" alt="">
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
                            <a href="{{route('admin.housetypes.edit', $houseType->id)}}" class="btn btn-primary"><i
                                        class="fa fa-fw fa-edit fa-sm"></i></a>
                        </div>
                    </div>
                    <h3>{{$houseType->house_type_name}} - House Type Details</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-striped table-hover table-bordered">
                        <tbody>
                        <tr>
                            <td><b>Development Name</b></td>
                            <td>{{$houseType->development_id ? $houseType->development->development_name : "Development Not Set" }}</td>
                        </tr>
                        <tr>
                            <td><b>House Type Description</b></td>
                            <td>{{$houseType->house_type_desc}}</td>
                        </tr>
                        {{--<tr>--}}
                        {{--<td><b>Number of Plots</b></td>--}}
                        {{--<td>{{$num_of_plots_available->where('development_id', $development->id)->count().'/'.$development->development_num_plots}}</td>--}}
                        {{--</tr>--}}
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
                    @php($first = true)
                    @php($count = 0)
                    @foreach($assignedSuppliers as $value)
                        {{--{{$value}}--}}
                        @if($first)
                            <li role="presentation" class="active"><a
                                        href="#{{$value->selectionCategory->category_name}}"
                                        aria-controls="{{$value->selectionCategory->category_name}}"
                                        role="tab"
                                        data-toggle="tab">{{$value->selectionCategory->category_name}}
                                    ({{$value->supplier_company_name}})</a></li>
                            @php($first = false)
                            @php($count++)
                        @else
                            <li role="presentation"><a href="#{{$value->selectionCategory->category_name}}"
                                                       aria-controls="{{$value->selectionCategory->category_name}}"
                                                       role="tab"
                                                       data-toggle="tab">{{$value->selectionCategory->category_name}}
                                    ({{$value->supplier_company_name}})</a></li>
                            @php($count++)
                        @endif
                    @endforeach
                </ul>

                <!-- Tab panes -->

                @php($count1 = 0)
                {!! Form::open(array('action' => 'VariationController@assignToHouseType', 'method' => 'post')); !!}
                <div class="tab-content">
                    @php($firstTab = true)
                    @foreach($assignedSuppliers as $value)
                        @if($firstTab)
                            <div role="tabpanel" class="tab-pane active"
                                 id="{{$value->selectionCategory->category_name}}">
                                @php($firstTab = false)
                                @else
                                    <div role="tabpanel" class="tab-pane"
                                         id="{{$value->selectionCategory->category_name}}">
                                        @endif
                                        <div class="table-responsive">
                                            <table id="myTable" width="100%"
                                                   class="table table-striped table-bordered table-hover myTable">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Variation Name</th>
                                                    <th>Type</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($value->variations as $variation)
                                                    {{--{{$variation}}--}}
                                                    @foreach($variation->selectionType as $type)
                                                        {{--{{$type->type_name}}--}}
                                                        @php($typeName = $type->type_name)
                                                    @endforeach

                                                    {{--{{$houseType}}--}}
                                                    {{--{{$houseType->variations()->variation_id}}--}}
                                                    <tr>
                                                        @if(in_array($variation->id, $items))
                                                            <td>{!! Form::checkbox('variations[]', $variation->id, true); !!}</td>

                                                        @else
                                                            <td>{!! Form::checkbox('variations[]', $variation->id); !!}</td>
                                                        @endif

                                                        {{--<td>{{$val}}</td>--}}
                                                        {{--@foreach($val->var_id as $value)--}}
                                                        {{--{{$value}}--}}
                                                        {{--@endforeach--}}


                                                        {{--@if(in_array($variation->id, $items) )--}}
                                                        {{--<td>{{"HI"}}</td>--}}
                                                        {{--@endif--}}

                                                        <td>{{$typeName}}</td>
                                                        <td>{{$variation->name}}</td>
                                                        <td>{{$variation->description}}</td>
                                                        <td>£{{$variation->price}}</td>
                                                        <td>
                                                            <a href="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }} "
                                                               data-lightbox="image-1"
                                                               data-title="Example image for: {{$variation->name}}">
                                                                <img src="{{$variation->extra_img ? $variation->photo->file : 'http://placehold.it/400x400' }}"
                                                                     class="img-responsive img-rounded" alt="">
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
                                    @php($count1++)
                                    @endforeach
                            </div>
                </div>
            </div>
        </div>
        {!! Form::submit('Next'); !!}
        {!! Form::close(); !!}
        @endsection

        @section('script')

            <script>
                $(document).ready(function () {
                    var table = $('.myTable').DataTable({
                        // responsive: true,
                        "columnDefs": [
                            {"orderable": false, "targets": [0, 4]}
                            // {"orderable" : false, "className": 'select-checkbox', 'targets': 0}
                        ],
                        // select: {
                        //     style:    'multi',
                        //     selector: 'td:first-child'
                        // },
                        // order: [[ 1, 'asc' ]]

                    });
                    // $('#myTable tbody').on( 'click', 'tr', function () {
                    //     $(this).toggleClass('selected');
                    // } );
                    //
                    // $('#button').click( function () {
                    //     alert( table.rows('.selected').data().length +' row(s) selected' );
                    // } );
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

