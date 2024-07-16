<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Polygon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Jobs\SendAcceptanceEmail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendNewAnnouncementEmailJob;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('user_id', auth()->id())->get();

        return view('client.home', compact('announcements'));
    }

    public function create()
    {
        return view('client.add');
    }



    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $point = ['longitude' => $request->longitude, 'latitude' => $request->latitude];

        // Récupérez les polygones de votre base de données
        $polygons = Polygon::all();

        // Si le point est valide, créez l'annonce
        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Retrieve all users from the database
        $users = User::all();

        // Filter the users based on their location using the isInsideAnyPolygon method
        $usersInPolygon = $users->filter(function ($user) use ($point, $polygons) {
            $userPoint = ['longitude' => $user->longitude, 'latitude' => $user->latitude];
            return $this->isInsideAnyPolygon($userPoint, $polygons);
        });

        // Send an email notification to each user in the $usersInPolygon collection
        foreach ($usersInPolygon as $user) {
            SendNewAnnouncementEmailJob::dispatch($user);
        }
        return redirect()->route('client.home')->with(['success' => 'Annonce créée avec succès. Vous serez notifié dès qu\'un secouriste accepte votre annonce.']);
    }

    private function isInsideAnyPolygon($point, $polygons)
    {
        foreach ($polygons as $polygon) {
            $vertices = json_decode($polygon->vertices, true);

            if (is_array($vertices) && isset($vertices[0]) && $this->isInsidePolygon($point, $vertices[0])) {
                return true;
            }
        }

        return false;
    }

    private function isInsidePolygon($point, $polygon)
    {
        if (!is_array($polygon)) {
            throw new InvalidArgumentException('Polygon must be an array of points');
        }

        $x = $point['longitude'];
        $y = $point['latitude'];

        $inside = false;
        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i][0]; // Longitude
            $yi = $polygon[$i][1]; // Latitude
            $xj = $polygon[$j][0]; // Longitude
            $yj = $polygon[$j][1]; // Latitude

            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
    public function accept($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->status = 'accepted';
        $announcement->save();
        SendAcceptanceEmail::dispatch($announcement);
        return redirect()->back()->with('success', 'Annonce acceptée avec succès.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Annonce supprimée avec succès.');
    }
}
