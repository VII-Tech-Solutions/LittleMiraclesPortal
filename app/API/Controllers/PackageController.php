<?php

namespace App\API\Controllers;

use App\API\Transformers\ListPackageTransformer;
use App\Constants\Attributes;
use App\Constants\Messages;
use App\Helpers;
use App\Models\Package;
use Dingo\Api\Http\Response;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\GlobalHelpers;

/**
 * Package Controller
 */
class PackageController extends CustomController
{

    /**
     * List All Packages
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/packages",
     *     tags={"Packages"},
     *     description="List Packages",
     *     @OA\Response(response="200", description="Packages retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function listAll(): JsonResponse
    {

        // get current user info
        $user = Helpers::resolveUser();
        if (is_null($user)) {
            return GlobalHelpers::formattedJSONResponse(Messages::PERMISSION_DENIED, null, null, Response::HTTP_UNAUTHORIZED);
        }

        // get packages
        $packages = Package::active()->get();

        // get last updated items
        if(!empty($this->last_update)){
            $packages = Helpers::getLatestOnlyInCollection($packages, $this->last_update);
        }

        // return response
        return Helpers::returnResponse([
            Attributes::PACKAGES => Package::returnTransformedItems($packages, ListPackageTransformer::class),
        ]);
    }

}
