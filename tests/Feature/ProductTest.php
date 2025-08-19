<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
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

    public function test_no_products_available(): void
    {
       
        //$response = $this->get('/products');
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
        $response->assertSee('No Products Available');
    }

    public function test_products_available(): void
    {
        
        $product = Product::create([
            'name' => 'Product 1',
            'price' => 300
        ]);
        $response = $this->actingAs($this->user)->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('No Products Available');
        $response->assertSee('Product 1');
        $response->assertViewHas('allproducts',function ($collection) use ($product) {
            return $collection->contains($product);
        });
    }

    public function test_paginated_products_table_doesnt_contain_11th_record(): void
    {
        
        $products = Product::factory(11)->create();
        $lastProduct = $products->last();

        // for ($i = 1; $i <= 11 ; $i++){
             
        //     $product = Product::create([
        //     'name' => 'Product ' .$i,
        //     'price' => rand(100,999)

        // ]);
        // }

        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
        $response->assertViewHas('allproducts',function ($collection) use ($lastProduct) {
            return !$collection->contains($lastProduct);
        });
         
    }

    public function test_admin_can_see_product_create_button()
    {
        $response = $this->actingAs($this->admin)->get('/products');
        $response->assertStatus(200);
        $response->assertSee('Add new Product');
    }

    public function test_non_admin_cannot_see_product_create_button()
    {
        $response = $this->actingAs($this->user)->get('/products');
        $response->assertStatus(200);
        $response->assertDontSee('Add new Product');
    }

    public function test_admin_can_access_product_create_page()
    {
        $response = $this->actingAs($this->admin)->get('/products/create');
        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_product_create_page()
    {
        $response = $this->actingAs($this->user)->get('/products/create');
        $response->assertStatus(403);
        
    }

    // public function test_create_product_success()
    // {
    //     $product = [

    //          'name' => 'Product 123',
    //          'price' => 1222
    //     ];
        
    //     $response = $this->actingAs($this->admin)->post('/products/store',$product);
    //     $response->assertStatus(302);
    //     $response->assertRedirect('products');
    //     $this->assertDatabaseHas('products',$product);
        
    //     $latest_product = Product::latest()->first();
    //     $this->assertEquals($product['name'], $latest_product['name']);
    //     $this->assertEquals($product['price'], $latest_product['price']);
    // }

    public function test_product_edit_contains_correct_values()
    {

        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->get('/products/'.$product->id.'/edit');
        $response->assertStatus(200);
        $response->assertSee('value="'.$product->name.'"',false); // enable to test for input data value
        $response->assertSee('value="'.$product->price.'"',false);
        $response->assertViewHas('theproduct', $product);
    }

    public function test_product_validation_throws_error_redirect_back_to_form()
    {
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->put('/update/products/'.$product->id,[

              'name' => '',
              'price' => ''
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['name','price']);
    }

    public function test_product_delete_succesful()
    {
        $product = Product::factory()->create();
        $response = $this->actingAs($this->admin)->delete('/delete/'.$product->id);
        $response->assertStatus(302);
        $response->assertRedirect('products');
        $this->assertDatabaseMissing('products', $product->toArray());
        $this->assertDatabaseCount('products', 0);
       
    }

    private function createUser(bool $isAdmin = false): User
    {
        return User::factory()->create([
            'is_admin' => $isAdmin
        ]);
    }
}
