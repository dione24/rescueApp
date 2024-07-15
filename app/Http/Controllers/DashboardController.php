<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $users = User::all();

        if (Auth::user()->role == 'admin') {
            $announcements = Announcement::all();
            return view('home', compact('users', 'announcements'));
        } elseif (Auth::user()->role == 'client') {
            $announcements = Announcement::where('user_id', Auth::user()->id)->get();
            return view('client.home', compact('users', 'announcements'));
        } elseif (Auth::user()->role == 'rescuer') {
            return view('rescuer.home', compact('users', 'announcements'));
        }
    }
}
