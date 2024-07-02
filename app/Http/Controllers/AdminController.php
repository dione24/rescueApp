<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $announcements = Announcement::all();
        return view('admin_dashboard', compact('users', 'announcements'));
    }
}
