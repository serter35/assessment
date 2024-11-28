<?php

namespace App\Http\Controllers;

use App\Contract\Messaging\RecipientServiceContract;
use App\Http\Resources\RecipientResource;
use App\Models\Recipient;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipientController extends Controller
{
    public function __construct(private readonly RecipientServiceContract $service)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/recipients",
     *     summary="Get all sent message recipients",
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="The page number for paginated results",
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of all sent message recipients",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="current_page",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(
     *                         property="content",
     *                         type="string",
     *                         example="Et aliquid inventore illum sit ratione..."
     *                     ),
     *                     @OA\Property(
     *                         property="phone_number",
     *                         type="string",
     *                         example="5063584555"
     *                     ),
     *                     @OA\Property(property="sent", type="boolean", example=true),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-28T15:49:52.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-28T15:55:48.000000Z")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="first_page_url",
     *                 type="string",
     *                 example="http://localhost:8080/api/recipients?page=1"
     *             ),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=1),
     *             @OA\Property(
     *                 property="last_page_url",
     *                 type="string",
     *                 example="http://localhost:8080/api/recipients?page=1"
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="url", type="string", nullable=true),
     *                     @OA\Property(property="label", type="string", example="&laquo; Previous"),
     *                     @OA\Property(property="active", type="boolean", example=false)
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="next_page_url",
     *                 type="string",
     *                 nullable=true,
     *                 example=null
     *             ),
     *             @OA\Property(
     *                 property="path",
     *                 type="string",
     *                 example="http://localhost:8080/api/recipients"
     *             ),
     *             @OA\Property(property="per_page", type="integer", example=25),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true, example=null),
     *             @OA\Property(property="to", type="integer", example=4),
     *             @OA\Property(property="total", type="integer", example=4)
     *         )
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        return RecipientResource::collection($this->service->getAsPaginatedBySent());
    }

    /**
     * @OA\Get(
     *     path="/api/recipients/{id}",
     *     summary="Get a recipient by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         ),
     *         description="The ID of the recipient"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recipient found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 example="Et aliquid inventore illum sit ratione..."
     *             ),
     *             @OA\Property(
     *                 property="phone_number",
     *                 type="string",
     *                 example="5063584555"
     *             ),
     *             @OA\Property(property="sent", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-11-28T15:49:52.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-11-28T15:55:48.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recipient not found"
     *     )
     * )
     */
    public function show($id): RecipientResource
    {
        return new RecipientResource($this->service->findRecipientAsSent($id));
    }
}
