@extends('layouts.admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->count())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Certificate Categories</h1>

    <div class="col-sm-12">
        @if($categories)

            {{--{{print_r($categories)}}--}}
            <table class="table" id="myTable">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->category_description}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admin.certificatecategories.edit', $category->id)}}" class="btn btn-primary"><i class="fa fa-fw fa-edit fa-sm"></i></a>
                            </div>
                            <div class="btn-group">
                                {!! Form::open(['method'=>'DELETE', 'action'=> ['AdminCertificateCategoriesController@destroy', $category->id], 'id'=> 'confirm_delete_'.$category->id]) !!}
                                {!! Form::button('<i class="fa fa-fw fa-trash"></i>', ['type'=> 'submit' ,'class'=>'btn btn-danger', 'onclick'=>'confirmDelete(' .$category->id .')']) !!}
                                {{--<a href="" class="btn btn-danger col-sm-6" onclick="confirmDelete({{$category->id}})">Delete <i class="fa fa-trash"></i></a>--}}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

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
    </script>

    <script>
        function confirmDelete(id) {
        console.log(id);
        {{--var cat_id = id;--}}
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
