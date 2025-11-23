<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    use RefreshDatabase;

    private $admin;
    private $homeowner;
    private $handyman;

    protected function setUp(): void{
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->homeowner = User::factory()->create(['role' => 'homeowner']);
        $this->handyman = User::factory()->create(['role' => 'handyman','verified'=> false]);
    }

    /**@test */
    public function guests_are_redirected_from_admin_user_list(){
        $response = $this->get('/admin/users');
        $response->assertRedirect('/login');
    }

    /**@test */
    public function non_admins_are_forbidden_from_admin_user_list(){
        $response = $this->actingAs($this->homeowner)->get('/admin/users');
        $response->assertForbidden();
        
        $response = $this->actingAs($this->handyman)->get('/admin/users');
        $response->assertForbidden();
    }

    /**@test */
    public function admin_can_view_the_user_list()
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee($this->homeowner->name);
        $response->assertSee($this->handyman->name);
    }

    /**@test */
    public function admin_can_verify_a_handyman(){
        $this->assertFalse($this->handyman->verified);

        $response = $this->actingAs($this->admin)->post(route('admin.users.verify', $this->handyman));

        $response->assertRedirect();
        $this->assertTrue($this->handyman->fresh()->verified);
    }

    /**@test */
    public function admin_cannot_delete_their_own_account(){
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin));
        $response->assertRedirect();
        $this->assertDatabaseHas('users',['id'=>$this->admin->id]);
    }
}