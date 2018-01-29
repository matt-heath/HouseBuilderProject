@if(count($errors) > 0)

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)

                <li>{{$error}}</li>

            @endforeach
        </ul>
    </div>

@endif

@section('script')
    {{--<script>--}}
        {{--var has_errors = {{ $errors->count() > 0 ? 'true' : 'false'}};--}}

        {{--if(has_errors){--}}
            {{--swal({--}}
                {{--title: 'Errors',--}}
                {{--type: 'error',--}}
                {{--html: jQuery("#error").html(),--}}
                {{--showCloseButton: true--}}
            {{--})--}}
        {{--}--}}
        {{----}}
    {{--</script>--}}
@endsection

