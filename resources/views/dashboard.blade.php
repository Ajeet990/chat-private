@extends('layout.layout')
@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Welcome user: {{ $user->user_name }}</h2>
    <div class="col-md-12">
        <div class="col-md-6 my-3">
            <h2>All Users</h2>
            @foreach ($allUsers as $singleUser)
                @if ($singleUser->id !== $user->id)
                    <div class="my-2">
                        <b>{{ $singleUser->user_name }}</b> 
                            <button class="btn btn-primary btn-sm" id="send_request" data-userid="{{$singleUser->id}}">Request Chat</button> 
                        <br>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="col-md-6 my-3">
            <h2>My Friends</h2>
            @if ($friends->isEmpty())
                <p>You have no friends yet.</p>
            @else
                @foreach ($friends as $friend)
                    <!-- Show only the friend that is not the logged-in user -->
                    @if ($friend->friend->id !== $user->id)
                        <div class="my-2">
                            <b>{{ $friend->friend->user_name }}</b> 
                            <a class="btn btn-secondary btn-sm" href="{{ route('chat.with.friend', ['receiver_id' => $friend->friend->id]) }}" id="chatwithfriend">Chat</a>
                            {{-- <a class="btn btn-secondary btn-sm" href="{{route('chat.with.friend/$friend->friend->id')}}" id="chatwithfriend">Chat</a>  --}}
                            <br>
                        </div>
                    @endif

                    @if ($friend->requested->id !== $user->id)
                        <div class="my-2">
                            <b>{{ $friend->requested->user_name }}</b> 
                            <a class="btn btn-secondary btn-sm" href="{{ route('chat.with.friend', ['receiver_id' => $friend->requested->id]) }}" id="chatwithfriend">Chat</a>

                            {{-- <button class="btn btn-secondary btn-sm">Chat</button>  --}}
                            <br>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
