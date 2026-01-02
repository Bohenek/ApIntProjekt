<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Weapon, Apparel, Aid, MiscItem, Ammo, SpecialStat, Skill, Perk, Quest, Note};

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. USERS
        User::create([
            'name' => 'Overseer',
            'email' => 'admin@vault.tec',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);

        User::create([
            'name' => 'Lone Wanderer',
            'email' => 'user@vault.tec',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => false
        ]);

        // 2. S.P.E.C.I.A.L. (Wartości 1-10)
        $specials = [
            ['name' => 'Strength', 'value' => 6, 'description' => 'Strength is a measure of your raw physical power. It affects how much you can carry, and the effectiveness of all melee attacks.'],
            ['name' => 'Perception', 'value' => 7, 'description' => 'Perception is your ability to see, hear, taste and notice unusual things. A high Perception is important for the Explosives, Lockpick and Energy Weapons skills.'],
            ['name' => 'Endurance', 'value' => 5, 'description' => 'Endurance is a measure of your overall physical fitness. A high Endurance gives you more Health, and makes you more resistant to radiation and physical damage.'],
            ['name' => 'Charisma', 'value' => 5, 'description' => 'Charisma is your ability to influence others. A high Charisma improves people\'s disposition of you, and gives bonuses to both the Barter and Speech skills.'],
            ['name' => 'Intelligence', 'value' => 9, 'description' => 'Intelligence is a measure of your overall mental acuity. A high Intelligence gives you more Skill Points to distribute when you level up.'],
            ['name' => 'Agility', 'value' => 7, 'description' => 'Agility is a measure of your overall physical coordination and ability to move quickly. A high Agility affects your Small Guns and Sneak skills.'],
            ['name' => 'Luck', 'value' => 5, 'description' => 'Luck is a measure of your general good fortune. Raising your Luck will raise all of your skills a little.'],
        ];
        foreach ($specials as $s) SpecialStat::create($s);

        // 3. SKILLS (Wartości 10-100)
        $skills = [
            ['name' => 'Barter', 'value' => 35],
            ['name' => 'Big Guns', 'value' => 25],
            ['name' => 'Energy Weapons', 'value' => 45],
            ['name' => 'Explosives', 'value' => 40],
            ['name' => 'Lockpick', 'value' => 75],
            ['name' => 'Medicine', 'value' => 50],
            ['name' => 'Melee Weapons', 'value' => 30],
            ['name' => 'Repair', 'value' => 65],
            ['name' => 'Science', 'value' => 80],
            ['name' => 'Small Guns', 'value' => 90],
            ['name' => 'Sneak', 'value' => 55],
            ['name' => 'Speech', 'value' => 60],
            ['name' => 'Unarmed', 'value' => 20],
        ];
        foreach ($skills as $s) Skill::create($s);

        // 4. PERKS (Dużo więcej)
        $perks = [
            ['name' => 'Lady Killer / Black Widow', 'description' => '+10% damage to the opposite sex and unique dialogue options.'],
            ['name' => 'Gun Nut', 'description' => '+5 Small Guns and Repair skills.'],
            ['name' => 'Little Leaguer', 'description' => '+5 Melee Weapons and Explosives skills.'],
            ['name' => 'Thief', 'description' => '+5 Sneak and Lockpick skills.'],
            ['name' => 'Swift Learner', 'description' => '+10% total Experience Points whenever Experience Points are earned.'],
            ['name' => 'Intense Training', 'description' => 'You can put a single point into any of your S.P.E.C.I.A.L. attributes.'],
            ['name' => 'Bloody Mess', 'description' => '+5% Damage with all weapons and more violent death animations.'],
            ['name' => 'Lead Belly', 'description' => '50% less radiation when drinking from a water source.'],
            ['name' => 'Toughness', 'description' => '+10% overall Damage Resistance.'],
            ['name' => 'Gunslinger', 'description' => '+25% accuracy in V.A.T.S. with one-handed weapons.'],
            ['name' => 'Commando', 'description' => '+25% accuracy in V.A.T.S. with two-handed weapons.'],
            ['name' => 'Strong Back', 'description' => '+50 Carry Weight.'],
            ['name' => 'Animal Friend', 'description' => 'Animals simply won\'t attack.'],
            ['name' => 'Finesse', 'description' => '+5% Critical Chance on all attacks.'],
            ['name' => 'Mister Sandman', 'description' => 'Instantly kill a sleeping human or ghoul for XP.'],
            ['name' => 'Mysterious Stranger', 'description' => 'The Stranger appears occasionally in V.A.T.S. to lend a hand.'],
            ['name' => 'Nerd Rage!', 'description' => 'Strength is raised to 10 and DR is increased by 50% when Health is 20% or less.'],
            ['name' => 'Cannibal', 'description' => 'You can eat corpses to regain health, but lose Karma.'],
            ['name' => 'Sniper', 'description' => 'Chance to hit the opponent\'s head in V.A.T.S. is significantly increased.'],
            ['name' => 'Grim Reaper\'s Sprint', 'description' => 'If you kill a target in V.A.T.S., all your Action Points are restored.'],
        ];
        foreach ($perks as $p) Perk::create($p);

        // 5. WEAPONS (15+)
        $weapons = [
            ['name' => '10mm Pistol', 'damage' => 9, 'weight' => 3, 'value' => 225],
            ['name' => 'Silenced 10mm Pistol', 'damage' => 8, 'weight' => 3, 'value' => 320],
            ['name' => '.32 Pistol', 'damage' => 6, 'weight' => 2, 'value' => 55],
            ['name' => '.44 Magnum', 'damage' => 35, 'weight' => 4, 'value' => 450],
            ['name' => 'Chinese Pistol', 'damage' => 4, 'weight' => 2, 'value' => 180],
            ['name' => 'Assault Rifle', 'damage' => 32, 'weight' => 7, 'value' => 300],
            ['name' => 'Chinese Assault Rifle', 'damage' => 38, 'weight' => 7, 'value' => 436],
            ['name' => 'Hunting Rifle', 'damage' => 25, 'weight' => 6, 'value' => 250],
            ['name' => 'Sniper Rifle', 'damage' => 40, 'weight' => 10, 'value' => 500],
            ['name' => 'Combat Shotgun', 'damage' => 55, 'weight' => 7, 'value' => 350],
            ['name' => 'Sawed-Off Shotgun', 'damage' => 50, 'weight' => 4, 'value' => 280],
            ['name' => 'Laser Pistol', 'damage' => 12, 'weight' => 3, 'value' => 275],
            ['name' => 'Laser Rifle', 'damage' => 23, 'weight' => 8, 'value' => 650],
            ['name' => 'Plasma Rifle', 'damage' => 45, 'weight' => 8, 'value' => 1200],
            ['name' => 'Flamer', 'damage' => 64, 'weight' => 15, 'value' => 800],
            ['name' => 'Minigun', 'damage' => 50, 'weight' => 18, 'value' => 1000],
            ['name' => 'Fat Man', 'damage' => 1600, 'weight' => 30, 'value' => 2500],
            ['name' => 'Missile Launcher', 'damage' => 150, 'weight' => 20, 'value' => 1100],
            ['name' => 'Sledgehammer', 'damage' => 20, 'weight' => 12, 'value' => 130],
            ['name' => 'Power Fist', 'damage' => 20, 'weight' => 6, 'value' => 340],
        ];
        foreach ($weapons as $w) Weapon::create($w);

        // 6. APPAREL (15+)
        $apparel = [
            ['name' => 'Vault 101 Jumpsuit', 'dr' => 5, 'weight' => 1, 'value' => 10],
            ['name' => 'Armored Vault 101 Jumpsuit', 'dr' => 12, 'weight' => 6, 'value' => 120],
            ['name' => 'Leather Armor', 'dr' => 15, 'weight' => 15, 'value' => 150],
            ['name' => 'Raider Painspike Armor', 'dr' => 16, 'weight' => 15, 'value' => 180],
            ['name' => 'Raider Badlands Armor', 'dr' => 14, 'weight' => 15, 'value' => 140],
            ['name' => 'Metal Armor', 'dr' => 20, 'weight' => 30, 'value' => 320],
            ['name' => 'Combat Armor', 'dr' => 28, 'weight' => 25, 'value' => 390],
            ['name' => 'Recon Armor', 'dr' => 20, 'weight' => 20, 'value' => 400],
            ['name' => 'Power Armor', 'dr' => 40, 'weight' => 45, 'value' => 1600],
            ['name' => 'Tesla Armor', 'dr' => 43, 'weight' => 45, 'value' => 1850],
            ['name' => 'Enclave Power Armor', 'dr' => 45, 'weight' => 45, 'value' => 2000],
            ['name' => 'T-51b Power Armor', 'dr' => 50, 'weight' => 40, 'value' => 2500],
            ['name' => 'Radiation Suit', 'dr' => 6, 'weight' => 5, 'value' => 100],
            ['name' => 'Pre-War Casualwear', 'dr' => 1, 'weight' => 2, 'value' => 5],
            ['name' => 'Wasteland Legend Outfit', 'dr' => 8, 'weight' => 3, 'value' => 40],
            ['name' => 'Sheriff\'s Duster', 'dr' => 5, 'weight' => 2, 'value' => 60],
        ];
        foreach ($apparel as $a) Apparel::create($a);

        // 7. AID (15+)
        $aid = [
            ['name' => 'Stimpak', 'effect' => '+30 HP', 'weight' => 0, 'value' => 25],
            ['name' => 'RadAway', 'effect' => '-50 Rads', 'weight' => 0, 'value' => 40],
            ['name' => 'Rad-X', 'effect' => '+25% Rad Res', 'weight' => 0, 'value' => 30],
            ['name' => 'Nuka-Cola', 'effect' => '+10 HP, +3 Rads', 'weight' => 1, 'value' => 20],
            ['name' => 'Nuka-Cola Quantum', 'effect' => '+20 AP, +10 Rads', 'weight' => 1, 'value' => 30],
            ['name' => 'Purified Water', 'effect' => '+20 HP', 'weight' => 1, 'value' => 20],
            ['name' => 'Dirty Water', 'effect' => '+10 HP, +6 Rads', 'weight' => 1, 'value' => 5],
            ['name' => 'Whiskey', 'effect' => '+1 STR, -1 INT', 'weight' => 1, 'value' => 10],
            ['name' => 'Beer', 'effect' => '+1 STR, -1 INT', 'weight' => 1, 'value' => 2],
            ['name' => 'Jet', 'effect' => '+30 AP', 'weight' => 0, 'value' => 20],
            ['name' => 'Psycho', 'effect' => '+25% DMG', 'weight' => 0, 'value' => 40],
            ['name' => 'Buffout', 'effect' => '+2 STR, +2 END', 'weight' => 0, 'value' => 30],
            ['name' => 'Mentats', 'effect' => '+2 PER, +2 INT', 'weight' => 0, 'value' => 30],
            ['name' => 'Med-X', 'effect' => '+25% DR', 'weight' => 0, 'value' => 30],
            ['name' => 'Salisbury Steak', 'effect' => '+15 HP, +2 Rads', 'weight' => 1, 'value' => 10],
            ['name' => 'Sugar Bombs', 'effect' => '+5 HP, +2 Rads', 'weight' => 1, 'value' => 5],
        ];
        foreach ($aid as $a) Aid::create($a);

        // 8. MISC (15+)
        $misc = [
            ['name' => 'Bobby Pin', 'weight' => 0, 'value' => 1],
            ['name' => 'Bottle Cap', 'weight' => 0, 'value' => 1],
            ['name' => 'Pre-War Money', 'weight' => 0, 'value' => 10],
            ['name' => 'Conductor', 'weight' => 1, 'value' => 15],
            ['name' => 'Sensor Module', 'weight' => 2, 'value' => 30],
            ['name' => 'Fission Battery', 'weight' => 5, 'value' => 75],
            ['name' => 'Scrap Metal', 'weight' => 1, 'value' => 1],
            ['name' => 'Bent Tin Can', 'weight' => 1, 'value' => 0],
            ['name' => 'Empty Soda Bottle', 'weight' => 1, 'value' => 0],
            ['name' => 'Abraxo Cleaner', 'weight' => 1, 'value' => 5],
            ['name' => 'Wonderglue', 'weight' => 0, 'value' => 10],
            ['name' => 'Duct Tape', 'weight' => 0, 'value' => 5],
            ['name' => 'Leather Belt', 'weight' => 1, 'value' => 2],
            ['name' => 'Lunchbox', 'weight' => 1, 'value' => 5],
            ['name' => 'Cherry Bomb', 'weight' => 0, 'value' => 5],
            ['name' => 'Teddy Bear', 'weight' => 1, 'value' => 3],
        ];
        foreach ($misc as $m) MiscItem::create($m);

        // 9. AMMO (15+)
        $ammo = [
            ['name' => '10mm Round', 'quantity' => 245],
            ['name' => '.32 Caliber Round', 'quantity' => 120],
            ['name' => '5.56mm Round', 'quantity' => 560],
            ['name' => '.308 Caliber Round', 'quantity' => 45],
            ['name' => 'Shotgun Shell', 'quantity' => 84],
            ['name' => '.44 Round Magnum', 'quantity' => 30],
            ['name' => '5mm Round', 'quantity' => 1200],
            ['name' => 'Microfusion Cell', 'quantity' => 350],
            ['name' => 'Energy Cell', 'quantity' => 200],
            ['name' => 'Electron Charge Pack', 'quantity' => 150],
            ['name' => 'Missile', 'quantity' => 8],
            ['name' => 'Mini Nuke', 'quantity' => 2],
            ['name' => 'Flamer Fuel', 'quantity' => 400],
            ['name' => 'BB', 'quantity' => 100],
            ['name' => 'Dart', 'quantity' => 50],
            ['name' => 'Alien Power Cell', 'quantity' => 112],
        ];
        foreach ($ammo as $am) Ammo::create($am);

        // 10. QUESTS (10)
        $quests = [
            ['title' => 'Baby Steps', 'description' => 'Follow Dad\'s instructions.'],
            ['title' => 'Growing Up Fast', 'description' => 'Attend your 10th birthday party.'],
            ['title' => 'Future Imperfect', 'description' => 'Take the G.O.A.T. exam.'],
            ['title' => 'Escape!', 'description' => 'Escape Vault 101.'],
            ['title' => 'Following in His Footsteps', 'description' => 'Find out where Dad went. Check Megaton.'],
            ['title' => 'The Power of the Atom', 'description' => 'Decide the fate of Megaton\'s atomic bomb.'],
            ['title' => 'Galaxy News Radio', 'description' => 'Help Three Dog at GNR Plaza to get info about Dad.'],
            ['title' => 'Scientific Pursuits', 'description' => 'Look for Dr. Li in Rivet City.'],
            ['title' => 'The Waters of Life', 'description' => 'Secure the Jefferson Memorial for Project Purity.'],
            ['title' => 'Picking Up the Trail', 'description' => 'Gain access to Little Lamplight.'],
        ];
        foreach ($quests as $q) Quest::create($q);

        // 11. NOTES (20)
        $notes = [
            ['title' => 'Dad\'s Note', 'content' => 'I am sorry I had to leave. I have work to do. Love, Dad.'],
            ['title' => 'Moriarty\'s Password', 'content' => 'Password for the terminal: "Apocalypse".'],
            ['title' => 'Megaton Clinic Info', 'content' => 'Doc Church can heal rads for 100 caps.'],
            ['title' => 'Super Duper Mart Flyer', 'content' => 'Sale on Cram! 50% off! (Expired 200 years ago)'],
            ['title' => 'Minefield Coordinates', 'content' => 'Be careful near the playground. Arkansas is watching.'],
            ['title' => 'Arefu Incident Report', 'content' => 'West family has not reported in for days.'],
            ['title' => 'The Family Rules', 'content' => '1. Do not feed on the cattle. 2. Meditate daily.'],
            ['title' => 'Project Purity Journal', 'content' => 'We need the G.E.C.K. to make this work.'],
            ['title' => 'Vault 101 Overseer Log', 'content' => 'No one enters, no one leaves. That is the rule.'],
            ['title' => 'Jonas\'s Goodbye', 'content' => 'If you find this, they probably got me. Good luck, kid.'],
            ['title' => 'Moira\'s Research', 'content' => 'Testing radiation effects... on you!'],
            ['title' => 'Rivet City Market Schedule', 'content' => 'Flak & Shrapnel open at 0800.'],
            ['title' => 'Brotherhood Holotape', 'content' => 'Paladin Kodiak reporting. Super Mutants spotted near the Mall.'],
            ['title' => 'Enclave Radio Frequency', 'content' => 'Tune in to hear President Eden.'],
            ['title' => 'Oasis Coordinates', 'content' => 'A place with green trees? Must be a myth.'],
            ['title' => 'Tenpenny Tower Invitation', 'content' => 'Come live in luxury! Ghouls need not apply.'],
            ['title' => 'Agatha\'s Song Request', 'content' => 'Please find me a Soil Stradivarius.'],
            ['title' => 'Lincoln\'s Repeater Map', 'content' => 'Located in the Museum of History offices.'],
            ['title' => 'Declaration of Independence', 'content' => 'We need to recover it from the National Archives.'],
            ['title' => 'Reilly\'s Rangers Distress Call', 'content' => 'Trapped on the roof of the Statesman Hotel. Send help.'],
        ];
        foreach ($notes as $n) Note::create($n);
    }
}
