<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use App\Models\CoverageZone;
use Illuminate\Http\Request;

class CoverageZoneController extends Controller
{
    public function index()
    {
        $zones = Polygon::all();
        return view('coverage', compact('zones'));
    }
    public function create()
    {
        $zones = Polygon::where('user_id', auth()->id())->get();
        return view('set_zone', compact('zones'));
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
