<?php

namespace App\API\Controllers;

use App\API\Transformers\ListPackageBenefitTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListReviewsTransformer;
use App\Constants\Attributes;
use App\Helpers;
use App\Models\Benefit;
use App\Models\Package;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
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

        // get parameters
        $id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ID, null, CastingTypes::INTEGER);

        // get packages
        if(!empty($id)){
            $packages = Package::active()->where(Attributes::ID, $id)->get();
        }else{
            $packages = Package::active()->get();
        }

        // get last updated items
        if(!empty($this->last_update)){
            $packages = Helpers::getLatestOnlyInCollection($packages, $this->last_update);
        }

        // get related metadata
        $benefits = $packages->map->benefits;
        $benefits = $benefits->flatten()->filter();

        // get related reviews
        $reviews = $packages->map->reviews;
        $reviews = $reviews->flatten()->filter();

        // TODO get related image examples

        // return response
        return Helpers::returnResponse([
            Attributes::PACKAGES => Package::returnTransformedItems($packages, ListPackageTransformer::class),
            Attributes::BENEFITS => Benefit::returnTransformedItems($benefits, ListPackageBenefitTransformer::class),
            Attributes::REVIEWS => Review::returnTransformedItems($reviews, ListReviewsTransformer::class),
        ]);
    }

    /**
     * Get Package Info
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/packages/{id}",
     *     tags={"Packages"},
     *     description="Get Package Info",
     *     @OA\Response(response="200", description="Packages retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="id", in="path", description="Package ID", required=true, @OA\Schema(type="integer")),
     * )
     */
    public function getInfo($id): JsonResponse
    {
        $this->request->merge([
            Attributes::ID => $id
        ]);
        return $this->listAll();
    }
}
