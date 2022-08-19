<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\ERP\Interfaces\IWrite;
use Sinmetro\Connectors\ERP\Models\Order;
use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class OrderRepository implements IRead, IWrite
{
    protected const BASE_URL = "encomendas";

    public static function all(String $docType = null): array
    {
        $params = '';
        if ($docType != null) {
            $params .= "?tipoDocumento={$docType}";
        }

        $orders = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL."{$params}");

        foreach ($response as $order) {
            array_push($orders, self::parseOrder($order));
        }

        return $orders;
    }

    public static function get(String $id): Order
    {
        $response = AnveraRequestConnector::getRequest(self::BASE_URL."/{$id}");

        return self::parseOrder($response);
    }

    public static function filter(array $filters, String $docType = null): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "/{$key}/{$value}";
        }

        $params = '';
        if ($docType != null) {
            $params .= "?tipoDocumento={$docType}";
        }

        $orders = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL.$query.$params);

        foreach ($response as $order) {
            array_push($orders, self::parseOrder($order));
        }

        return $orders;
    }

    public static function store(Order $order): Order
    {
        $response = AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode(self::transformOrderModel($order))]);

        return self::parseOrder($response);
    }

    public static function update(array $orders): array
    {
        $updatedOrders = array();

        foreach ($orders as $order) {
            $response = AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", [
                "body" => json_encode(self::transformOrderModel($order))
            ], true);
            array_push($updatedOrders, self::parseOrder($response));
        }

        return $updatedOrders;
    }

    //Orders
    public static function cancel(String $id, String $code = null): array
    {
        $orders = array();

        $params = '';
        if ($code != null) {
            $params .= "?codigoAnulacao={$code}";
        }
        $response =  AnveraRequestConnector::updateRequest(self::BASE_URL."/{$id}{$params}", []);

        foreach ($response as $order) {
            array_push($orders, self::parseOrder($order));
        }

        return $orders;
    }

    protected static function transformBudgetModel(Order $order)
    {
        return [
            "fornecedor" => $order->supplier(),
            "dataDocumento" => $order->documentDate(),
            "desconto" => $order->discount(),
            "referencia" => $order->reference(),
            "idExt" => $order->externalId(),
            "linhas" => array_map(function ($row) {
                return [
                    "artigo" => $row->id(),
                    "descricao" => $row->description(),
                    "desconto" =>  $row->discount(),
                    "precoUnit" => $row->unitPrice(),
                    "totalLiquido" => $row->totalNet(),
                    "total" => $row->total(),
                    "projeto" => $row->project(),
                    "agrupamentoDimensao" => $row->groupingDimension(),
                    "agrupamentoTipo" => $row->groupingType(),
                    "idExt" => $row->externalId(),
                    "dataEntrega" => $row->deliveryDate(),
                ];
            }, $order->rows()),
        ];
    }

    protected static function parseBudget(array $budget)
    {
        return new Budget([
            "supplier" => array_key_exists("fornecedor", $budget) ? $budget["fornecedor"] : null,
            "documentDate" => array_key_exists("dataDocumento", $budget) ? $budget["dataDocumento"] : null,
            "discount" => array_key_exists("desconto", $budget) ? $budget["desconto"] : null,
            "reference" => array_key_exists("referencia", $budget) ? $budget["referencia"] : null,
            "externalId" => array_key_exists("idExt", $budget) ? $budget["idExt"] : null,
            "rows" => array_key_exists("linhas", $budget) ? array_map(function ($row) {
                return [
                    "article" => array_key_exists("artigo", $row) ? $row["artigo"] : null,
                    "description" => array_key_exists("descricao", $row) ? $row["descricao"] : null,
                    "quantity" => array_key_exists("quatidade", $row) ? $row["quatidade"] : null,
                    "discount" => array_key_exists("desconto", $row) ? $row["desconto"] : null,
                    "unitPirce" => array_key_exists("precoUnit", $row) ? $row["precoUnit"] : null,
                    "totalNet" => array_key_exists("totalLiquido", $row) ? $row["totalLiquido"] : null,
                    "total" => array_key_exists("total", $row) ? $row["total"] : null,
                    "project" => array_key_exists("projeto", $row) ? $row["projeto"] : null,
                    "groupingDimension" => array_key_exists("agrupamentoDimensao", $row) ? $row["agrupamentoDimensao"] : null,
                    "groupingType" => array_key_exists("agrupamentoTipo", $row) ? $row["agrupamentoTipo"] : null,
                    "externalId" => array_key_exists("idExt", $row) ? $row["idExt"] : null,
                    "deliveryDate" => array_key_exists("dataEntrega", $row) ? $row["dataEntrega"] : null,
                ];
            }, $budget["linhas"]) : null,
        ]);
    }
}
