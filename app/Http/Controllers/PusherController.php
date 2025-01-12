<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\PusherBroadcast;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    use Dispatchable, SerializesModels;

    public string $message;
    // public int $senderId;
    // public int $receiverId;

    public function index(Request $request)
    {
        return view('index');
    }

    public function broadcast(Request $request)
    {
        $user = Auth::user();
        // dd("broadcast", $request->all(), $user->id, auth()->id());

        // Broadcast(new PusherBroadcast($request->get('message')))->toOthers();
        // return view('broadcast', ['message' => $request->get('message')]);


        broadcast(new PusherBroadcast($request->message, auth()->id(), $request->receiver_id))->toOthers();
        // return response()->json(['message' => 'Message sent.', 'data' => $request->message]);
        return view('broadcast', ['message' => $request->get('message')]);

    }

    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }
}
