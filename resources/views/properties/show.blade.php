@extends('layouts.app')
@section('content')

<div class="container">
    <h2>所有者リスト</h2>
    <ul>
        <li>address: {{$property->address}}</li>
        <li>type: {{$property->type}}</li>
    </ul>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">address</th>
                <th scope="col">equity</th>
            </tr>
        </thead>

        @foreach($owners as $owner)
            <tbody>
                <tr>
                    <th scope="row">{{$owner->id}}</th>
                    <td>{{$owner->name}}</td>
                    <td>{{$owner->address}}</td>
                    <td>{{$owner->equity}}</td>
                </tr>
            </tbody>
        @endforeach
    </table>
</div>

@endsection