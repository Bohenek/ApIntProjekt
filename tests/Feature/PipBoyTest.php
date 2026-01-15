<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Weapon;

class PipBoyTest extends TestCase
{
    // Czyści bazę i wykonuje migracje przed każdym testem
    use RefreshDatabase;

    /**
     * Test 1: Przekierowanie
     */
    public function test_it_redirects_home_to_stats()
    {
        $response = $this->get('/');
        // Jeśli używasz named routes:
        // $response->assertRedirect(route('stats'));
        // Jeśli hardcodujesz URL:
        $response->assertRedirect('/stats');
    }

    /**
     * Test 2: Wyświetlanie przedmiotów
     */
    public function test_it_displays_weapons_correctly()
    {
        // Tworzymy broń
        Weapon::create([
            'name' => 'Fat Man', 
            'damage' => 1000, 
            'weight' => 30, 
            'value' => 2000
        ]);
        
        // Wchodzimy na stronę
        $response = $this->get('/items?tab=weapons');
        
        $response->assertStatus(200);
        $response->assertSee('Fat Man');
        
        // Te asercje sprawdzają czy statystyki się wyświetlają
        // Uwaga: upewnij się, że w widoku "Weapons" masz tekst "DAM"
        if ($response->getContent()) {
             $response->assertSee('DAM'); 
             $response->assertSee('1000');
        }
    }

    /**
     * Test 3: Admin może usuwać
     */
    public function test_admin_can_delete_item()
    {
        // 1. Tworzymy admina i przedmiot
        $admin = User::factory()->create(['is_admin' => true]);
        $weapon = Weapon::create(['name' => 'Test Gun', 'damage' => 10, 'weight' => 1, 'value' => 1]);

        // 2. Wykonujemy akcję usuwania jako admin bezpośrednio na backend
        $response = $this->actingAs($admin)->delete(route('items.delete', $weapon->id), [
            'type' => 'weapons'
        ]);

        // 3. Sprawdzamy przekierowanie
        $response->assertRedirect();

        // 4. Sprawdzamy czy przedmiot zniknął z bazy
        $this->assertDatabaseMissing('weapons', ['id' => $weapon->id]);
    }

    /**
     * Test 4: Zwykły user NIE może usuwać
     */
    public function test_regular_user_cannot_delete_item()
    {
        // 1. Tworzymy zwykłego usera i przedmiot
        $user = User::factory()->create(['is_admin' => false]);
        $weapon = Weapon::create(['name' => 'Admin Gun', 'damage' => 999, 'weight' => 1, 'value' => 1]);

        // 2. Próbujemy usunąć jako zwykły user
        $response = $this->actingAs($user)->delete(route('items.delete', $weapon->id), [
            'type' => 'weapons'
        ]);

        // 3. Oczekujemy błędu 403 (Forbidden)
        $response->assertStatus(403);

        // 4. Upewniamy się, że przedmiot NADAL jest w bazie
        $this->assertDatabaseHas('weapons', ['id' => $weapon->id]);
    }

    /**
     * Test 5: Dostępność
     */
    public function test_pages_contain_accessibility_elements()
    {
        $response = $this->get('/data'); // Używamy /data lub /stats
        $response->assertStatus(200);
        
        // 1. Sprawdzamy przycisk kontrastu (nowy layout ma aria-pressed)
        $response->assertSee('aria-pressed="false"', false);
        
        // 2. Sprawdzamy przyciski czcionki
        $response->assertSee('aria-label="Powiększ tekst"', false);
        
        // 3. Sprawdzamy rolę main i listbox
        $response->assertSee('role="main"', false);
        $response->assertSee('role="listbox"', false);
    }
}
