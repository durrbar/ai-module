<?php

declare(strict_types=1);

namespace Modules\Ai\Facades;

use Illuminate\Support\Facades\Facade;

class Ai extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ai';
    }
}
