<?php

namespace Sinmetro\Connectors\Requests;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PrimaveraRequestConnector
{
    /**
     * Get Request to Primavera.
     */
    public static function getRequest(string $path, bool $transformResponseGuzzleHttpToJson = true)
    {
        return self::request('get', $path, null, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Post Request to Primavera.
     *
     * @param mixed $data
     */
    public static function postRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('post', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Patch Request to Primavera.
     *
     * @param mixed $data
     */
    public static function updateRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('update', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Delete Request to Primavera.
     *
     * @param mixed $data
     */
    public static function deleteRequest(string $path, $data = [], bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('delete', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Request function.
     *
     * @param mixed|null $data
     */
    private static function request(string $type, string $path, $data = null, bool $transformResponseGuzzleHttpToJson = false)
    {
        $client = self::config();
        try {
            switch ($type) {
                case 'get':
                    $response = $client->get($path);
                    break;

                case 'post':
                    $response = $client->post($path, $data);
                    break;

                case 'update':
                    $response = $client->put($path, $data);
                    break;

                case 'delete':
                    $response = $client->delete($path, $data);
                    break;

                default:
                    abort(500, 'An error occurred calling Primavera. If the error persists, please contact IT Support. (This error message ID is dddf5437-2637-4e58-a3e7-67f83b6aca73.)');
                    break;
            }
        } catch (\Throwable $th) {
            Log::error('Primavera Request');
            Log::error($path);
            Log::error(json_encode($data));
            if (method_exists($th, 'getResponse') && method_exists($th->getResponse(), 'getBody')) {
                Log::error($th->getResponse()->getStatusCode().$th->getResponse()->getBody(true));
            }


            abort(500, 'An error occurred calling Primavera. If the error persists, please contact IT Support. (This error message ID is 2c8e290c-3121-428b-a8fc-2ab8d5ffc4fa.)');
        }

        if ($transformResponseGuzzleHttpToJson) {
            return connectorsResponseGuzzleHttpToJson($response);
        }

        return $response;
    }

    /**
     * Config The Request to Primavera.
     *
     * @return GuzzleHttp\Client $client
     */
    private static function config()
    {
        $ip = config('services.ws_primavera.url');
        $token = self::getToken();

        $headers = [
            'Authorization' => 'Basic '.$token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];

        return new Client([
            'base_uri' => $ip,
            'headers' => $headers,
            'curl' => [CURLOPT_SSL_VERIFYPEER => false],
            'verify' => false,
        ]);
    }

    /**
     * Get token from Primavera Platform.
     *
     * @return string $token
     */
    private static function getToken()
    {
        $token = config('services.ws_primavera.token');

        return $token;
    }
}
