<?php

namespace App\Service;

class EventService
{
    const URL = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda';

    public function search(string $city, \DateTime $date): bool|string
    {
        $url = self::URL . '&refine.location_city=' . $city . '&refine.firstdate_begin=' . $date->format('Y-m-d');
        return file_get_contents($url);
    }
}