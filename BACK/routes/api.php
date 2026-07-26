<?php

use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Anciennes routes du cours (assurances et types)
|--------------------------------------------------------------------------
|
| Elles sont conservées dans le projet comme référence, mais ne sont plus
| exposées par l'API utilisée par le frontend Angular.
|
*/
// Route::apiResource('assurances', AssuranceController::class);
// Route::apiResource('types', TypeController::class);

/*
|--------------------------------------------------------------------------
| Authentification Sanctum temporairement désactivée
|--------------------------------------------------------------------------
|
| Décommenter ces routes et le groupe middleware pour réactiver
| l'inscription, la connexion et la protection des produits.
|
*/
// Route::post('/register', [AuthentificationController::class, 'register']);
// Route::post('/login', [AuthentificationController::class, 'login']);
// Route::middleware('auth:sanctum')->group(function (): void {
//     Route::apiResource('products', ProductController::class);
//     Route::post('/logout', [AuthentificationController::class, 'logout']);
// });

// Mode public temporaire : aucun token n'est nécessaire.
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
