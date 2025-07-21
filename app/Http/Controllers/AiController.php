<?php

namespace Modules\Ai\Http\Controllers;

use Modules\Ai\Facades\Ai;
use Modules\Ai\Http\Requests\AiDescriptionRequest;
use Modules\Core\Exceptions\DurrbarException;
use Modules\Core\Http\Controllers\CoreController;

class AiController extends CoreController
{
    public function generateDescription(AiDescriptionRequest $request): mixed
    {
        try {
            return Ai::generateDescription($request);
        } catch (DurrbarException $e) {
            throw new DurrbarException(SOMETHING_WENT_WRONG, $e->getMessage());
        }
    }
}
