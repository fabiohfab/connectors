<?php

namespace Sinmetro\Connectors\Requests;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AnveraRequestConnector
{
    /**
     * Get Request to Anvera.
     */
    public static function getRequest(string $path, bool $transformResponseGuzzleHttpToJson = true)
    {
        return self::request('get', $path, null, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Post Request to Anvera.
     *
     * @param mixed $data
     */
    public static function postRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('post', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Patch Request to Anvera.
     *
     * @param mixed $data
     */
    public static function updateRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('update', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Delete Request to Anvera.
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
                    abort(500, 'An error occurred calling Anvera. If the error persists, please contact IT Support. (This error message ID is 1acfa2a8-c819-4ed3-855b-6629645f2aeb.)');
                    break;
            }
        } catch (\Throwable $th) {
            Log::error('Anvera Request');
            Log::error($path);
            Log::error(json_encode($data));
            if (method_exists($th, 'getResponse') && method_exists($th->getResponse(), 'getBody')) {
                Log::error($th->getResponse()->getStatusCode().$th->getResponse()->getBody(true));
            }

            abort(500, 'An error occurred calling Anvera. If the error persists, please contact IT Support. (This error message ID is 79fa139a-201d-4349-92e5-92b85b10ad00.)');
        }

        if ($transformResponseGuzzleHttpToJson) {
            return connectorsResponseGuzzleHttpToJson($response);
        }

        return $response;
    }

    /**
     * Config The Request to Anvera.
     *
     * @return GuzzleHttp\Client $client
     */
    private static function config()
    {
        $ip = config('services.anvera.ip');
        $company = config('services.anvera.company');
        $token = self::getToken($ip);

        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'OData-MaxVersion' => '4.0',
            'OData-Version' => '4.0',
        ];

        return new Client([
            'base_uri' => "http://{$ip}/anvera/api/{$company}/",
            'headers' => $headers,
            'curl' => [CURLOPT_SSL_VERIFYPEER => false],
            'verify' => false,
        ]);
    }

    /**
     * Get token from Avera Platform.
     *
     * @return string $token
     */
    private static function getToken(string $ip)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $data = [
            'body' => json_encode([
                'login' => config('services.anvera.login'),
                'password' => config('services.anvera.password'),
                'salt' => 'string',
            ]),
        ];

        $client = new Client([
            'base_uri' => "http://{$ip}/anvera/api/",
            'headers' => $headers,
            'curl' => [CURLOPT_SSL_VERIFYPEER => false],
            'verify' => false,
        ]);

        try {
            $response = $client->post('Utilizadores/SignIn', $data);
            $token = connectorsResponseGuzzleHttpToJson($response)['token'];
        } catch (\Throwable $th) {
            report($th);

            abort(500, 'An error occurred calling Anvera. If the error persists, please contact IT Support. (This error message ID is 1573d5c5-1772-43fd-9a22-fc2f3879f28e.)');
        }

        return $token;
    }
}
