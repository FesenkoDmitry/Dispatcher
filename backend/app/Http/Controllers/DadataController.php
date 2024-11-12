<?php


namespace App\Http\Controllers;


use App\Services\DadataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DadataController extends Controller
{

    public function suggestions(Request $request)
    {
        return DadataService::getSuggestions($request->input('query'), $request->input('count', 10));
    }

    public function suggestionsByCoords(Request $request)
    {
        return DadataService::geoLocate($request->input('lat'), $request->input('lon'));
    }
}
