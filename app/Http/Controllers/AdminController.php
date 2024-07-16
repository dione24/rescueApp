<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CoverageZone;
use App\Models\Polygon;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {

        $users = User::all();
        $announcements = Announcement::all();
        $annoncesAttente = Announcement::where('status', 'pending')->count();
        $annoncesAccepte = Announcement::where('status', 'accepted')->count();
        $rescuers = User::where('role', 'rescuer')->count();
        return view('admin.home', compact('users', 'announcements', 'annoncesAttente', 'annoncesAccepte', 'rescuers'));
    }
    public function users()
    {
        $users = User::all();
        $announcements = Announcement::all();
        return view('admin.users', compact('users', 'announcements'));
    }

    public function zones()
    {
        $zones = Polygon::all();
        return view('admin.zones', compact('zones'));
    }
}
