<?php

namespace Tests\Feature;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuperAdminTest extends TestCase
{
    use RefreshDatabase;

    private function createSuperAdmin(): User
    {
        return User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'outlet_id' => null,
            'email_verified_at' => now(),
        ]);
    }

    private function createRegularUser(): User
    {
        $outlet = Outlet::create([
            'name' => 'Regular Outlet',
        ]);

        return User::create([
            'name' => 'Regular User',
            'username' => 'regularuser',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
            'outlet_id' => $outlet->id,
            'email_verified_at' => now(),
        ]);
    }

    public function test_superadmin_dashboard_requires_auth(): void
    {
        $response = $this->get(route('superadmin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_superadmin_cannot_access_superadmin_dashboard(): void
    {
        $user = $this->createRegularUser();
        $this->actingAs($user);

        $response = $this->get(route('superadmin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_superadmin_can_access_superadmin_dashboard(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $response = $this->get(route('superadmin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Super Admin');
    }

    public function test_superadmin_login_redirects_to_superadmin_dashboard(): void
    {
        $superadmin = $this->createSuperAdmin();

        $response = $this->post(route('login'), [
            'username' => 'superadmin',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('superadmin.dashboard'));
    }

    public function test_superadmin_can_create_outlet(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $response = $this->post(route('superadmin.outlets.store'), [
            'name' => 'New Outlet Branch',
            'address' => 'Bandung, Indonesia',
            'phone' => '022-99999',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('outlets', [
            'name' => 'New Outlet Branch',
            'address' => 'Bandung, Indonesia',
            'phone' => '022-99999',
        ]);
    }

    public function test_superadmin_can_create_user(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $outlet = Outlet::create(['name' => 'Outlet Bandung']);

        $response = $this->post(route('superadmin.users.store'), [
            'name' => 'New Staff',
            'username' => 'newstaff',
            'email' => 'staff@example.com',
            'password' => 'secret123',
            'role' => 'cashier',
            'outlet_id' => $outlet->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'name' => 'New Staff',
            'username' => 'newstaff',
            'email' => 'staff@example.com',
            'role' => 'cashier',
            'outlet_id' => $outlet->id,
        ]);
    }

    public function test_superadmin_can_update_user(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $user = $this->createRegularUser();
        $newOutlet = Outlet::create(['name' => 'Brand New Outlet']);

        $response = $this->put(route('superadmin.users.update', $user->id), [
            'name' => 'Updated User Name',
            'username' => 'updatedusername',
            'email' => 'updated@example.com',
            'role' => 'admin',
            'outlet_id' => $newOutlet->id,
        ]);

        $response->assertRedirect();
        $user->refresh();
        $this->assertEquals('Updated User Name', $user->name);
        $this->assertEquals('updatedusername', $user->username);
        $this->assertEquals('updated@example.com', $user->email);
        $this->assertEquals('admin', $user->role);
        $this->assertEquals($newOutlet->id, $user->outlet_id);
    }

    public function test_superadmin_can_reset_user_password(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $user = $this->createRegularUser();

        $response = $this->put(route('superadmin.users.password', $user->id), [
            'password' => 'brandnewpassword123',
        ]);

        $response->assertRedirect();
        $user->refresh();
        $this->assertTrue(\Hash::check('brandnewpassword123', $user->password));
    }

    public function test_superadmin_can_delete_user(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $user = $this->createRegularUser();

        $response = $this->delete(route('superadmin.users.destroy', $user->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_superadmin_cannot_delete_self(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $response = $this->delete(route('superadmin.users.destroy', $superadmin->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $superadmin->id]);
    }

    public function test_superadmin_can_update_outlet(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $outlet = Outlet::create([
            'name' => 'Original Outlet Name',
            'phone' => '021-11111',
            'address' => 'Jakarta',
        ]);

        $response = $this->put(route('superadmin.outlets.update', $outlet->id), [
            'name' => 'Updated Outlet Name',
            'phone' => '022-22222',
            'address' => 'Bandung',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('outlets', [
            'id' => $outlet->id,
            'name' => 'Updated Outlet Name',
            'phone' => '022-22222',
            'address' => 'Bandung',
        ]);
    }

    public function test_superadmin_can_delete_outlet_when_no_users_connected(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $outlet = Outlet::create([
            'name' => 'Temporary Outlet',
            'phone' => '022-12345',
            'address' => 'Cimahi',
        ]);

        $response = $this->delete(route('superadmin.outlets.destroy', $outlet->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('outlets', ['id' => $outlet->id]);
    }

    public function test_superadmin_cannot_delete_outlet_when_users_connected(): void
    {
        $superadmin = $this->createSuperAdmin();
        $this->actingAs($superadmin);

        $outlet = Outlet::create([
            'name' => 'Busy Outlet',
            'phone' => '022-12345',
            'address' => 'Cimahi',
        ]);

        $user = User::create([
            'name' => 'Outlet Staff',
            'username' => 'staff123',
            'email' => 'staff@example.com',
            'password' => bcrypt('password'),
            'role' => 'cashier',
            'outlet_id' => $outlet->id,
        ]);

        $response = $this->delete(route('superadmin.outlets.destroy', $outlet->id));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('outlets', ['id' => $outlet->id]);
    }
}
