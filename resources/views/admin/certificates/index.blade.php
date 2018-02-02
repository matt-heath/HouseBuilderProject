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
                </tr>
                </thead>
                <tbody>
                @foreach($certificates as $certificate)
                    <tr>

                        <td>{{$certificate->certificate_name}}</td>
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
                responsive: true

            });
        });
    </script>

@endsection
