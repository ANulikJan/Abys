<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\LinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MagicLinkController extends Controller
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Abys OpenApi Documentation",
     *      description="Abys Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     */

    private $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login-link",
     *     tags={"Auth"},
     *     summary="Get one time Login link",
     *     description="Send an email to user with the login link that will expire in 1 hour",
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

    public function sendLink(Request $request)
    {
        $code = $this->linkService->generateLoginLink($request);
        return response()->json(['message' => 'Magic link sent.', 'token' => $code]);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/login/{token}",
     *      tags={"Auth"},
     *      summary="Login user user by link and provide Access token",
     *      description="Send an email to user with the login link that will expire in 1 hour",
     *      @OA\Parameter(
     *          in="path",
     *          name="token",
     *          description="One time token in link",
     *          @OA\Schema(
     *              type="string",
     *              default="",
     *          )
     *      ),
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
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       )
     *     )
     *
     */
    public function verifyToken($token)
    {
        $record = $this->linkService->fetchToken($token);

        if (!$record || Carbon::parse($record->expires_at)->isPast()) {
            return response()->json(['error' => 'Invalid or expired token'], 400);
        }

        $user = $this->linkService->checkUser($record->email);

        if (empty($user)) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $this->linkService->deleteToken($token);
        $accessToken = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $accessToken,
            'user' => $user
        ]);
    }


}
