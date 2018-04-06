@extends('layouts.admin')

@section('title')
    <h1>Edit Selections</h1>
@endsection


@section('content')
    {!! Form::open(array('action' => 'VariationController@assignToHouseType', 'method' => 'post')); !!}
    {{--<div class="tab-content">--}}
    {{--<div role="tabpanel" class="tab-pane active" id="{{$count1}}">--}}
    {{--<div class='btn-toolbar pull-right'>--}}
    {{--<div class='btn-group'>--}}
    {{--<a href="{{route('buyer.variations.edit', $booking->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>--}}
    {{--</div>--}}
    {{--</div>--}}
    @php($count1 = 0)
    @php($first = true)
    @foreach($selectionCategories as $category)

        <div class="panel-group" id="{{$category->category_name}}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#{{$category->category_name}}" href="#{{$count1}}">
                            {{$category->category_name}}</a>
                    </h4>
                </div>
                <div id="{{$count1}}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="card card-display">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach($variation_ids as $value)
                                    @php($selection_category = $value->supplier->selectionCategory)
                                    @if($category == $selection_category)
                                        {{--{{$value->selectionType}}--}}
                                        @php($count = 0)
                                        @foreach($value->selectionType as $type)
                                            @if($first)

                                                <li role="presentation" class="active"><a href="#{{$type->type_name}}"
                                                                                          aria-controls="{{$type->type_name}}"
                                                                                          role="tab"
                                                                                          data-toggle="tab">{{$type->type_name}}
                                                    </a></li>
                                                @php($first = false)
                                                @php($count++)
                                            @else
                                                <li role="presentation"><a href="#{{$type->type_name}}"
                                                                           aria-controls="{{$type->type_name}}"
                                                                           role="tab"
                                                                           data-toggle="tab">{{$type->type_name}}
                                                    </a></li>
                                                @php($count++)
                                            @endif
                                            {{--                                        {{$value. "FOR ". $type->type_name}}--}}



                                            {{--<h3>{{$type->type_name}}</h3>--}}
                                            {{--<hr>--}}
                                            {{--<div class="table-responsive">--}}
                                            {{--<table id="myTable" width="100%"--}}
                                            {{--class="table table-striped table-bordered table-hover">--}}
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


                                        @endforeach
                                        {{--<hr>--}}
                                        {{--Lorem ipsum dolor sit amet, consectetur adipisicing elit,--}}
                                        {{--sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad--}}
                                        {{--minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea--}}
                                        {{--commodo consequat.--}}
                                    @endif
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($variation_ids as $value)
                                    @foreach($value->selectionType as $type)
                                        <div role="tabpanel" class="tab-pane active" id="{{$type->type_name}}">
                                            @if($value == $type->type_name)
                                                {{$value}}
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php($count1++)
    @endforeach
    {{--            @foreach($variation_ids as $value)--}}
    {{--{{$value}}--}}
    <div class="table-responsive">
        <table id="myTable" width="100%" class="table table-striped table-bordered table-hover">
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
            </tbody>
        </table>
        <div class="form-group">
            {!! Form::text('house_type_id', $houseType->id, ['class'=>'form-control hidden', 'name'=>'house_type_id']) !!}
        </div>
    </div>
    {{--@endforeach--}}
    </div>
    </div>
    @php($count1++)

    {!! Form::submit('Next'); !!}
    {!! Form::close(); !!}
@endsection