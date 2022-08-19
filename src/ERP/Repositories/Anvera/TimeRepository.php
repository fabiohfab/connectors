<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class TimeRepository
{
    protected const BASE_URL = "tempos";

    //Times
    public static function getTimes()
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL);
    }
    public static function getTime(String $id)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/{$id}");
    }
    public static function getTimesByProject(String $project)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/projecto/{$project}");
    }
    public static function getTimesByEmployee(String $employee)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/funcionario/{$employee}");
    }
    public static function editTimes(array $time)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL, ["body" => json_encode($time)]);
    }
    public static function createTimes(array $time)
    {
        return AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => [json_encode($time)]]);
    }
    public static function deleteTime(String $id)
    {
        return AnveraRequestConnector::deleteRequest(self::BASE_URL."?id={$id}");
    }
}
