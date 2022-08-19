<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class PurchaseDocumentRepository
{
    protected const BASE_URL = "DocumentosCompra";

    //PurhcaseDocuments
    public static function getPurchaseDocumentsByProject(array $projects)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/compras?projetos=".implode(',', $projects));
    }
}
