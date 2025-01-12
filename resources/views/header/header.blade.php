<?php
use Illuminate\Support\Facades\Auth;
// dd("here", Auth::user());
$userDetails = Auth::user();
// if (isset($userDetails->id)) {
//   dd("logged in");
// } else {
//   dd("no logged in");
// }

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('dashboard')}}">Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{route('login')}}">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('register')}}">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('friend.requests')}}">Requests</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        @if(isset($userDetails->id))
          <li class="nav-item">
            <span class="navbar-text">Welcome: {{ $userDetails->user_name }}</span>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
