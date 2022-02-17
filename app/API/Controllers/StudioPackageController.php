<?php

namespace App\API\Controllers;

use App\API\Transformers\ListMediaTransformer;
use App\API\Transformers\ListPackageBenefitTransformer;
use App\API\Transformers\ListPackageTransformer;
use App\API\Transformers\ListReviewsTransformer;
use App\API\Transformers\ListStudioMetadataTransformer;
use App\API\Transformers\ListStudioPackageMediaTransformer;
use App\API\Transformers\SubPackagesTransformer;
use App\Constants\Attributes;
use App\Constants\StudioPackageTypes;
use App\Helpers;
use App\Models\Benefit;
use App\Models\Media;
use App\Models\Package;
use App\Models\Review;
use App\Models\StudioPackage;
use App\Models\SubPackage;
use Illuminate\Http\JsonResponse;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

/**
 * Studio Package Controller
 */
class StudioPackageController extends CustomController
{

    /**
     * List All Studio Packages
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/packages",
     *     tags={"Studio Packages"},
     *     description="List Studio Packages",
     *     @OA\Response(response="200", description="Studio Packages retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Response(response="500", description="Internal Server Error", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
     *     @OA\Parameter(name="last_update", in="query", description="Last Update: 2020-10-04", required=false, @OA\Schema(type="string")),
     * )
     */
    public function listAll(): JsonResponse
    {

        // get parameters
        $id = GlobalHelpers::getValueFromHTTPRequest($this->request, Attributes::ID, null, CastingTypes::INTEGER);

        // get studio packages
        if(!empty($id)){
            $studio_package = StudioPackage::active()->where(Attributes::ID, $id)->get();
        }else{
            $studio_package = StudioPackage::active()->get();
        }

        // get last updated items
        if(!empty($this->last_update)){
            $studio_package = Helpers::getLatestOnlyInCollection($studio_package, $this->last_update);
        }

        // get related metadata
        $benefits = $studio_package->map->benefits;
        $benefits = $benefits->flatten()->filter();

        // get related image examples
        $media = $studio_package->map->media;
        $media = $media->flatten()->filter();

        // return response
        return Helpers::returnResponse([
            Attributes::STUDIO_PACKAGES => StudioPackage::returnTransformedItems($studio_package, ListStudioMetadataTransformer::class),
            Attributes::BENEFITS => Benefit::returnTransformedItems($benefits, ListPackageBenefitTransformer::class),
            Attributes::MEDIA => Media::returnTransformedItems($media, ListStudioPackageMediaTransformer::class),
            Attributes::TYPES => StudioPackageTypes::toCustomArray(),
        ]);
    }

    /**
     * Get Package Info
     *
     * @return JsonResponse
     *
     * * @OA\GET(
     *     path="/api/studio/{id}",
     *     tags={"Studio Packages"},
     *     description="Get Studio Package Info",
     *     @OA\Response(response="200", description="Studio Packages retrived successfully", @OA\JsonContent(ref="#/components/schemas/CustomJsonResponse")),
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
