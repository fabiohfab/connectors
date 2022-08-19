<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\ERP\Models\Purchasing;

class PurchasingRepository implements IRead
{
    public static function all(): array
    {
        return array();
    }

    public static function get(String $id): Purchasing
    {
        return new Purchasing();
    }

    public static function filter(array $filters): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "/{$value}/";
        }

        $purchasings = array();
        $response = AnveraRequestConnector::getRequest("projectos{$query}compras");

        foreach ($response as $purchasing) {
            array_push($purchasings, self::parsePurchasing($purchasing));
        }

        return $purchasings;
    }

    protected static function transformPurchasingModel(Purchasing $purchasing)
    {
    }

    protected static function parsePurchasing(array $purchasing)
    {
        return new Sales([
            "project" => array_key_exists("projeto", $purchasing) ? $purchasing["projeto"] : null,
            "documentId" => array_key_exists("documentoId", $purchasing) ? $purchasing["documentoId"] : null,
            "document" => array_key_exists("documento", $purchasing) ? $purchasing["documento"] : null,
            "documentFiscalSpace" => array_key_exists("documentoTipoFiscal", $purchasing) ? $purchasing["documentoTipoFiscal"] : null,
            "supplier" => array_key_exists("fornecedor", $purchasing) ? $purchasing["fornecedor"] : null,
            "supplierName" => array_key_exists("fornecedorNome", $purchasing) ? $purchasing["fornecedorNome"] : null,
            "documentDate" => array_key_exists("documentoData", $purchasing) ? $purchasing["documentoData"] : null,
            "documentDueDate" => array_key_exists("documentoDataVencimento", $purchasing) ? $purchasing["documentoDataVencimento"] : null,
            "rowId" => array_key_exists("linhaId", $purchasing) ? $purchasing["linhaId"] : null,
            "rowNumber" => array_key_exists("linhaNum", $purchasing) ? $purchasing["linhaNum"] : null,
            "rowDescription" => array_key_exists("linhaDescricao", $purchasing) ? $purchasing["linhaDescricao"] : null,
            "rowArticle" => array_key_exists("linhaArtigo", $purchasing) ? $purchasing["linhaArtigo"] : null,
            "rowArticleDescription" => array_key_exists("linhaArtigoDescricao", $purchasing) ? $purchasing["linhaArtigoDescricao"] : null,
            "rowQuantity" => array_key_exists("linhaQuantidade", $purchasing) ? $purchasing["linhaQuantidade"] : null,
            "rowUnitPrice" => array_key_exists("linhaPrecoUnit", $purchasing) ? $purchasing["linhaPrecoUnit"] : null,
            "rowNetPrice" => array_key_exists("linhaPrecoLiq", $purchasing) ? $purchasing["linhaPrecoLiq"] : null,
        ]);
    }
}
