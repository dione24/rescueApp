<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CoverageZone;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        $users = User::all();
        $announcements = Announcement::all();
        return view('users', compact('users', 'announcements'));
    }

    public function coverage()
    {
        $coverage = CoverageZone::all();
        dd($coverage);
        return view('coverage', compact('coverage'));
    }
}
