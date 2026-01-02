<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Weapon;

class PipBoyTest extends TestCase
{
    use RefreshDatabase;

    /** @test 1: Czy strona główna przekierowuje na statystyki */
    public function it_redirects_home_to_stats()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('stats'));
    }

    /** @test 2: Czy baza danych wyświetla bronie */
    public function it_displays_weapons()
    {
        Weapon::create(['name' => 'Fat Man', 'damage' => 1000, 'weight' => 30, 'value' => 2000]);
        
        $response = $this->get('/items');
        $response->assertSee('Fat Man');
        $response->assertSee('DMG: 1000');
    }

    /** @test 3: Czy admin ma dostęp do dashboardu */
    public function admin_can_access_dashboard()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Witaj w panelu administratora');
    }

    /** @test 4: Czy zwykły użytkownik NIE ma dostępu do dashboardu */
    public function regular_user_cannot_access_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);
        
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    /** @test 5: Czy widoki zawierają elementy dostępności (role/aria) */
    public function pages_contain_accessibility_elements()
    {
        $response = $this->get('/stats');
        // Sprawdzamy czy istnieje przycisk do zmiany kontrastu
        $response->assertSee('Tryb dla niedowidzących');
    }
}