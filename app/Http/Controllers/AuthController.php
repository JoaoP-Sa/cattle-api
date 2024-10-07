<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Create a new user account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="User name"),
     *             @OA\Property(property="email", type="string", description="User email"),
     *             @OA\Property(property="password", type="string", format="float", description="User password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O novo registro foi criado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Foram encontrados um ou mais erros nas informações enviadas."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="code",
     *                     type="array",
     *                     @OA\Items(type="string", example="O campo email deve ser único, e já existe um usuário com este email")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function register(AuthRequest $request, User $user) {
        try {
            $request['password'] = Hash::make($request['password']);
            $user->fill($request->all());
            $user->save();

            return response()->json(['message' => 'O novo registro foi criado com sucesso.']);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage());
        }
    }

        /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate account",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", description="User email"),
     *             @OA\Property(property="password", type="string", format="float", description="User password"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTcyODI5NDM2MSwiZXhwIjoxNzI4Mjk3OTYxLCJuYmYiOjE3MjgyOTQzNjEsImp0aSI6IkNLaUgzOGVwaFZwb1VoYTQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.UyRY2hgZ3ebI8_7IypyzZ-dmiE3nwWvx6LrOc98hbNs"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     path="/api/me",
     *     summary="Get authenticated user info",
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="joao"),
     *             @OA\Property(property="email", type="string", example="teste@email.com"),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-10-06T17:19:42.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-10-06T17:19:42.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Make logout",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Deslogado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Deslogado com sucesso.']);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     summary="Make refresh",
     *     @OA\Response(
     *         response=200,
     *         description="Successful refresh",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTcyODI5NDM2MSwiZXhwIjoxNzI4Mjk3OTYxLCJuYmYiOjE3MjgyOTQzNjEsImp0aSI6IkNLaUgzOGVwaFZwb1VoYTQiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.UyRY2hgZ3ebI8_7IypyzZ-dmiE3nwWvx6LrOc98hbNs"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token has expired",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Token has expired"),
     *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\UnauthorizedHttpException"),
     *             @OA\Property(property="file", type="string", example="/path/to/file.php"),
     *             @OA\Property(property="line", type="integer", example=74),
     *             @OA\Property(property="trace", type="array", @OA\Items(type="object", example={"file": "/path/to/file.php", "line": 30, "function": "authenticate"}))
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
