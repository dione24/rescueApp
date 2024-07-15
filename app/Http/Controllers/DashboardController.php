<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function home()
    {
        $users = User::all();
        $announcements = Announcement::all();
        return view('home', compact('users', 'announcements'));
    }
}
