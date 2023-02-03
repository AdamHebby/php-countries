<?php

namespace RapidWeb\Countries;

class Country
{
    public function __construct(
        public readonly string $name,
        public readonly string $officialName,
        public readonly array $topLevelDomains,
        public readonly string $isoCodeAlpha2,
        public readonly string $isoCodeAlpha3,
        public readonly string $isoCodeNumeric,
        public readonly array $languages,
        public readonly array $languageCodes,
        public readonly array $currencyCodes,
        public readonly array $callingCodes,
        public readonly string $capital,
        public readonly string $region,
        public readonly string $subregion,
        public readonly null|float $latitude,
        public readonly null|float $longitude,
        public readonly float $areaInKilometres,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name']['common'],
            $data['name']['official'],
            $data['tld'],
            $data['cca2'],
            $data['cca3'],
            $data['ccn3'],
            array_values((array) $data['languages']),
            array_keys((array) $data['languages']),
            array_keys((array) $data['currencies']),
            (array) $data['callingCodes'],
            reset($data['capital']),
            $data['region'],
            $data['subregion'],
            isset($data['latlng'][0]) ? $data['latlng'][0] : null,
            isset($data['latlng'][1]) ? $data['latlng'][1] : null,
            $data['area'],
        );
    }
}
