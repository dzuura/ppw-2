<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     description="Contoh API doc menggunakan OpenAPI/Swagger",
 *     version="0.0.1",
 *     title="Contoh API documentation",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="daffa.zulfahmi@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="Gallery",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Beautiful Sunset"),
 *     @OA\Property(property="picture", type="string", example="https://example.com/images/sunset.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-24T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-24T12:00:00Z")
 * )
 */
class GreetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/greet",
     *     tags={"Greeting"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="greet",
     *     @OA\Parameter(
     *          name="firstname",
     *          description="nama depan",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lastname",
     *          description="nama belakang",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */

    public function greet(Request $request)
    {
        $userData = $request->only([
            'firstname',
            'lastname',
        ]);
        if (
            empty($userData['firstname']) &&
            empty($userData['lastname'])
        ) {
            return new \Exception('Missing Data', 404);
        }
        return 'Halo ' . $userData['firstname'] . ' ' . $userData['lastname'];
    }
}
