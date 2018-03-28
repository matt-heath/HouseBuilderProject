@extends('layouts.admin')

@section('title')
    <h1>Assign supplier for {{$supplier_types->category_name}}</h1>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['method'=>'POST', 'action'=>'VariationController@store', 'files' => true])!!}
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
                            {!! Form::select('supplier_id', ['' => 'Select Supplier Responsible'] + $suppliers, null, ['class'=>'form-control select supplier_select', 'name' => 'supplier_id'])!!}
                        </div>
                    </td>
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
        });
    </script>

@endsection