@extends('layout.layout')
@section('content')
    <div class="chat">
        <div class="top">
            {{-- <img src="" alt="user1"> --}}
            <div>
                <strong>{{ $receiver_name }}</strong>
                <small>Online</small>
            </div>
        </div>
        <div class="messages">
            @include('receive', ['message' => 'Hey how are you?'])
            
        </div>
        <div class="bottom">
            <form action="">
                @csrf
                <input type="hidden" name="receiver_id" id="receiver_id" value="{{$receiver_id}}">
                <input type="text" placeholder="Enter your message..." id="message" name="message">
                <button type="submit"></button>
            </form>
            
        </div>
    </div>

    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: 'ap2',
            encrypted: true,
            authEndpoint: '/broadcasting/auth', // Correct authentication endpoint
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is included
                },
            },
        });
        // const pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster:'ap2'})
        // console.log("pusher", pusher)
        // const channel = pusher.subscribe('chat.123')

        const userId = {{ auth()->id() }};
        const receiverId = $('#receiver_id').val();
        // const channel = pusher.subscribe(`private-chat.${userId}.${receiverId}`);
    
        // channel.bind('chat', function (data) {
        //     $.post("/receive", {
        //         _token : '{{csrf_token()}}',
        //         message : data.message
        //     })
        //     .done(function (res) {
        //         $(".messages > .message").last().after(res);
        //         $(document).scrollTop($(document).height());
        //     })
        // })
    
        // channel.bind('chat', function (data) {
        //     // Check if the message is for the current user
        //     const userId = {{ auth()->id() }};
        //     const receiverId = $('#receiver_id').val();

        //     // Only process the message if the sender or receiver matches the current user
        //     if ((data.senderId === parseInt(userId) && data.receiverId === parseInt(receiverId)) || 
        //         (data.senderId === parseInt(receiverId) && data.receiverId === parseInt(userId))) {

        //         $.post("/receive", {
        //             _token: '{{ csrf_token() }}',
        //             message: data.message
        //         })
        //         .done(function (res) {
        //             $(".messages").append(res); // Append the new message to the chat
        //             $(document).scrollTop($(document).height()); // Scroll to the bottom
        //         });
        //     }
        // });

        const channel = pusher.subscribe('chat.' + {{ $receiver_id }});
        channel.bind('chat', function(data) {
            $.post("/receive", {
                _token: '{{ csrf_token() }}',
                message: data.message
            }).done(function(res) {
                $(".messages").append(res);
                $(document).scrollTop($(document).height());
            });
        });

        $('form').submit(function (event) {
            event.preventDefault();
            $.ajax({
                url : '/broadcast',
                method : 'POST',
                headers : {
                    'X-socket-Id' : pusher.connection.socket_id,
                },
                data : {
                    _token : '{{csrf_token()}}',
                    message : $('form #message').val(),
                    receiver_id : $('#receiver_id').val()
                }
            }).done(function (res) {
                $(".messages > .message").last().after(res);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
            })
        })
    </script>
@endsection