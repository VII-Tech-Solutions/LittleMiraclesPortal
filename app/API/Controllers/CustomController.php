<?php

namespace App\API\Controllers;

use App\Constants\Attributes;
use App\Constants\Values;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use VIITech\Helpers\Constants\CastingTypes;
use VIITech\Helpers\GlobalHelpers;

/**
 * Class CustomController
 * @package App\API\Controllers
 *
 * @OA\Info(title="Little Miracles API", version="1.0")
 * @OA\Server(url="http://littlemiracles.test/api",description="Development API")
 */
class CustomController extends BaseController
{
    use Helpers, ValidatesRequests;

    /** @var Request $request */
    public $request;
    public $page;
    public $limit;

    /**
     * Create a new controller instance.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->limit = GlobalHelpers::getValueFromHTTPRequest($request, Attributes::LIMIT, Values::ITEMS_PER_PAGE, CastingTypes::INTEGER);
        $this->page = GlobalHelpers::getValueFromHTTPRequest($request, Attributes::PAGE, Values::DEFAULT_PAGE, CastingTypes::INTEGER);
    }
}
