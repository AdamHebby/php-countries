<?php

namespace RapidWeb\Countries;

use Exception;
use RapidWeb\Countries\DataSources\MledozeCountriesJson;
use RapidWeb\Countries\Interfaces\DataSourceInterface;

class Countries
{
    public DataSourceInterface $dataSource;

    public function __construct()
    {
        $this->setDataSource(new MledozeCountriesJson());
    }

    public function setDataSource(DataSourceInterface $dataSource): void
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @return Country[]
     */
    public function all(): array
    {
        $countries = $this->dataSource->all();

        usort($countries, function ($a, $b) {
            return strcmp($a->name, $b->name);
        });

        return $countries;
    }

    public function getByName(string $name): ?Country
    {
        foreach ($this->all() as $country) {
            if ($country->name == $name || $country->officialName == $name) {
                return $country;
            }
        }

        return null;
    }

    public function getByIsoCode(string $code): ?Country
    {
        foreach ($this->all() as $country) {
            if ($country->isoCodeAlpha2 == $code || $country->isoCodeAlpha3 == $code || $country->isoCodeNumeric == $code) {
                return $country;
            }
        }

        return null;
    }

    /**
     * @return Country[]
     */
    public function getByLanguage(string $language): array
    {
        $countries = [];

        foreach ($this->all() as $country) {
            foreach ($country->languages as $countryLanguage) {
                if ($countryLanguage == $language) {
                    $countries[] = $country;
                }
            }
            foreach ($country->languageCodes as $countryLanguageCode) {
                if ($countryLanguageCode == $language) {
                    $countries[] = $country;
                }
            }
        }

        return $countries;
    }
}
