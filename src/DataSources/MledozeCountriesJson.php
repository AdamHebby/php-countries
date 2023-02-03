<?php

namespace RapidWeb\Countries\DataSources;

use Exception;
use RapidWeb\Countries\Country;
use RapidWeb\Countries\Interfaces\DataSourceInterface;

class MledozeCountriesJson implements DataSourceInterface
{
    private null|array $countryData = null;

    public function __construct()
    {
        $paths = [
            __DIR__ . '/../../../../mledoze/countries/dist/countries.json',
            __DIR__ . '/../../vendor/mledoze/countries/dist/countries.json',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                $this->countryData = json_decode(file_get_contents($path), true);
                break;
            }
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
