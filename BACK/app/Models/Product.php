<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Attributes as OA;

/**
 * @\OpenApi\Annotations\Schema(
 *     schema="Product",
 *     required={"id", "name", "price"},
 *     @\OpenApi\Annotations\Property(property="id", type="integer", example=1),
 *     @\OpenApi\Annotations\Property(property="name", type="string", example="Ordinateur"),
 *     @\OpenApi\Annotations\Property(property="price", type="integer", example=250000),
 *     @\OpenApi\Annotations\Property(property="description", type="string", nullable=true)
 * )
 */
#[OA\Schema(
    schema: 'Product',
    required: ['id', 'name', 'price'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Ordinateur'),
        new OA\Property(property: 'price', type: 'integer', example: 250000),
        new OA\Property(property: 'description', type: 'string', nullable: true),
    ],
)]
class Product extends Model
{
    use HasFactory;

    // Champs autorisés pour Product::create() et update().
    protected $fillable = [
        'name',
        'price',
        'description',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        // products.category_id référence categories.id.
        return $this->belongsTo(Category::class);
    }
}
