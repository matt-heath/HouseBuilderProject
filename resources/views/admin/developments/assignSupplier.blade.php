@extends('layouts.admin')

@section('title')
    <h1>Assign supplier for {{$supplier_types->category_name}}</h1>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'AdminDevelopmentsController@assignSupplierStore'])!!}
        <table id="myTable" width="100%" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Supplier Type</th>
                <th>Select a supplier</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {!! Form::text('category_name_disabled', null, ['class'=>'form-control name_list', 'name'=>'category_name', 'placeholder' =>  $supplier_types->category_name,'disabled']) !!}
                        {!! Form::text('category_name', $supplier_types->id, ['class'=>'form-control name_list hidden', 'name'=>'category_name']) !!}

                    </td>
                    <td>
                        <div class="form-group">
                            @if($assignedSupplier)
                                {!! Form::select('supplier_id', $assignedSupplier + $suppliers, null, ['class'=>'form-control select supplier_select', 'name' => 'supplier_id'])!!}

                            @else
                                {!! Form::select('supplier_id', ['' => 'Select Supplier Responsible'] + $suppliers, null, ['class'=>'form-control select supplier_select', 'name' => 'supplier_id'])!!}

                            @endif
                        </div>
                    </td>
                    <div class="form-group">
                        {!! Form::text('development_id', $devID, ['class'=>'form-control hidden', 'name'=>'development_id']) !!}
                        {!! Form::text('previousSupplierID', $previousSupplierID, ['class'=>'form-control hidden', 'name'=>'previousSupplierID']) !!}
                        {{--{!! Form::text('supplier_type', $id, ['class'=>'form-control hidden', 'name'=>'supplier_type']) !!}--}}
                    </div>
                </tr>
            </tbody>
        </table>
        {!! Form::submit('Assign Supplier', ['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#developments').select2();
            $('.supplier_select').select2();
        });
    </script>

@endsection