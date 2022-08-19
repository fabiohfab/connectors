<?php

namespace Sinmetro\Connectors\Requests;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DynamicsRequestConnector
{
    /**
     * Get Request to Dynamics.
     */
    public static function getRequest(string $path, bool $transformResponseGuzzleHttpToJson = true)
    {
        return self::request('get', $path, null, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Post Request to Dynamics.
     *
     * @param mixed $data
     */
    public static function postRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('post', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Patch Request to Dynamics.
     *
     * @param mixed $data
     */
    public static function updateRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('update', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Delete Request to Dynamics.
     *
     * @param mixed $data
     */
    public static function deleteRequest(string $path, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('delete', $path, $transformResponseGuzzleHttpToJson);
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
                    $response = $client->patch($path, $data);
                    break;

                case 'delete':
                    $response = $client->delete($path);
                    break;

                default:
                    abort(500, 'An error occurred calling the Dynamics services. If the error persists, please contact IT Support. (This error message ID is dca42269-ccd2-45ce-8a71-674353a9d81b.)');
                    break;
            }
        } catch (\Throwable  $th) {
            Log::error('Dynamics Request');
            Log::error($path);
            Log::error(json_encode($data));

            if (method_exists($th, 'getResponse') && method_exists($th->getResponse(), 'getBody')) {
                Log::error($th->getResponse()->getStatusCode().$th->getResponse()->getBody(true));
            }

            abort(500, 'An error occurred calling Dynamics services. If the error persists, please contact IT Support. (This error message ID is 52ebc0f5-928d-4caa-92cf-707c9bc8b7d7.)');
        }

        if ($transformResponseGuzzleHttpToJson) {
            return connectorsResponseGuzzleHttpToJson($response);
        }

        return $response;
    }

    /**
     * Config The Request to Dynamics.
     *
     * @return GuzzleHttp\Client $client
     */
    private static function config()
    {
        if (!Cache::has('access_token') && !Cache::has('expires_date') || Cache::has('access_token') && Cache::has('expires_date') && Carbon::now()->greaterThan(Cache::get('expires_date'))) {
            self::getToken();
        }
        $token = Cache::get('access_token');

        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'OData-MaxVersion' => '4.0',
            'OData-Version' => '4.0',
            'Prefer' => 'return=representation, odata.include-annotations="OData.Community.Display.V1.FormattedValue"'
        ];

        return new Client([
            'base_uri' => config('services.dynamics.url').'/api/data/v9.1/',
            'headers' => $headers,
            'curl' => [\CURLOPT_SSL_VERIFYPEER => false],
            'verify' => false,
        ]);
    }

    /**
     * Get token from Azure wemold Platform (our application).
     */
    private static function getToken()
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded', 'Accept' => 'application/json',
        ];

        $data = [
            'form_params' => [
                'client_id' => config('services.dynamics.client_id'),
                'grant_type' => 'client_credentials',
                'resource' => Str::finish(config('services.dynamics.url'), '/'),
                'client_secret' => config('services.dynamics.client_secret'),
            ],
        ];

        $client = new Client([
            'base_uri' => 'https://login.microsoftonline.com/33c572ec-59de-42ee-860a-8b0d52b8d655/',
            'headers' => $headers,
            'curl' => [\CURLOPT_SSL_VERIFYPEER => false],
            'verify' => false,
        ]);

        try {
            $response = $client->post('oauth2/token', $data);
            $jsonResponse = json_decode($response->getBody()->getContents(), true);
            $GLOBALS['access_token'] = $jsonResponse['access_token'];
            Cache::put('access_token', $jsonResponse['access_token']);
            Cache::put('expires_date', Carbon::now()->addSeconds($jsonResponse['expires_in'] - 600));
        } catch (\Throwable $th) {
            Log::error('Dynamics Request');
            Log::error('oauth2/token');
            Log::error(json_encode($data));

            if (method_exists($th, 'getResponse') && method_exists($th->getResponse(), 'getBody')) {
                Log::error($th->getResponse()->getStatusCode().$th->getResponse()->getBody(true));
            }

            abort(500, 'An error occurred calling Dynamics services. If the error persists, please contact IT Support. (This error message ID is fdfcf8f8-c78e-4242-8e10-9305b9c32905.)');
        }

        return $response;
    }
}
