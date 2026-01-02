<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Weapon, Apparel, Aid, MiscItem, Ammo, SpecialStat, Skill, Perk, Quest, Note};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Użytkownicy (Admin i Klient)
        User::create([
            'name' => 'Overseer',
            'email' => 'admin@vault.tec',
            'password' => Hash::make('password'),
            'is_admin' => true
        ]);

        User::create([
            'name' => 'Lone Wanderer',
            'email' => 'user@vault.tec',
            'password' => Hash::make('password'),
            'is_admin' => false
        ]);

        // 2. Items - Weapons
        Weapon::create(['name' => '.32 Pistol', 'damage' => 6, 'weight' => 2, 'value' => 55]);
        Weapon::create(['name' => 'Assault Rifle', 'damage' => 32, 'weight' => 7, 'value' => 300]);

        // 3. Items - Apparel
        Apparel::create(['name' => 'Vault 101 Jumpsuit', 'dr' => 5, 'weight' => 1, 'value' => 10]);
        Apparel::create(['name' => 'Leather Armor', 'dr' => 15, 'weight' => 15, 'value' => 150]);

        // 4. Items - Aid
        Aid::create(['name' => 'Stimpak', 'effect' => '+30 HP', 'weight' => 0, 'value' => 25]);
        Aid::create(['name' => 'RadAway', 'effect' => '-50 Rads', 'weight' => 0, 'value' => 40]);

        // 5. Items - Misc
        MiscItem::create(['name' => 'Bobby Pin', 'weight' => 0, 'value' => 1]);
        MiscItem::create(['name' => 'Lunchbox', 'weight' => 1, 'value' => 5]);

        // 6. Items - Ammo
        Ammo::create(['name' => '10mm Round', 'quantity' => 746]);
        Ammo::create(['name' => '5.56mm Round', 'quantity' => 2022]);

        // 7. Stats - SPECIAL
        $specials = ['Strength' => 5, 'Perception' => 6, 'Endurance' => 4, 'Charisma' => 5, 'Intelligence' => 9, 'Agility' => 7, 'Luck' => 5];
        foreach($specials as $name => $val) {
            SpecialStat::create(['name' => $name, 'value' => $val]);
        }

        // 8. Stats - Skills
        Skill::create(['name' => 'Small Guns', 'value' => 45]);
        Skill::create(['name' => 'Lockpick', 'value' => 30]);

        // 9. Stats - Perks
        Perk::create(['name' => 'Lady Killer', 'description' => '+10% dmg to opposite sex']);
        Perk::create(['name' => 'Gun Nut', 'description' => '+5 Small Guns, +5 Repair']);

        // 10. Data - Quests
        Quest::create(['title' => 'Escape!', 'description' => 'Leave Vault 101 forever.', 'status' => 'completed']);
        Quest::create(['title' => 'The Power of the Atom', 'description' => 'Disarm or detonate the bomb in Megaton.', 'status' => 'active']);

        // 11. Data - Notes
        Note::create(['title' => 'Dad\'s Note', 'content' => 'I had to leave. I am sorry.']);
    }
}