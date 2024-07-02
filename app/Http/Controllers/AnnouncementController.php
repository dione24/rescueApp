<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Polygon;
use App\Models\Announcement;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\RescuerNotification;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
    public function create()
    {
        $rescuersInZone = session('rescuersInZone', []);

        return view('create_announcement', compact('rescuersInZone'));
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

        // Vérifiez si le point est à l'intérieur d'au moins un polygone
        if (!$this->isInsideAnyPolygon($point, $polygons)) {
            return response()->json(['error' => 'La localisation est en dehors des zones de couverture autorisées.'], 422);
        }


        // Si le point est valide, créez l'annonce
        $announcement = Announcement::create([
            'user_id' => auth()->id(),
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);



        return response()->json(['success' => 'Annonce créée avec succès. Vous serez notifié dès qu\'un secouriste accepte votre annonce.']);
    }

    private function isInsideAnyPolygon($point, $polygons)
    {
        foreach ($polygons as $polygon) {
            $vertices = json_decode($polygon->vertices, true); // Decode the JSON string into an array

            // Ensure vertices is an array and not null
            if (is_array($vertices) && isset($vertices[0]) && $this->isInsidePolygon($point, $vertices[0])) {
                return true;
            } else {
                Log::error('Invalid polygon vertices', ['vertices' => $vertices]);
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
}