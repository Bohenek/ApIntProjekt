<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Weapon;

class PipBoyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_redirects_home_to_stats()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('stats'));
    }

    public function test_it_displays_weapons_correctly()
    {
        // Tworzymy broń
        Weapon::create([
            'name' => 'Fat Man', 
            'damage' => 1000, 
            'weight' => 30, 
            'value' => 2000
        ]);
        
        $response = $this->get('/items?tab=weapons');
        
        $response->assertStatus(200);
        $response->assertSee('Fat Man');
        $response->assertSee('DAM'); 
        $response->assertSee('1000');
    }

    public function test_admin_can_delete_item()
    {
        // 1. Tworzymy admina i przedmiot
        $admin = User::factory()->create(['is_admin' => true]);
        $weapon = Weapon::create(['name' => 'Test Gun', 'damage' => 10, 'weight' => 1, 'value' => 1]);

        // 2. Wykonujemy akcję usuwania jako admin
        // Używamy requestu DELETE na trasę items.delete
        $response = $this->actingAs($admin)->delete(route('items.delete', $weapon->id), [
            'type' => 'weapons'
        ]);

        // 3. Sprawdzamy czy przekierowało z powrotem (standardowe zachowanie kontrolera)
        $response->assertRedirect();

        // 4. Sprawdzamy czy przedmiot zniknął z bazy
        $this->assertDatabaseMissing('weapons', ['id' => $weapon->id]);
    }

    public function test_regular_user_cannot_delete_item()
    {
        // 1. Tworzymy zwykłego usera i przedmiot
        $user = User::factory()->create(['is_admin' => false]);
        $weapon = Weapon::create(['name' => 'Admin Gun', 'damage' => 999, 'weight' => 1, 'value' => 1]);

        // 2. Próbujemy usunąć jako zwykły user
        $response = $this->actingAs($user)->delete(route('items.delete', $weapon->id), [
            'type' => 'weapons'
        ]);

        // 3. Oczekujemy błędu 403 (Forbidden) - tak ustawiliśmy w kontrolerze
        $response->assertStatus(403);

        // 4. Upewniamy się, że przedmiot NADAL jest w bazie
        $this->assertDatabaseHas('weapons', ['id' => $weapon->id]);
    }

    public function test_pages_contain_accessibility_elements()
    {
        $response = $this->get('/stats');
        
        // Sprawdzamy nowy tekst przycisku z layoutu
        $response->assertSee('High Contrast');
        // Sprawdzamy czy przycisk ma odpowiedni atrybut ARIA
        $response->assertSee('aria-label="Przełącz tryb wysokiego kontrastu"', false);
    }
}
