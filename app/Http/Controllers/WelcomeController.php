<?php

namespace App\Http\Controllers;

use App\Models\Huisdier;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Start met een lege query
        $query = Huisdier::query();

        // Filter op dier (type) als er een dier is geselecteerd
        if ($request->filled('animal_type')) {
            $query->where('ras', $request->input('animal_type'));
        }

        // Filter op prijsklasse als er een prijs is geselecteerd
        if ($request->filled('price_range')) {
            $priceRange = explode('-', $request->input('price_range'));
            $minPrice = (float) $priceRange[0];
            $maxPrice = (float) $priceRange[1];

            $query->whereBetween('geld', [$minPrice, $maxPrice]);
        }

        // Filter om alleen huisdieren zonder geaccepteerde aanmelding te tonen
        $query->whereDoesntHave('aanmeldingen', function ($q) {
            $q->where('is_accepted', true);
        });

        // Voer de query uit om de gefilterde huisdieren op te halen
        $huisdieren = $query->get();

        // Geef de welcome pagina terug met de opgehaalde huisdieren
        return view('welcome', ['huisdieren' => $huisdieren]);
    }
}
