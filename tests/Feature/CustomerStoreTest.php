<?php

namespace Tests\Feature;

use App\Models\Customer_store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_customer()
    {
        $response = $this->getJson('/api/customer');
        $response->assertStatus(200);
    }

    public function test_get_customer_by_id()
    {
        $response = $this->getJson('/api/customer/4');
        $response->assertStatus(200);
    }

    public function test_add_customer()
    {
        $data = [
            'title' => 'mr',
            'name' => 'Edward',
            'gender' => 'M',
            'phone_number' => '08124124124',
            'image' => 'https://img.freepik.com/premium-vector/man-avatar-profile-round-icon_24640-14044.jpg',
            'email' => 'adrien.philippe@gmail.com',
        ];

        $response = $this->postJson('/api/customer', $data);
        $response->assertStatus(200);

        $id = $response->json('data.id');
        Customer_store::find($id)->forceDelete();
    }

    public function test_update_customer()
    {
        $data = [
            'title' => 'mr',
            'name' => 'Edward',
            'gender' => 'M',
            'phone_number' => '08124124124',
            'image' => 'https://img.freepik.com/premium-vector/man-avatar-profile-round-icon_24640-14044.jpg',
            'email' => 'adrien.philippe@gmail.com',
        ];

        $response = $this->patchJson('/api/customer/4', $data);
        $response->assertStatus(200);
    }

    public function test_delete_customer()
    {
        $response = $this->deleteJson('/api/customer/4');
        $response->assertStatus(200);

        Customer_store::onlyTrashed()->findOrFail(4)->restore();
    }
}
