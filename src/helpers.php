<?php
/**
 * Transform Guzzle Http Response to Json Array.
 *
 * @param [Guzzle Response] $response
 *
 * @return array
 */
function connectorsResponseGuzzleHttpToJson($response)
{
    return json_decode($response->getBody()->getContents(), true);
}
