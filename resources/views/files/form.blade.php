@extends('layouts.app')
@section('content')

    <div>
        <div class="input-group">
            <form action="/file/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <input type="file" name="file" id="file">
                </div>
                <div>
                    <button type="submit">submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection