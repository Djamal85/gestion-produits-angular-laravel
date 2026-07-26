<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

class AuthentificationController extends Controller
{
    /**
     * @\OpenApi\Annotations\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Créer un compte",
     *     @\OpenApi\Annotations\RequestBody(required=true, @\OpenApi\Annotations\JsonContent(
     *         required={"name", "email", "password", "password_confirmation"},
     *         @\OpenApi\Annotations\Property(property="name", type="string"),
     *         @\OpenApi\Annotations\Property(property="email", type="string", format="email"),
     *         @\OpenApi\Annotations\Property(property="password", type="string", format="password"),
     *         @\OpenApi\Annotations\Property(property="password_confirmation", type="string", format="password")
     *     )),
     *     @\OpenApi\Annotations\Response(response=201, description="Compte créé et token retourné")
     * )
     */
    #[OA\Post(
        path: '/api/register',
        summary: 'Créer un compte',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'password_confirmation'],
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'password', type: 'string', format: 'password'),
                    new OA\Property(property: 'password_confirmation', type: 'string', format: 'password'),
                ],
            ),
        ),
        tags: ['Authentication'],
        responses: [new OA\Response(response: 201, description: 'Compte créé et token retourné')],
    )]
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * @\OpenApi\Annotations\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Se connecter",
     *     @\OpenApi\Annotations\RequestBody(required=true, @\OpenApi\Annotations\JsonContent(
     *         required={"email", "password"},
     *         @\OpenApi\Annotations\Property(property="email", type="string", format="email"),
     *         @\OpenApi\Annotations\Property(property="password", type="string", format="password")
     *     )),
     *     @\OpenApi\Annotations\Response(response=200, description="Token Bearer retourné"),
     *     @\OpenApi\Annotations\Response(response=401, description="Identifiants incorrects")
     * )
     */
    #[OA\Post(
        path: '/api/login',
        summary: 'Se connecter',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email'),
                    new OA\Property(property: 'password', type: 'string', format: 'password'),
                ],
            ),
        ),
        tags: ['Authentication'],
        responses: [
            new OA\Response(response: 200, description: 'Token Bearer retourné'),
            new OA\Response(response: 401, description: 'Identifiants incorrects'),
        ],
    )]
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Identifiants incorrects'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @\OpenApi\Annotations\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     summary="Se déconnecter",
     *     @\OpenApi\Annotations\Response(response=200, description="Token supprimé")
     * )
     */
    #[OA\Post(
        path: '/api/logout',
        summary: 'Se déconnecter',
        security: [['sanctum' => []]],
        tags: ['Authentication'],
        responses: [new OA\Response(response: 200, description: 'Token supprimé')],
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté']);
    }

}
