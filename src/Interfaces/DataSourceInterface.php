<?php

declare(strict_types=1);

namespace RapidWeb\Countries\Interfaces;

use RapidWeb\Countries\Country;

interface DataSourceInterface
{
    /**
     * @return Country[]
     */
    public function all(): array;
}
