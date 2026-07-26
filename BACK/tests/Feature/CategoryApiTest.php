<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_manage_categories_without_authentication(): void
    {
        $created = $this->postJson('/api/categories', [
            'name' => 'Informatique',
            'description' => 'Matériel informatique',
        ])->assertCreated()->assertJsonPath('data.name', 'Informatique');

        $categoryId = $created->json('data.id');

        $this->getJson('/api/categories')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.products_count', 0);

        $this->putJson("/api/categories/{$categoryId}", [
            'name' => 'Électronique',
            'description' => 'Produits électroniques',
        ])->assertOk()->assertJsonPath('data.name', 'Électronique');

        $this->deleteJson("/api/categories/{$categoryId}")->assertNoContent();
        $this->assertDatabaseMissing('categories', ['id' => $categoryId]);
    }
}
