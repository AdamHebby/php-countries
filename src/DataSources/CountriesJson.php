<?php

declare(strict_types=1);

namespace RapidWeb\Countries\DataSources;

use Exception;
use RapidWeb\Countries\Country;
use RapidWeb\Countries\Interfaces\DataSourceInterface;

class CountriesJson implements DataSourceInterface
{
    private null|array $countryData = null;

    public function __construct()
    {
        $path = __DIR__ . '/../../data/countries.json';

        if (file_exists($path)) {
            $this->countryData = json_decode(file_get_contents($path), true);
            return;
        }

        if (!$this->countryData) {
            throw new Exception('Unable to retrieve MledozeCountries JSON data file. Have you ran composer update?');
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return array_map(static fn(array $country) => Country::fromArray($country), $this->countryData);
    }
}
