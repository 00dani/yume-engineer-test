<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function testCanListAllProducts(): void
    {
        Product::factory()->createMany(8);
        $response = $this->loggedIn()->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonCount(8);
    }

    public function testCanViewOneProductById(): void
    {
        Product::factory()->createMany(5);
        $product = Product::factory()->createOne();

        $response = $this->loggedIn()->getJson("/api/products/$product->id");

        $response->assertStatus(200);
        $response->assertJson($product->toArray());
    }

    public function testCanCreateNewProducts(): void
    {
        $request = [
            'name' => 'Half A Sandwich',
            'description' => 'Someone already ate the other half sorry',
            'price' => '0.50',
        ];
        $response = $this->loggedIn()->postJson('/api/products', $request);

        $response->assertStatus(201);
        $response->assertJson($request);

        // Verify that the new product really got saved to the database
        $getResponse = $this->loggedIn()->getJson("/api/products/" . $response->json('id'));
        $getResponse->assertStatus(200);
        $getResponse->assertJson($request);
    }

    public function testValidatesNewProductsHaveNames(): void
    {
        $request = [
            'description' => 'Mystery meat??',
            'price' => '30.70',
        ];

        $response = $this->loggedIn()->postJson('/api/products', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The name field is required.',
            'errors' => [
                'name' => ['The name field is required.'],
            ],
        ]);
    }

    public function testValidatesNewProductNamesAreLongEnough(): void
    {
        $request = [
            'name' => 'ab', // too short!
            'description' => 'Dunno what food that is haha',
            'price' => '0.70',
        ];

        $response = $this->loggedIn()->postJson('/api/products', $request);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The name field must be at least 3 characters.',
            'errors' => [
                'name' => ['The name field must be at least 3 characters.'],
            ],
        ]);
    }

    public function testCanUpdateExistingProductNames(): void
    {
        $product = Product::factory()->createOne();
        self::assertNotSame('foobar', $product->name);

        $response = $this->loggedIn()->putJson("/api/products/$product->id", ['name' => 'foobar']);

        $response->assertStatus(200);

        $getResponse = $this->loggedIn()->getJson("/api/products/$product->id");
        self::assertSame('foobar', $getResponse->json('name'));
    }

    public function testValidatesUpdatedProductNamesAreLongEnough(): void
    {
        $product = Product::factory()->createOne();
        self::assertNotSame('cd', $product->name);

        $response = $this->loggedIn()->putJson("/api/products/$product->id", ['name' => 'cd']);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The name field must be at least 3 characters.',
            'errors' => [
                'name' => ['The name field must be at least 3 characters.'],
            ],
        ]);

        $getResponse = $this->loggedIn()->getJson("/api/products/$product->id");
        self::assertSame($product->name, $getResponse->json('name'));
    }

    public function testCanUpdateOtherProductFieldsWithoutName(): void
    {
        $product = Product::factory()->createOne();
        self::assertNotSame('12.34', $product->price);

        $response = $this->loggedIn()->putJson("/api/products/$product->id", ['price' => '12.34']);

        $response->assertStatus(200);

        $getResponse = $this->loggedIn()->getJson("/api/products/$product->id");
        self::assertSame('12.34', $getResponse->json('price'));
    }

    public function testCanDeleteProducts(): void
    {
        $product = Product::factory()->createOne();
        self::assertNotSame('foobar', $product->name);

        $response = $this->loggedIn()->deleteJson("/api/products/$product->id");
        $response->assertStatus(204);

        $getResponse = $this->loggedIn()->getJson("/api/products/$product->id");
        $getResponse->assertStatus(404);
    }
}
