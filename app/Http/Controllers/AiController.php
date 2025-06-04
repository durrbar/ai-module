<?php

namespace Modules\Ai\Http\Controllers;

use Modules\Ai\Facades\Ai;
use Modules\Ai\Http\Requests\AiDescriptionRequest;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Ecommerce\Exceptions\MarvelException;

class AiController extends CoreController
{

    public function generateDescription(AiDescriptionRequest $request): mixed
    {
        try {
            return Ai::generateDescription($request);
        } catch (MarvelException $e) {
            throw new MarvelException(SOMETHING_WENT_WRONG, $e->getMessage());
        }
    }
}
