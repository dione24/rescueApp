<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use App\Models\CoverageZone;
use Illuminate\Http\Request;
use App\Notifications\RescuerNotification;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('create_announcement');
    }

    public function store(Request $request)
    {
        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $this->notifyRescuers($announcement);

        return redirect()->route('announcements.create')->with('success', 'Annonce créée avec succès.');
    }

    public function index()
    {
        $announcements = Announcement::where('status', 'pending')->get();
        return view('view_announcements', compact('announcements'));
    }

    public function accept($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->status = 'accepted';
        $announcement->save();

        // Envoyer une notification à l'admin
        // ...

        return redirect()->route('announcements.index')->with('success', 'Annonce acceptée avec succès.');
    }

    private function notifyRescuers(Announcement $announcement)
    {
        $rescuers = User::where('role', 'rescuer')->get();
        foreach ($rescuers as $rescuer) {
            $zone = $rescuer->coverageZone;
            if ($this->isWithinZone($announcement, $zone)) {
                // Envoyer une notification au secoureur
                Notification::send($rescuer, new RescuerNotification($announcement));
            }
        }
    }

    private function isWithinZone(Announcement $announcement, CoverageZone $zone)
    {
        $earthRadius = 6371000; // Rayon de la Terre en mètres

        $latFrom = deg2rad($announcement->latitude);
        $lonFrom = deg2rad($announcement->longitude);
        $latTo = deg2rad($zone->latitude);
        $lonTo = deg2rad($zone->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $earthRadius * $angle;

        return $distance <= $zone->radius;
    }
}
