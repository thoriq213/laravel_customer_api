<?php

namespace Tests\Feature;

use App\Models\Address_store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_add_address()
    {
        $data = [
            'customer_id' => 3,
            'address' => 'Jalan raya Jakarta',
            'district' => 'Pulogadung',
            'city' => 'Jakarta Timur',
            'province' => 'DKI Jakarta',
            'postal_code' => 12345,
        ];

        $response = $this->postJson('/address', $data);
        $response->assertStatus(200);

        $id = $response->json('data.id');
        Address_store::find($id)->forceDelete();
    }

    public function test_update_address()
    {
        $data = [
            'address' => 'Jalan raya Bekasi',
            'district' => 'Cakung',
            'city' => 'Bekasi Barat',
            'province' => 'Jawa Barat',
            'postal_code' => 54321,
        ];

        $response = $this->patchJson('/address/3', $data);
        $response->assertStatus(200);
    }

    public function test_delete_address()
    {
        $response = $this->deleteJson('/address/3');
        $response->assertStatus(200);

        Address_store::onlyTrashed()->findOrFail(3)->restore();
    }
}
