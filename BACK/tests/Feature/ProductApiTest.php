<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_are_publicly_accessible(): void
    {
        $this->getJson('/api/products')->assertOk();
    }

    public function test_user_can_manage_products_without_authentication(): void
    {
        $category = Category::factory()->create();

        $created = $this->postJson('/api/products', [
            'name' => 'Ordinateur',
            'price' => 250000,
            'description' => 'Ordinateur portable',
            'category_id' => $category->id,
        ])->assertCreated()
            ->assertJsonPath('data.name', 'Ordinateur')
            ->assertJsonPath('data.price', 250000);

        $productId = $created->json('data.id');

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->putJson("/api/products/{$productId}", [
            'name' => 'Ordinateur Pro',
            'price' => 300000,
            'description' => 'Nouvelle description',
            'category_id' => $category->id,
        ])->assertOk()
            ->assertJsonPath('data.name', 'Ordinateur Pro');

        $this->deleteJson("/api/products/{$productId}")
            ->assertNoContent();

        $this->assertDatabaseMissing('products', ['id' => $productId]);
    }
}
