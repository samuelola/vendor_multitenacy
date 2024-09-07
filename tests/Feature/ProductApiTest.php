<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductApiTest extends TestCase
{
    
    use RefreshDatabase;

    private User $user;
    private User $admin;

    protected function setUp():void
    {
        parent::setup();
        $this->user = $this->createUser();
        $this->admin = $this->createUser(isAdmin: true);
    }

    public function test_api_product_validation_throws_error()
    {
        $product = Product::factory()->create();
        // $response = $this->actingAs($this->admin)->put('/update/products/'.$product->id,[

        //       'name' => '',
        //       'price' => ''
        // ]);

        $product = [
            'name' => '',
            'price' => ''
        ];
        $response = $this->postJson('/api/products',$product);
        $response->assertStatus(422);
        $response->assertInvalid(['name','price']);
    }

    public function test_api_returns_products_list()
    {
        $product = Product::factory()->create();
        $response = $this->getJson('/api/products');
        $response->assertJson([$product->toArray()]);
    }

    public function test_api_no_products_available(): void
    {
       
        $response = $this->getJson('/api/products');
        //$response = $this->actingAs($this->user)->getJson('/products');
        $response->assertStatus(200);
        
    }

    public function test_api_product_store_successful()
    {
        $product = [
            'name' => 'Product new',
            'price' => '1238'
        ];
        $response = $this->postJson('/api/products',$product);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products',$product);
    }

    public function test_api_product_update_successful()
    {
         $product = Product::factory()->create();
         $updateproduct = [
            'name' => 'Product new',
            'price' => '1263'
         ];
         $response = $this->putJson('/api/products/'.$product->id,$updateproduct);
         $response->assertStatus(200);
         $this->assertDatabaseHas('products',$updateproduct);
         
    }

    public function test_api_single_product_successful()
    {
         $product = Product::factory()->create();
         $response = $this->getJson('/api/products/'.$product->id);
         $response->assertStatus(200);
         $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price
         ]);
         
    }

    public function test_api_delete_product_successful()
    {
         $product = Product::factory()->create();
         $response = $this->deleteJson('/api/products/'.$product->id);
         $response->assertStatus(200);
         $this->assertDatabaseMissing('products',['id'=>$product->id]);
         $this->assertDatabaseCount('products', 0);
    }

    public function test_api_product_invalid_store_return_error()
    {
        $product = [
            'name' => '',
            'price' => '123'
        ];
        $response = $this->postJson('/api/products',$product);
        $response->assertStatus(422);
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
