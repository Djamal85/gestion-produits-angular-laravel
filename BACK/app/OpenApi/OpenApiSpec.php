<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Gestion Produits API',
    description: 'API Laravel sécurisée avec Sanctum pour gérer les produits',
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Token',
)]
class OpenApiSpec
{
}
