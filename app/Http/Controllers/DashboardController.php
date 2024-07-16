<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Polygon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\PolygonService;

class DashboardController extends Controller
{
    protected $polygonService;

    public function __construct(PolygonService $polygonService)
    {
        $this->polygonService = $polygonService;
    }

    public function index()
    {

        $users = User::all();
        $announcements = Announcement::all();
        return view('home', compact('users', 'announcements'));
    }
}