<?php

namespace App\Http\Controllers;

use App\Models\Huisdier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AangebodenHuisdierController extends Controller
{
    // Toon alle huisdieren van de gebruiker
    public function index()
    {
        $huisdieren = Huisdier::where('User_id', auth()->id())->get();  // Alle huisdieren tonen
        return view('huisdieren', compact('huisdieren'));  // Gebruik de juiste view naam
    }

    // Sla het nieuwe huisdier op
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'geld' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'informatie' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('huisdier_fotos', 'public');
        } else {
            $path = null; // Geen foto geüpload
        }


        // Maak een nieuw huisdier aan
        Huisdier::create([
            'name' => $request->input('name'),
            'ras' => $request->input('ras'),
            'geld'=> $request->input('geld'),
            'user_id' => auth()->id(),
            'photo' => $path,
            'informatie' => $request->input('informatie'),
            
        ]);

        

        return Redirect::route('huisdieren.index')->with('status', 'Huisdier succesvol toegevoegd');
    }

    // Verwijder een huisdier
    public function destroy($id)
{
    $huisdier = Huisdier::findOrFail($id);

    // Controleer of de ingelogde gebruiker eigenaar is van het huisdier
    if ($huisdier->user_id != auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    // Verwijder het huisdier
    $huisdier->delete();

    return redirect()->route('huisdieren.index')->with('success', 'Huisdier succesvol verwijderd.');
}

}
