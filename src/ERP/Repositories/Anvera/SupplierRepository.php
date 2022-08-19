<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class SupplierRepository
{
    protected const BASE_URL = "fornecedores";

    //Suppliers
    public static function getSuppliers()
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL);
    }
    public static function createSupplier(array $supplier)
    {
        return AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode($supplier)]);
    }
    public static function getSupplierByCode(String $code)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/{$code}");
    }
    public static function getSupplierByFiscalSpace(String $fiscalSpace)
    {
        return AnveraRequestConnector::getRequest(self::BASE_URL."/EspacoFiscal/{$fiscalSpace}");
    }
    public static function editSupplier(array $supplier)
    {
        return AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", ["body" => json_encode($supplier)]);
    }
}
