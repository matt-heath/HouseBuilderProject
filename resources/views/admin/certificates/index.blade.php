@extends('layouts.admin')

@section('content')

    <h1>All Certificates</h1>

    <div class="col-sm-12">
        @if($certificates)
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>Certificate Name</th>
                    <th>Certificate Checked?</th>
                    <th>Document</th>
                    <th>Certificate Category</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($certificates as $certificate)
                    <tr>

                        <td>{{$certificate->certificate_name}}</td>
                        @if($certificate->certificate_check === 0)
                            <td>False</td>

                        @else
                            <td>True</td>

                        @endif

                        {{--<td>{{$certificate->certificate_check}}</td>--}}
                        <td>{{$certificate->certificate_doc ? $certificate->certificate_doc : "No certificate uploaded" }}</td>

                        {{--TODO:: make downloads controller allowing user to download and check the uploaded file before approval--}}
                        <td>
                            {{--<a href={{ $certificate->certificate_doc }}>{{$certificate->category['name']}}</a>--}}
                            @if($certificate->certificate_doc)
                                {!! Html::link('download/'.$certificate->certificate_doc, $certificate->category['name']) !!}
                            @else
                                {{$certificate->category['name']}}
                            @endif
                        </td>
                        <td>{{$certificate->build_status}}</td>
                        <td>
                            {{--<div class="btn-group">--}}
                                {{--<a href="{{route('admin.certificates.edit', $certificate->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>--}}
                            {{--</div>--}}
                            <div class="btn-group">
                                @if($certificate->build_status === 'Awaiting approval' && $certificate->certificate_check == 0)
                                    {!! Form::open(['method'=>'PATCH', 'action'=> ['AdminCertificatesController@update', $certificate->id]]) !!}
                                        <input type="hidden" name="certificate_check" value="1">
                                        <div class="btn-group">
                                            {!! Form::submit('Approve', ['class'=>'btn btn-info']) !!}
                                        </div>
                                    {!! Form::close() !!}

                                    <input type="hidden" name="certificate_check" value="3">
                                    <div class="btn-group">
                                        {{--{!! Form::submit('Reject', ['class'=>'btn btn-danger']) !!}--}}
                                        <a href='' class="btn btn-danger" data-toggle='modal' data-target='#myModal' id='modalClick' data-id={{$certificate->id}}>Reject</a>
                                    </div>
                                @elseif($certificate->build_status==='Accepted' && $certificate->certificate_check == 1)
                                    {!! Form::open(['method'=>'PATCH', 'action'=> ['AdminCertificatesController@update', $certificate->id]]) !!}
                                        <input type="hidden" name="certificate_check" value="0">
                                        <div class="form-group">
                                            {!! Form::submit('Un-approve', ['class'=>'btn btn-success']) !!}
                                        </div>
                                    {!! Form::close() !!}
                                @elseif($certificate->build_status==='Rejected')
                                    <div class="btn-group">
                                        {{--{!! Form::submit('Reject', ['class'=>'btn btn-danger']) !!}--}}
                                        <a href='' class="btn btn-danger" data-toggle='modal' data-target='#rejectionModal' id='rejectionClick' data-id={{$certificate->id}}>Rejection Reasons</a>
                                    </div>
                                @endif
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--{!! Form::open(['method'=>'DELETE', 'action'=> ['AdminCertificatesController@destroy', $certificate->id], 'id'=> 'confirm_delete_'.$certificate->id]) !!}--}}
                                    {{--{!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$certificate->id .')']) !!}--}}
                                {{--{!! Form::close() !!}--}}
                            {{--</div>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Reject Certificate?</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::model($certificate, ['method'=>'PATCH', 'class'=> 'modalCertificate', 'action'=>['AdminCertificatesController@update', $certificate->id]])!!}
                            <input type="hidden" name="certificate_check" value="3">
                            <div class="form-group">
                                {!! Form::label('rejection_reason', 'Certificate Rejection Notes:') !!}
                                {!! Form::textarea('rejection_reason', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                {!! Form::submit('Reject Certificate', ['class'=>'btn btn-primary']) !!}
                            </div>
                            {!! Form::close() !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="rejectionModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Rejection Reasons</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="certificate_check" value="3">
                            <div class="form-group">
                                {!! Form::label('rejection_reason', 'Certificate Rejection Notes:') !!}
                                {!! Form::textarea('rejection_reason', null, ['class'=>'form-control reject']) !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ]
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
                    'Certificate has been deleted.',
                    'success'
                )
                $("#confirm_delete_"+id).off("submit").submit()
                // result.dismiss can be 'cancel', 'overlay',
                // 'close', and 'timer'
            } else if (result.dismiss === 'cancel') {

            }
        })
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#modalClick').on('click', function () {

            console.log($(this).data());

            $('.modalCertificate').attr('action', '/admin/certificates/'+$(this).data('id'));
        });

        $('#rejectionClick').on('click', function () {
            var cert_id=$(this).data('id');
            console.log(cert_id);

            $.ajax({
                type: 'get',
                url: '{!! URL::to('getRejectionReasons') !!}',
                data: {'id': cert_id},
                success: function (data) {
                    console.log('Success!!');
                    console.log(data);
                    console.log(data.length);
                    console.log(data);
                    if(data.length != 0) {

                        for(var i = 0; i < data.length; i++){
                            console.log(data[i].rejection_reason);
                            $(".reject").append(data[i].rejection_reason).attr('disabled', true);
                        }
                    }
                    // console.log(option);
                },
                error: function () {
                    console.log("Failed...")
                }
            })
        });
    </script>

@endsection
