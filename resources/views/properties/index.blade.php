@extends('layouts.app')
@section('content')

<div class="container">
    <h2>所有者事項のリスト</h2>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">address</th>
                <th scope="col">type</th>
            </tr>
        </thead>
        @foreach($properties as $property)
            <tbody>
                <tr>
                    <th scope="row"><a href="/property/{{$property->id}}">{{$property->id}}</a></th>
                    <td>{{$property->address}}</td>
                    <td>{{$property->type}}</td>
                </tr>
            </tbody>
    @endforeach
    </table>
</div>

@endsection