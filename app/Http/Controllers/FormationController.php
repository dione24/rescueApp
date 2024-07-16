<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::all();
        return view(
            'formation.index',
            [
                'formations' => $formations
            ]
        );
    }
    public function liste()
    {
        $formations = Formation::all();
        return view(
            'admin.formation',
            [
                'formations' => $formations
            ]
        );
    }

    public function create()
    {

        return view('admin.createFormation');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'contenu' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);

        //upload image into storage repository
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);

        $formation = new Formation();
        $formation->titre = $request->titre;
        $formation->contenu = $request->contenu;
        $formation->image = $imageName; // Save the image name, not the file
        $formation->user_id = auth()->user()->id;
        $formation->save();

        return redirect()->back()->with('success', 'Formation has been added');
    }

    public function show($formation)
    {
        $formation = Formation::find($formation);
        return view('formation.show', compact('formation'));
    }
}
