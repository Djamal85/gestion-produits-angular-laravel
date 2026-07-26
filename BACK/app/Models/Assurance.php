<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Assurance",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="libelle", type="string", example="Assurance auto"),
 *     @OA\Property(property="montant", type="number", format="float", example=150.50),
 *     @OA\Property(property="bonus", type="number", format="float", example=10),
 *     @OA\Property(property="type_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Assurance extends Model
{
    use HasFactory;
    //
}
