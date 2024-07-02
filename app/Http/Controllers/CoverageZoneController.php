<?php

namespace App\Http\Controllers;

use App\Models\CoverageZone;
use Illuminate\Http\Request;

class CoverageZoneController extends Controller
{
    public function create()
    {
        return view('set_zone');
    }

    public function store(Request $request)
    {
        $request->validate([
            'zone_coordinates' => 'required'
        ]);

        $coverageZone = new CoverageZone();
        $coverageZone->user_id = auth()->id();
        $coverageZone->coordinates = $request->zone_coordinates;
        $coverageZone->save();

        return redirect()->route('coverage_zone.create')->with('success', 'Zone de couverture enregistrée avec succès.');
    }
}
