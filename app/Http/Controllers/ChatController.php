<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Request as SendRequest;


class ChatController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }

    public function makeLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput()
                ->with('success', 'Invalid credentials');
        }
    
        $credentials = $validator->validated();
    
        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Authentication passed, regenerate the session
            $request->session()->regenerate();
    
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }
    
        // Authentication failed
        return redirect()->route('login')
            ->withInput()
            ->with('error', 'Invalid email or password.');
    }
    
    public function register()
    {
        return view('register');
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }
    
        // Create the user (example using Eloquent)
        User::create([
            'user_name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        return redirect()->route('login')->with('success', 'User registered successfully!');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $allUsers = User::where('id', '!=', $user->id)->get();
        // $myFriends = SendRequest::with('friend', 'requested')
        //     ->where(function ($query) use ($user) {
        //         $query->where('requested_to', $user->id)
        //             ->orWhere('requested_by', $user->id);
        //     })
        //     ->where('status', 1)
        //     ->get();

        $myFriends = SendRequest::with(['friend', 'requested'])
            ->where(function ($query) use ($user) {
                $query->where('requested_to', $user->id)
                    ->orWhere('requested_by', $user->id);
            })
            ->where('status', 1)
            ->where(function ($query) use ($user) {
                $query->where('requested_to', '!=', $user->id)
                    ->orWhere('requested_by', '!=', $user->id);
            })
            ->get();

            // dd($myFriends);
        return view('dashboard', ['user' => $user, 'allUsers' => $allUsers, 'friends' => $myFriends]);
    }

    public function sendRequest(Request $request)
    {
        $user = Auth::user();
        $request_to = $request->post('request_to');
        SendRequest::create([
            'requested_to' => $request_to,
            'requested_by' => $user->id,
            'status' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request send successfully.'
        ]);
    }

    public function friendRequests(Request $request)
    {
        $user = Auth::user();
        $allRequests = SendRequest::with('friend')->where('requested_to', $user->id)->where('status', 0)->get();
        // dd("all request", $allRequests);
        return view('all-requests', ['requests' => $allRequests]);
    }


    public function acceptRequest(Request $request)
    {
        $user = Auth::user();
        $requester_id = $request->post('requester_id');
        $requestInstance = SendRequest::where('requested_by', $requester_id)->where('status', 0)->where('requested_to', $user->id)->first();
        $requestInstance->update([
            'status' => 1
        ]);
        // dd('ddd', $requestInstance);
        return response()->json([
            'success' => true,
            'message' => 'Request accepted successfully.'
        ]);
    }

    public function chatWithFriend(Request $request, $receiver_id)
    {
        $receiver_details = User::find($receiver_id);
        return view('chat', ['receiver_id' => $receiver_id, 'receiver_name' => $receiver_details->user_name]);
    }
    
}
