<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    /**
     * @\OpenApi\Annotations\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     summary="Lister les produits",
     *     @\OpenApi\Annotations\Response(response=200, description="Liste des produits"),
     *     @\OpenApi\Annotations\Response(response=401, description="Non authentifié")
     * )
     */
    #[OA\Get(
        path: '/api/products',
        summary: 'Lister les produits',
        security: [['sanctum' => []]],
        tags: ['Products'],
        responses: [
            new OA\Response(response: 200, description: 'Liste des produits'),
            new OA\Response(response: 401, description: 'Non authentifié'),
        ],
    )]
    public function index(): AnonymousResourceCollection
    {
        // with('category') évite une requête SQL supplémentaire pour chaque produit.
        return ProductResource::collection(
            Product::query()->with('category')->latest()->get()
        );
    }

    /**
     * @\OpenApi\Annotations\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     summary="Créer un produit",
     *     @\OpenApi\Annotations\RequestBody(
     *         required=true,
     *         @\OpenApi\Annotations\JsonContent(
     *             required={"name", "price"},
     *             @\OpenApi\Annotations\Property(property="name", type="string", example="Ordinateur"),
     *             @\OpenApi\Annotations\Property(property="price", type="integer", example=250000),
     *             @\OpenApi\Annotations\Property(property="description", type="string")
     *         )
     *     ),
     *     @\OpenApi\Annotations\Response(response=201, description="Produit créé"),
     *     @\OpenApi\Annotations\Response(response=422, description="Données invalides")
     * )
     */
    #[OA\Post(
        path: '/api/products',
        summary: 'Créer un produit',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'price'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Ordinateur'),
                    new OA\Property(property: 'price', type: 'integer', example: 250000),
                    new OA\Property(property: 'description', type: 'string'),
                ],
            ),
        ),
        tags: ['Products'],
        responses: [
            new OA\Response(response: 201, description: 'Produit créé'),
            new OA\Response(response: 422, description: 'Données invalides'),
        ],
    )]
    public function store(Request $request): JsonResponse
    {
        // La validation est centralisée pour être réutilisée lors d'une modification.
        $product = Product::create($this->validateProduct($request));

        // Une création REST réussie retourne le statut HTTP 201.
        return (new ProductResource($product->load('category')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @\OpenApi\Annotations\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     summary="Afficher un produit",
     *     @\OpenApi\Annotations\Parameter(name="id", in="path", required=true, @\OpenApi\Annotations\Schema(type="integer")),
     *     @\OpenApi\Annotations\Response(response=200, description="Produit trouvé"),
     *     @\OpenApi\Annotations\Response(response=404, description="Produit introuvable")
     * )
     */
    #[OA\Get(
        path: '/api/products/{id}',
        summary: 'Afficher un produit',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Produit trouvé'),
            new OA\Response(response: 404, description: 'Produit introuvable'),
        ],
    )]
    public function show(Product $product): ProductResource
    {
        // Laravel trouve le produit grâce au paramètre {product} de la route.
        return new ProductResource($product->load('category'));
    }

    /**
     * @\OpenApi\Annotations\Put(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     summary="Modifier un produit",
     *     @\OpenApi\Annotations\Parameter(name="id", in="path", required=true, @\OpenApi\Annotations\Schema(type="integer")),
     *     @\OpenApi\Annotations\RequestBody(required=true, @\OpenApi\Annotations\JsonContent(ref="#/components/schemas/Product")),
     *     @\OpenApi\Annotations\Response(response=200, description="Produit modifié")
     * )
     */
    #[OA\Put(
        path: '/api/products/{id}',
        summary: 'Modifier un produit',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/Product')),
        responses: [new OA\Response(response: 200, description: 'Produit modifié')],
    )]
    public function update(Request $request, Product $product): ProductResource
    {
        $product->update($this->validateProduct($request));

        // refresh() relit les valeurs enregistrées avant de construire la réponse JSON.
        return new ProductResource($product->refresh()->load('category'));
    }

    /**
     * @\OpenApi\Annotations\Delete(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     security={{"sanctum":{}}},
     *     summary="Supprimer un produit",
     *     @\OpenApi\Annotations\Parameter(name="id", in="path", required=true, @\OpenApi\Annotations\Schema(type="integer")),
     *     @\OpenApi\Annotations\Response(response=204, description="Produit supprimé")
     * )
     */
    #[OA\Delete(
        path: '/api/products/{id}',
        summary: 'Supprimer un produit',
        security: [['sanctum' => []]],
        tags: ['Products'],
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 204, description: 'Produit supprimé')],
    )]
    public function destroy(Product $product): Response
    {
        $product->delete();

        // Une suppression réussie retourne un statut HTTP 204 sans contenu.
        return response()->noContent();
    }

    private function validateProduct(Request $request): array
    {
        // exists garantit que la catégorie choisie existe réellement en base.
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);
    }
}
