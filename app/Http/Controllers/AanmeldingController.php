<?php

namespace App\Http\Controllers;

use App\Models\Huisdier;
use App\Models\User;
use App\Models\Aanmelding;
use Illuminate\Http\Request;

class AanmeldingController extends Controller
{

    public function index()
    {
        // Verkrijg alle aanmeldingen
        $aanmeldingen = Aanmelding::with('huisdier', 'user')->get();
        return view('aanmeldingen', compact('aanmeldingen'));
    }

    public function create(Request $request)
    {
        // Haal het huisdier op waarvoor de gebruiker zich wil aanmelden
        $huisdier = Huisdier::findOrFail($request->huisdier_id);

        return view('aanmeldingen', compact('huisdier'));
    }

    public function store(Request $request)
    {
        // Valideer de input
        $request->validate([
            'huisdier_id' => 'required|exists:aangeboden_huisdieren,id',
        ]);

        // Controleer of er al een goedgekeurde aanvraag is voor dit huisdier
        $huisdier = Huisdier::findOrFail($request->input('huisdier_id'));
        if ($huisdier->aanmeldingen()->where('is_accepted', true)->exists()) {
            return redirect()->route('oppassers.index')->with('status', 'Er is al een goedgekeurde aanvraag voor dit huisdier.');
        }

        // Maak een nieuwe aanmelding aan
        Aanmelding::create([
            'huisdier_id' => $request->input('huisdier_id'),
            'user_id' => auth()->id(), // De ingelogde gebruiker
            'is_accepted' => false,
        ]);

        return redirect()->route('aanmeldingen.beheer')->with('status', 'Je hebt je succesvol aangemeld om op te passen.');
    }


    public function accept(Request $request, $id)
    {
        // Zoek de aanmelding op
        $aanmelding = Aanmelding::findOrFail($id);
        
        // Zet de aanmelding als geaccepteerd
        $aanmelding->update(['is_accepted' => true]);

        // Haal het huisdier op en update de status
        $huisdier = Huisdier::findOrFail($aanmelding->huisdier_id);
        $huisdier->update(['is_accepted' => true]);

        return redirect()->route('aanmeldingen.beheer')->with('status', 'Aanmelding geaccepteerd.');
    }
    
    public function reject(Request $request, $id)
    {
        // Zoek de aanmelding op
        $aanmelding = Aanmelding::findOrFail($id);

        // Verwijder de aanmelding
        $aanmelding->delete();

        return redirect()->route('aanmeldingen.beheer')->with('status', 'Aanmelding afgewezen.');
    }

    public function beheer()
    {
        // Haal alle aanmeldingen op die horen bij de ingelogde gebruiker
        $huisdieren = Huisdier::where('user_id', auth()->id())->with('aanmeldingen.user')->get();

        return view('aanmeldBeheer', compact('huisdieren'));
    }

    public function oppassers()
    {
        // Haal alle geaccepteerde aanmeldingen op
        $oppassers = Aanmelding::where('is_accepted', true)
                    ->with('user', 'huisdier')
                    ->get();
    
        // Stuur de oppassers naar de view
        return view('oppassers', compact('oppassers'));
    }
    


}

