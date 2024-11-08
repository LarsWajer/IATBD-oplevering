<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oppasser;

class OppasserController extends Controller
{
    public function index()
    {
        // Haal alle oppassers op, inclusief hun aanmeldingen
        $oppassers = Oppasser::with('aanmeldingen')->get();

        return view('oppassers', compact('oppassers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        // Zoek naar een bestaande oppasser voor de ingelogde gebruiker
        $oppasser = Oppasser::where('name', $user->name)->first();

        if ($oppasser) {
            // Als de oppasser bestaat, werk deze bij
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $validated['photo'] = $photoPath;
            }
            $oppasser->update($validated);
        } else {
            // Als de oppasser niet bestaat, maak een nieuwe aan
            $validated['name'] = $user->name;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $validated['photo'] = $photoPath;
            }
            Oppasser::create($validated);
        }

        return redirect()->route('oppassers.index')->with('success', 'Oppasser bijgewerkt!');
    }

    public function storeReview(Request $request, $id)
{
    // Validatie van de input
    $request->validate([
        'review' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // Haal de oppasser op
    $oppasser = Oppasser::findOrFail($id);

    // Haal bestaande reviews op of maak een lege array
    $reviews = $oppasser->reviews ?? [];

    // Voeg de nieuwe review toe aan de lijst van reviews
    $reviews[] = [
        'user' => auth()->user()->name, // De naam van de ingelogde gebruiker
        'review' => $request->input('review'), // De geschreven review
        'rating' => $request->input('rating'), // De beoordeling
        'created_at' => now(), // De datum en tijd van de review
    ];

    // Sla de bijgewerkte reviews op in de JSON-kolom
    $oppasser->reviews = $reviews;
    $oppasser->save();

    return redirect()->route('oppassers.index')->with('success', 'Review succesvol toegevoegd.');
}
    

    
}
