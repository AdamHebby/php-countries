<?php

namespace RapidWeb\Countries\Interfaces;

use RapidWeb\Countries\Country;

interface DataSourceInterface
{
    /**
     * @return Country[]
     */
    public function all(): array;
}
