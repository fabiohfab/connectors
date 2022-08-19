<?php

namespace Sinmetro\Connectors\ERP\Repositories\Anvera;

use Sinmetro\Connectors\ERP\Models\Client;
use Sinmetro\Connectors\ERP\Interfaces\IRead;
use Sinmetro\Connectors\ERP\Interfaces\IWrite;
use Sinmetro\Connectors\Requests\AnveraRequestConnector;

class ClientRepository implements IRead, IWrite
{
    protected const BASE_URL = "clientes";

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
        $response = AnveraRequestConnector::getRequest(self::BASE_URL);

        foreach ($response as $client) {
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
        $response = AnveraRequestConnector::getRequest(self::BASE_URL."/{$id}");

        return self::parseClient($response);
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
            $query .= "/{$key}/{$value}";
        }

        $clients = array();
        $response = AnveraRequestConnector::getRequest(self::BASE_URL.$query);

        foreach ($response as $client) {
            array_push($clients, self::parseClient($client));
        }

        return $clients;
    }

    /**
     * Store new Client
     *
     * @param Client $client
     *
     * @author Fábio Henriques <fabio.henriques@sinmetro.pt>
     * @return Client
     */
    public static function store(Client $client): Client
    {
        $response = AnveraRequestConnector::postRequest(self::BASE_URL, ["body" => json_encode(self::transformClientModel($client))]);

        return self::parseClient($response);
    }

    /**
     * Update Clients
     *
     * @param Client[] $clients    Array with objects to update
     *
     * @author Fábio Henriques <fabio.henriques@sinmetro.pt>
     * @return Client[]
     */
    public static function update(array $clients): array
    {
        $updatedClients = array();

        foreach ($clients as $client) {
            $response = AnveraRequestConnector::updateRequest(self::BASE_URL."/editar", [
                "body" => json_encode(self::transformClientModel($client))
            ], true);
            array_push($updatedClients, self::parseClient($response));
        }

        return $updatedClients;
    }

    protected static function transformClientModel(Client $client)
    {
        return [
            "codERP" =>   $client->id(),
            "nome"    => $client->name(),
            "nif" => $client->vatID(),
            "morada"    => $client->address(),
            "codPostal"    => $client->zipCode(),
            "codPostalLocalidade"   => $client->city(),
            "localidade"    => $client->city(),
            "telefone"   => $client->phoneNumber(),
            "telefone2"   => $client->phoneNumber2(),
            "fax"=> $client->fax(),
            "notas"  =>  $client->notes(),
            "moeda"  =>  [
                "id" => $client->coin()->id(),
                "description" => $client->coin()->description(),
            ],
            "pais"  =>  [
                "id" => $client->country()->id(),
                "description" => $client->country()->description(),
            ],
            "modoPagamento" => $client->paymentMethod(),
            "modoRecebimento" => $client->shippingMethod(),
            "condicaoPagamento" => $client->paymentCondition(),
            "codCRM" => $client->crm(),
            "espacoFiscal" => $client->fiscalSpace(),
        ];
    }

    protected static function parseClient(array $client)
    {
        return new Client([
            "id" => array_key_exists("codERP", $client) ? $client["codERP"] : null,
            "name" => array_key_exists("nome", $client) ? $client["nome"] : null,
            "vatID" => array_key_exists("nif", $client) ? $client["nif"] : null,
            "address" => array_key_exists("morada", $client) ? $client["morada"] : null,
            "zipCode" => array_key_exists("codPostal", $client) ? $client["codPostal"] : null,
            "city" => array_key_exists("localidade", $client) ? $client["localidade"] : null,
            "phoneNumber" => array_key_exists("telefone", $client) ? $client["telefone"] : null,
            "phoneNumber2" => array_key_exists("telefone2", $client) ? $client["telefone2"] : null,
            "fax" => array_key_exists("fax", $client) ? $client["fax"] : null,
            "notes" => array_key_exists("notas", $client) ? $client["notas"] : null,
            "coin" => [
                "id" => array_key_exists("moeda", $client) && array_key_exists("id", $client["moeda"]) ? $client["moeda"]["id"] : null,
                "description" => array_key_exists("moeda", $client) && array_key_exists("description", $client["moeda"]) ? $client["moeda"]["description"] : null,
            ],
            "country" => [
                "id" => array_key_exists("pais", $client) && array_key_exists("id", $client["pais"]) ? $client["pais"]["id"] : null,
                "description" => array_key_exists("pais", $client) && array_key_exists("description", $client["pais"]) ? $client["pais"]["description"] : null,
            ],
            "paymentMethod" => array_key_exists("modoPagamento", $client) ? $client["modoPagamento"] : null,
            "shippingMethod" =>array_key_exists("modoRecebimento", $client) ? $client["modoRecebimento"] : null,
            "paymentCondition" => array_key_exists("condicaoPagamento", $client) ? $client["condicaoPagamento"] : null,
            "crm" => array_key_exists("pais", $client) ? $client["codCRM"] : null,
            "fiscalSpace" => array_key_exists("espacoFiscal", $client) ? $client["espacoFiscal"] : null,
        ]);
    }
}
