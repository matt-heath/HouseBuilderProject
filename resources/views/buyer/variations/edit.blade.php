@extends('layouts.admin')

@section('title')
    <h1>Edit Selections</h1>
@endsection


@section('content')
    {{--{!! Form::open(array('action' => 'VariationController@assignToHouseType', 'method' => 'post')); !!}--}}
    {{--{{$booking->first()->id}}--}}
    {!! Form::model($booking, ['method'=>'PATCH', 'action'=> ['BuyerVariationController@update', $booking->id]]) !!}

    @php($count1 = 0)
    @php($first = true)
    @php($typeExists = array())
    @foreach($selectionCategories as $category)
        @foreach($variation_ids as $value)
            @php($selection_category = $value->supplier->selectionCategory->category_name)
        @endforeach
        @if($category->category_name == $selection_category)
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
                                    @if($category == $selection_category && count($selection_category) > 0)
                                        @php($count = 0)

                                        @foreach($value->selectionType as $type)
                                            @foreach($selectionTypes as $tabType)
                                                @if($first)
                                                    <li role="presentation" class="active">
                                                        <a href="#{{$type->type_name}}" aria-controls="{{$type->type_name}}"
                                                           role="tab"
                                                           data-toggle="tab">{{$type->type_name}}
                                                        </a></li>
                                                    @php($first = false)
                                                    @php($count++)
                                                @else
                                                    {{--@php(dd($typeExists));--}}
                                                    {{--{{$typeExists[$count]}}--}}
                                                    {{--{{$tabType->first()->type_name}}--}}
                                                    {{--<h1>{{$type->type_name}}</h1>--}}
                                                    @if(!in_array($type->type_name, $typeExists))
                                                        <li role="presentation"><a href="#{{$type->type_name}}"
                                                                                   aria-controls="{{$type->type_name}}"
                                                                                   role="tab"
                                                                                   data-toggle="tab">{{$type->type_name}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @php($count++)
                                                @endif
                                                    @php($typeExists[] = $type->type_name)
                                            @endforeach
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul>
                            {{--@php(dd($typeExists))--}}
                            <div class="tab-content">

                                @php($firstTab = true)
                                @php($types = array())
                                @foreach($variation_ids as $value)
                                    @foreach($value->selectionType as $type)
                                        @if($firstTab)
                                            <div role="tabpanel" class="tab-pane active" id="{{$type->type_name}}">
                                        @else
                                                @if(!in_array($type->type_name, $types))
                                                    <div role="tabpanel" class="tab-pane" id="{{$type->type_name}}">
                                                @endif

                                                @php($types[] = $type->type_name)
                                        @endif
                                    @endforeach
                                    @if($selection_category == $category)
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Selection Name</th>
                                                <th>Description</th>
                                                <th>Supplier Name</th>
                                                <th>Price</th>
                                                <th>Picture</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($variation_ids as $value)
                                                @if($value->selectionType->first()->type_name == $type->type_name)
                                                    <tr>
                                                        {{--<td>--}}
                                                            {{--<label class="btn btn-danger">--}}
                                                                {{--<input type="radio" name="{{$value->selectionType->first()->type_name}}" id="option2" autocomplete="off">--}}
                                                                {{--<span class="glyphicon glyphicon-ok"></span>--}}
                                                            {{--</label>--}}
                                                        {{--</td>--}}
                                                        <td>
                                                            @if(in_array($value->id, $default))
                                                                {!! Form::checkbox('variations['.$type->id.'][]', $value->id, true, ['id'=> $type->id, 'class'=> 'radio']); !!}
                                                            @else
                                                                {!! Form::checkbox('variations['.$type->id.'][]', $value->id, false, ['id'=> $type->id, 'class'=> 'radio']); !!}
                                                            @endif
                                                        </td>
                                                        {{--@php($matched = false)--}}
                                                        {{--@foreach($default as $def)--}}
                                                            {{--@if($def == $value->id && $matched == false)--}}
                                                                {{--TRUE--}}
                                                                {{--<td>{!! Form::checkbox('variations['.$type->id.'][]', $value->id, true, ['id'=> $type->id, 'class'=> 'radio']); !!}</td>--}}
                                                                {{--@php($matched = true)--}}
                                                            {{--@else--}}
                                                                {{--FALSE--}}
                                                                {{--<td>{!! Form::checkbox('variations['.$type->id.'][]', $value->id, false, ['id'=> $type->id, 'class'=> 'radio']); !!}</td>--}}
                                                            {{--@endif--}}
                                                        {{--@endforeach--}}
                                                        {{--<td>{{$type->id}}</td>--}}
                                                        <td>{{$value->name}}</td>
                                                        <td>{{$value->description}}</td>
                                                        <td>{{$value->supplier->supplier_company_name}}</td>
                                                        <td>{{$value->price}}</td>
                                                        <td class="col-xs-3">
                                                            <a href="{{$value->extra_img ? $value->photo->file : 'http://placehold.it/400x400'}}" data-lightbox="image">
                                                                <img src="{{$value->extra_img ? $value->photo->file : 'http://placehold.it/400x400'}}" class="img-rounded img-thumbnail" alt="">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    </div>
                                    {{--{{$type->type_name}}--}}
                                    @php($firstTab = false)
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php($count1++)
        @endif
    @endforeach
    @php($count1++)

    {!! Form::submit('Next'); !!}
    {!! Form::close(); !!}
@endsection

@section('script')
                {{--<script>--}}

                    {{--$(".2").change(function()--}}
                    {{--{--}}
                        {{--$(".2").prop('checked',false);--}}
                        {{--$(this).prop('checked',true);--}}
                    {{--});--}}
                    {{--$(".5").change(function()--}}
                    {{--{--}}
                        {{--$(".5").prop('checked',false);--}}
                        {{--$(this).prop('checked',true);--}}
                    {{--});--}}

                {{--</script>--}}
                <script>
                    $("input:checkbox").on('click', function() {
                        // in the handler, 'this' refers to the box clicked on
                        var $box = $(this);
                        if ($box.is(":checked")) {
                            // the name of the box is retrieved using the .attr() method
                            // as it is assumed and expected to be immutable
                            var group = "input:checkbox[name='" + $box.attr("name") + "']";
                            // the checked state of the group/box on the other hand will change
                            // and the current value is retrieved using .prop() method
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }
                    });
                </script>
@endsection