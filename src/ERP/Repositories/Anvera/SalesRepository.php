<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Models\Sales;
use Sinmetro\Connectors\ERP\Interfaces\IRead;

class SalesRepository implements IRead
{
    public static function all(): array
    {
        return array();
    }

    public static function get(String $id): Sales
    {
        return new Sales();
    }

    public static function filter(array $filters): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "/{$value}/";
        }

        $sales = array();
        $response = AnveraRequestConnector::getRequest("projectos{$query}venda");

        foreach ($response as $sale) {
            array_push($sales, self::parseSales($sale));
        }

        return $sales;
    }

    protected static function transformSalesModel(Sales $sales)
    {
    }

    protected static function parseSales(array $sales)
    {
        return new Purchasing([
            "project" => array_key_exists("projeto", $sales) ? $sales["projeto"] : null,
            "documentId" => array_key_exists("documentoId", $sales) ? $sales["documentoId"] : null,
            "document" => array_key_exists("documento", $sales) ? $sales["documento"] : null,
            "documentFiscalSpace" => array_key_exists("documentoTipoFiscal", $sales) ? $sales["documentoTipoFiscal"] : null,
            "client" => array_key_exists("cliente", $sales) ? $sales["cliente"] : null,
            "clientName" => array_key_exists("clienteNome", $sales) ? $sales["clienteNome"] : null,
            "documentDate" => array_key_exists("documentoData", $sales) ? $sales["documentoData"] : null,
            "documentDueDate" => array_key_exists("documentoDataVencimento", $sales) ? $sales["documentoDataVencimento"] : null,
            "rowId" => array_key_exists("linhaId", $sales) ? $sales["linhaId"] : null,
            "rowNumber" => array_key_exists("linhaNum", $sales) ? $sales["linhaNum"] : null,
            "rowWeMoldId" => array_key_exists("linhaIdWeMold", $sales) ? $sales["linhaIdWeMold"] : null,
            "rowDescription" => array_key_exists("linhaDescricao", $sales) ? $sales["linhaDescricao"] : null,
            "rowArticle" => array_key_exists("linhaArtigo", $sales) ? $sales["linhaArtigo"] : null,
            "rowArticleDescription" => array_key_exists("linhaArtigoDescricao", $sales) ? $sales["linhaArtigoDescricao"] : null,
            "rowQuantity" => array_key_exists("linhaQuantidade", $sales) ? $sales["linhaQuantidade"] : null,
            "rowUnitPrice" => array_key_exists("linhaPrecoUnit", $sales) ? $sales["linhaPrecoUnit"] : null,
            "rowNetPrice" => array_key_exists("linhaPrecoLiq", $sales) ? $sales["linhaPrecoLiq"] : null,
        ]);
    }
}
