<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DadataService
{
    const SUGGEST_URI = 'suggest/address';
    const GEO_LOCATE_URI = 'geolocate/address';

//    Ограничения поиска по городу
    const LOCATIONS_CONFIG = [
        [
            'city' => "Воронеж",
        ]
    ];

    public static function getSuggestions(string $query, int $count): array
    {
        $url = $_ENV['DADATA_URL'] . self::SUGGEST_URI;

        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . $_ENV['DADATA_TOKEN']
        ])->post($url, [
            'query' => $query,
            'count' => $count,
            'locations' => self::LOCATIONS_CONFIG,
        ])['suggestions'];
    }

    public static function geoLocate(float $lat, float $lon): array
    {
        if (!$lat || !$lon) {
            return [];
        }

        $url = $_ENV['DADATA_URL'] . self::GEO_LOCATE_URI;

        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . $_ENV['DADATA_TOKEN']
        ])->get($url, [
            'lat' => $lat,
            'lon' => $lon,
        ])['suggestions'];
    }
}
