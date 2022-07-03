@extends('student.layout.template')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Gender</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $idx => $row)
                <tr>
                    <th scope="row">{{ $idx }}</th>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['address'] }}</td>
                    <td>{{ $row['gender'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
