<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Importujemy wszystkie modele
use App\Models\{User, Weapon, Apparel, Aid, MiscItem, Ammo, SpecialStat, Skill, Perk, Quest, Note};

class PipBoyController extends Controller
{
    public function index()
    {
        return redirect()->route('stats');
    }

    public function stats(Request $request)
    {
        $tab = $request->get('tab', 'status');
        
        return view('stats', [
            'tab' => $tab,
            'specials' => SpecialStat::all(),
            'skills' => Skill::all(),
            'perks' => Perk::all(),
            'users' => User::all(), // Przekazujemy listę userów do zakładki GENERAL
            'bg' => 'images/stats.jpg'
        ]);
    }

    public function items(Request $request)
    {
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

    // --- LOGIKA UŻYTKOWNIKA I ADMINA ---

    public function loginUser($id)
    {
        // Loguje użytkownika o danym ID "na sztywno" (symulacja terminala)
        Auth::loginUsingId($id);
        return back();
    }

    public function deleteItem(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Overseer clearance required.');
        }

        $type = $request->input('type');

        switch($type) {
            case 'weapons': Weapon::destroy($id); break;
            case 'apparel': Apparel::destroy($id); break;
            case 'aid':     Aid::destroy($id); break;
            case 'misc':    MiscItem::destroy($id); break;
            case 'ammo':    Ammo::destroy($id); break;
        }

        return back();
    }

    public function updateNote(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Overseer clearance required.');
        }

        $note = Note::findOrFail($id);
        $note->content = $request->input('content');
        $note->save();

        return back();
    }
}
