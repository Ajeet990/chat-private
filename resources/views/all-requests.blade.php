@extends('layout.layout')
@section('content')
<div class="container">
    <h2>My all requests</h2>
    @if ($requests->isEmpty())
        <p>You have no requests yet.</p>
    @else
        @foreach ($requests as $request)
            <div class="my-2">
                <b>{{ $request->friend->user_name }}</b> 
                    <button class="btn btn-secondary btn-sm" id="accept_request" data-userid="{{$request->friend->id}}">Accept</button> 
                <br>
            </div>
        @endforeach
    @endif
</div>

@endsection
