<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use App\Models\Announcement;
use App\Models\CoverageZone;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CoverageZoneController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        $zonesAnnounces = $this->getAnnouncementsInPolygon(Auth::user());
        $zones = Polygon::where('user_id', Auth::user()->id)->get();
        // dd($zonesAnnounces);
        return view('rescuer.home', compact('zonesAnnounces', 'zones', 'announcements'));
    }

    private function getAnnouncementsInPolygon($user)
    {
        $polygons = Polygon::where('user_id', $user->id)->get();
        $announcements = Announcement::all();

        $announcementsInPolygon = $announcements->filter(function ($announcement) use ($polygons) {
            $announcementPoint = ['longitude' => $announcement->longitude, 'latitude' => $announcement->latitude];
            return $this->isInsideAnyPolygon($announcementPoint, $polygons);
        });

        return $announcementsInPolygon;
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


    public function create()
    {
        $zones = Polygon::where('user_id', auth()->id())->get();
        return view('rescuer.set_zone', compact('zones'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'zone_coordinates' => 'required|json',
        ]);

        $coordinates = json_decode($validatedData['zone_coordinates'], true);

        // Validation du polygone (à implémenter)

        $polygon = new Polygon();
        $polygon->name  = $request->name;
        $polygon->vertices = json_encode($coordinates);
        $polygon->user_id = auth()->id();
        $polygon->save();

        return redirect()->back()->with('success', 'Zone de couverture enregistrée avec succès !');
    }

    public function destroy($id)
    {
        $zone = Polygon::find($id);
        if ($zone->user_id == auth()->id()) {
            $zone->delete();
            return redirect()->back()->with('success', 'Zone de couverture supprimée avec succès !');
        } else {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette zone de couverture !');
        }
    }
}
