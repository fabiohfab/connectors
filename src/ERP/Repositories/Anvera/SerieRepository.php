<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class SerieRepository
{
    protected const BASE_URL = "series";

    //Series
    public static function getSeries()
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL);
    }
    public static function getSerieNumerator(String $type, String $serie)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/{$serie}/{$type}");
    }
    public static function createSerie(array $serie)
    {
        return AnveraRequestConnector::postRequest(self::BASE_URL."/criar", ["body" => json_encode($serie)]);
    }
    public static function editSerie(array $serie)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", ["body" => json_encode($serie)]);
    }
    public static function incrementSerie(String $type, String $serie)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/incrementarNumerador?tipo={$type}&serie={$serie}", []);
    }
}
