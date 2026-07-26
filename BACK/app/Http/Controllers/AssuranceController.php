<?php

namespace App\Http\Controllers;

use App\Http\Resources\assuranceResource;
use App\Models\Assurance;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AssuranceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/assurances",
     *     tags={"Assurances"},
     *     summary="Lister toutes les assurances",
     *     @OA\Response(
     *         response=200,
     *         description="Liste des assurances",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Assurance")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $assurance = Assurance::all();
        return assuranceResource::collection($assurance);
    }

    /**
     * @OA\Post(
     *     path="/api/assurances",
     *     tags={"Assurances"},
     *     summary="Créer une assurance",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"libelle","montant","type_id"},
     *             @OA\Property(property="libelle", type="string", example="Assurance auto"),
     *             @OA\Property(property="montant", type="number", format="float", example=150.50),
     *             @OA\Property(property="bonus", type="number", format="float", example=10),
     *             @OA\Property(property="type_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assurance créée",
     *         @OA\JsonContent(ref="#/components/schemas/Assurance")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $assurance = new Assurance();
        $assurance->libelle = request('libelle');
        $assurance->montant = request('montant');
        $assurance->bonus = request('bonus');
        $assurance->type_id = request("type_id");
        $assurance->save();
        return new assuranceResource($assurance);
    }

    /**
     * @OA\Get(
     *     path="/api/assurances/{id}",
     *     tags={"Assurances"},
     *     summary="Afficher une assurance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détail de l'assurance",
     *         @OA\JsonContent(ref="#/components/schemas/Assurance")
     *     ),
     *     @OA\Response(response=404, description="Assurance non trouvée")
     * )
     */
    public function show(Assurance $assurance)
    {
        return new assuranceResource($assurance);
    }

    /**
     * @OA\Put(
     *     path="/api/assurances/{id}",
     *     tags={"Assurances"},
     *     summary="Mettre à jour une assurance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="libelle", type="string", example="Assurance moto"),
     *             @OA\Property(property="montant", type="number", format="float", example=200),
     *             @OA\Property(property="bonus", type="number", format="float", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assurance mise à jour",
     *         @OA\JsonContent(ref="#/components/schemas/Assurance")
     *     ),
     *     @OA\Response(response=404, description="Assurance non trouvée")
     * )
     */
    public function update(Request $request, Assurance $assurance)
    {
        //$assurance = Assurance::find($request['id']);
        $assurance->libelle = $request['libelle'];
        $assurance->montant = $request['montant'];
        $assurance->bonus = $request['bonus'];
        $assurance->save();
        return new AssuranceRessource($assurance);
    }

    /**
     * @OA\Delete(
     *     path="/api/assurances/{id}",
     *     tags={"Assurances"},
     *     summary="Supprimer une assurance",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Bien supprimé"),
     *     @OA\Response(response=404, description="Assurance non trouvée")
     * )
     */
    public function destroy(Assurance $assurance)
    {
        $assurance->delete();
        return response()->json("Bien supprimer");
    }
}
