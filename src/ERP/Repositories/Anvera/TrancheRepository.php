<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class TrancheRepository
{
    protected const BASE_URL = "tranches";

    //Tranches
    public static function getTranchesByProject(String $project)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/projetos/{$project}");
    }
    public static function getTranchesByClient(String $client)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/clientes/{$client}");
    }
    public static function getTrancheState(String $id)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/{$id}/estado");
    }
    public static function createTranche(array $tranche)
    {
        return AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode($tranche)]);
    }
    public static function unlockTranches(array $tranchesToUnlock)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/desbloquear", ["body" => json_encode($tranchesToUnlock)]);
    }
    public static function lockTranches(array $tranchesTolock)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/bloquear", ["body" => json_encode($tranchesTolock)]);
    }
    public static function linkTranche(String $primaveraId, String $externalId)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/sincronizar?idPrimavera={$primaveraId}&idExterno={$externalId}", []);
    }
    public static function unlinkTranche(string $externalId)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/dessincronizar?idExterno={$externalId}", []);
    }
    public static function editTranche(array $tranche)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", ["body" => json_encode($tranche)]);
    }
    public static function deleteTranche(String $id)
    {
        return AnveraRequestConnector::deleteRequest(self::BASE_URL."/apagar?id={$id}");
    }
}
