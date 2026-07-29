<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Retourne les catégories triées avec le nombre de produits associés.
     */
    public function index(): AnonymousResourceCollection
    {
        // withCount ajoute products_count sans charger tous les produits.
        return CategoryResource::collection(
            Category::query()->withCount('products')->orderBy('name')->get()
        );
    }

    /**
     * Valide et crée une nouvelle catégorie.
     */
    public function store(Request $request): JsonResponse
    {
        $category = Category::create($this->validateCategory($request));

        return (new CategoryResource($category))->response()->setStatusCode(201);
    }

    /**
     * Affiche une catégorie grâce au route model binding de Laravel.
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category->loadCount('products'));
    }

    /**
     * Met à jour la catégorie reçue dans l'URL.
     */
    public function update(Request $request, Category $category): CategoryResource
    {
        $category->update($this->validateCategory($request, $category));

        return new CategoryResource($category->refresh()->loadCount('products'));
    }

    /**
     * Supprime une catégorie et retourne une réponse HTTP 204.
     */
    public function destroy(Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }

    private function validateCategory(Request $request, ?Category $category = null): array
    {
        // ignore($category) autorise une catégorie à conserver son nom pendant la modification.
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')->ignore($category)],
            'description' => ['nullable', 'string'],
        ]);
    }
}
