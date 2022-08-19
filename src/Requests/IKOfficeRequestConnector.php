<?php

namespace Sinmetro\Connectors\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\CurlHandler;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ConnectException;

class IKOfficeRequestConnector
{
    /**
     * Get Request to IKOffice.
     */
    public static function getRequest(string $path, bool $transformResponseGuzzleHttpToJson = true)
    {
        return self::request('get', $path, null, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Post Request to IKOffice.
     *
     * @param mixed $data
     */
    public static function postRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('post', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Patch Request to IKOffice.
     *
     * @param mixed $data
     */
    public static function updateRequest(string $path, $data, bool $transformResponseGuzzleHttpToJson = false)
    {
        return self::request('update', $path, $data, $transformResponseGuzzleHttpToJson);
    }

    /**
     * Delete Request to IKOffice.
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
                    $response = $client->patch($path, $data);
                    break;
                default:
                    abort(500, 'An error occurred calling IKOffice. If the error persists, please contact IT Support. (This error message ID is ef12c788-fc9d-4c61-b0f5-3d5a55cce902.)');
                    break;
            }
        } catch (\Throwable $th) {
            Log::error('IKOffice Request');
            Log::error($path);
            Log::error(json_encode($data));
            if (method_exists($th, 'getResponse') && method_exists($th->getResponse(), 'getBody')) {
                Log::error($th->getResponse()->getStatusCode().$th->getResponse()->getBody(true));
            }

            abort(500, 'An error occurred calling IKOffice. If the error persists, please contact IT Support. (This error message ID is 1e30f7b3-5140-4ad3-8e26-840117836e23.)');
        }

        if ($transformResponseGuzzleHttpToJson) {
            return connectorsResponseGuzzleHttpToJson($response);
        }

        return $response;
    }

    /**
     * Config The Request.
     */
    private static function config(): Client
    {
        $headers = [
            'X-Tenant-ID' => config('services.ikoffice.tenant_id'),
            'X-API-KEY' => config('services.ikoffice.api_key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        #https://github.com/guzzle/guzzle/issues/1806
        $handlerStack = HandlerStack::create(new CurlHandler());
        $handlerStack->push(Middleware::retry(self::retryDecider(), self::retryDelay()));

        return new Client([
            'base_uri' => config('services.ikoffice.url'),
            'headers' => $headers,
            'handler' => $handlerStack
        ]);
    }

    private static function retryDecider()
    {
        return function (
            $retries,
            Request $request,
            Response $response = null,
            $exception = null
        ) {
            // Limit the number of retries to 5
            if ($retries >= 5) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on server errors
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * delay 1s 2s 3s 4s 5s
     *
     */
    private static function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }
}
