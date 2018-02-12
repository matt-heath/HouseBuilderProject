@extends('layouts.admin')

@section('content')

    <h1>All Certificates</h1>

    <div class="col-sm-12">
        {{--@if($certificates)--}}
            {{--<table class="table" id="myTable">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>Certificate Name</th>--}}
                    {{--<th>Certificate Checked?</th>--}}
                    {{--<th>Document</th>--}}
                    {{--<th>Certificate Category</th>--}}
                    {{--<th></th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($certificates as $certificate)--}}
                    {{--<tr>--}}

                        {{--<td>{{$certificate->certificate_name}}</td>--}}
                        {{--<td>{{$certificate->certificate_check}}</td>--}}
                        {{--<td>{{$certificate->certificate_doc ? $certificate->certificate_doc : "No certificate uploaded" }}</td>--}}
                        {{--<td><a href={{ $certificate->certificate_doc }}>{{$certificate->category['name']}}</a></td>--}}
                        {{--<td>--}}
                            {{--<div class="btn-group">--}}
                                {{--<a href="{{route('admin.certificates.edit', $certificate->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>--}}
                            {{--</div>--}}
                            {{--<div class="btn-group">--}}
                                {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminCertificatesController@destroy', $certificate->id], 'id'=> 'confirm_delete_'.$certificate->id]) !!}--}}
                                    {{--{!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$certificate->id .')']) !!}--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--@endif--}}
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true
            });
        });

        function confirmDelete(id) {
            // console.log(id);
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
                swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            } else if (result.dismiss === 'cancel') {

            }
        })
        }
    </script>

@endsection
