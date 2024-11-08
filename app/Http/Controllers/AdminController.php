<?php

namespace App\Http\Controllers;

use App\Models\Huisdier;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Toon alle huisdieren
    public function showAllHuisdieren()
    {
        $huisdieren = Huisdier::all();  // Alle huisdieren ophalen
        return view('admin.huisdieren', compact('huisdieren'));
    }

    // Verwijder een huisdier
    public function deleteHuisdier($id)
    {
        $huisdier = Huisdier::findOrFail($id);
        $huisdier->delete();

        return redirect()->route('admin.huisdieren')->with('success', 'Huisdier is verwijderd.');
    }

    // Toon alle gebruikers
    public function showAllUsers()
    {
        $users = User::all();  // Alle gebruikers ophalen
        return view('admin.users', compact('users'));
    }

    // Verwijder een gebruiker
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Gebruiker is verwijderd.');
    }
}

