<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Weapon, Apparel, Aid, MiscItem, Ammo, SpecialStat, Skill, Perk, Quest, Note};

class PipBoyController extends Controller
{
    public function index()
    {
        return redirect()->route('stats');
    }

    public function stats(Request $request)
    {
        // Domyślnie 'status', ale obsłużymy też 'special', 'skills', 'perks'
        $tab = $request->get('tab', 'status'); 
        
        return view('stats', [
            'tab' => $tab,
            'specials' => SpecialStat::all(),
            'skills' => Skill::all(),
            'perks' => Perk::all(),
            'bg' => 'images/stats.jpg' // Pamiętaj o podmianie tła w zależności od taba jeśli masz różne zdjęcia
        ]);
    }

    public function items(Request $request)
    {
        // Domyślnie 'weapons'
        $tab = $request->get('tab', 'weapons');

        return view('items', [
            'tab' => $tab,
            'weapons' => Weapon::all(),
            'apparel' => Apparel::all(),
            'aid' => Aid::all(),
            'misc' => MiscItem::all(),
            'ammo' => Ammo::all(),
            'bg' => 'images/items.jpg'
        ]);
    }

    public function data(Request $request)
    {
        $tab = $request->get('tab', 'quests');

        return view('data', [
            'tab' => $tab,
            'quests' => Quest::all(),
            'notes' => Note::all(),
            'bg' => 'images/data.jpg'
        ]);
    }
}