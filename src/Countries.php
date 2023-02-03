<?php

declare(strict_types=1);

namespace RapidWeb\Countries;

use RapidWeb\Countries\DataSources\CountriesJson;
use RapidWeb\Countries\Interfaces\DataSourceInterface;

class Countries
{
    public DataSourceInterface $dataSource;

    public function __construct()
    {
        $this->setDataSource(new CountriesJson());
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

    /**
     * Filter an array of countries by a set of keys and values.
     *
     * @var string[] $keys
     * @var string[] $values
     *
     * @return Country[]
     */
    public function filter(array $keys, array $values): array
    {
        $countries = [];

        foreach ($this->all() as $country) {
            foreach ($keys as $key) {
                if (
                    in_array($country->{$key}, $values)
                    || (is_array($country->{$key}) && count(array_intersect($country->{$key}, $values)) > 0)
                ) {
                    $countries[] = $country;
                    break;
                }
            }
        }

        return $countries;
    }

    public function getByName(string $name): ?Country
    {
        return $this->oneOrNull($this->filter(['name', 'officialName'], [$name]));
    }

    public function getByIsoCode(string $code): ?Country
    {
        return $this->oneOrNull($this->filter(['isoCodeAlpha2', 'isoCodeAlpha3', 'isoCodeNumeric'], [$code]));
    }

    /**
     * @return Country[]
     */
    public function getByLanguage(string $language): array
    {
        return $this->filter(['languages', 'languageCodes'], [$language]);
    }

    /**
     * @return Country[]
     */
    public function getByRegion(string $region): array
    {
        return $this->filter(['region'], [$region]);
    }

    private function oneOrNull(array $countries): ?Country
    {
        if (count($countries) == 1) {
            return $countries[0];
        }

        return null;
    }
}
