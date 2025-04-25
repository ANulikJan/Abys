<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Register new User",
     *     description="Register new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 required={"email"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="test@domain.com"
     *                 )
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         description="Accept",
     *         required=true,
     *         @OA\Schema(type="string", default="application/json")
     *      ),
     *      @OA\Parameter(
     *         name="Content-Type",
     *         in="header",
     *         description="Request body format",
     *         required=true,
     *        @OA\Schema(type="string", default="application/json")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function registerByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = strtolower(trim($request->email));
        $user = $this->userService->createUser($email);

        return response()->json($user);
    }

}
