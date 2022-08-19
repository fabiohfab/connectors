<?php

namespace Sinmetro\Connectors\ERP\Repositories\Primavera;

use Sinmetro\Connectors\ERP\Models\Client;
use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\Requests\PrimaveraRequestConnector;

class ClientRepository implements IRead
{
    protected const BASE_URL = "erp/query/table";
    protected const COLUMNS = ["Cliente","Nome"];

    //Clients
    /**
     * Get Clients
     *
     * @author Fábio Henriques <fabio.henriques@sinmetro.pt>
     * @return Client[]
     */
    public static function all(): array
    {
        $clients = array();
        $response = PrimaveraRequestConnector::postRequest(self::BASE_URL, [
          "body" => json_encode([
            "Query" => [
              "Table" => "Clientes",
              "Columns" => implode(",", self::COLUMNS),
            ]
          ])
        ]);

        foreach ($response["Resultado"] as $client) {
            array_push($clients, self::parseClient($client));
        }

        return $clients;
    }

    /**
     * Get Client
     *
     * @param String $id    Id of Client
     *
     * @author Fábio Henriques <fabio.henriques@sinmetro.pt>
     * @return Client
     */
    public static function get(String $id): Client
    {
        $response = PrimaveraRequestConnector::postRequest(self::BASE_URL, [
          "body" => json_encode([
            "Query" => [
              "Table" => "Clientes",
              "Columns" => implode(",", self::COLUMNS),
              "Filter" => "cliente='{$id}'"
            ]
          ])
        ]);

        return self::parseClient($response["Resultado"][0]);
    }

    /**
     * Get filtered Clients
     *
     * @param array $filters    Array of filters. Supported filters: "EspacoFiscal"
     *
     * @author Fábio Henriques <fabio.henriques@sinmetro.pt>
     * @return Client[]
     */
    public static function filter(array $filters): array
    {
        $query = "";
        foreach ($filters as $key => $value) {
            $query .= "{$key}={$value},";
        }

        $query = substr($query, 0, -1);

        $clients = array();
        $response = PrimaveraRequestConnector::postRequest(self::BASE_URL.$query, [
          "body" => json_encode([
            "Query" => [
              "Table" => "Clientes",
              "Columns" => implode(",", self::COLUMNS),
              "Filter" => $query
            ]
          ])
        ]);

        foreach ($response["Resultado"] as $client) {
            array_push($clients, self::parseClient($client));
        }

        return $clients;
    }

    protected static function parseClient(array $client)
    {
        return new Client([
            "id" => array_key_exists("Cliente", $client) ? $client["Cliente"] : null,
            "name" => array_key_exists("Nome", $client) ? $client["Nome"] : null
        ]);
    }
}
