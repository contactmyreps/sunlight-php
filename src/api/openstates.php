<?php
/**
 * Sunlight-php
 *
 * PHP Version 7.0.1
 *
 * @category Sunlight_Foundation_API
 * @package  ContactMyReps
 * @author   edfialk <edfialk@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/contactmyreps/sunlight-php
 */

namespace ContactMyReps\Sunlight\api;

use ContactMyReps\Sunlight\api\BaseAPI;
use GuzzleHttp\Client;

/**
* Sunlight Foundation OpenStates API wrapper
* For more information see https://sunlightlabs.github.io/openstates-api
*
* @category Sunlight_Foundation_API
* @package  ContactMyReps
* @author   edfialk <edfialk@gmail.com>
* @license  http://opensource.org/licenses/MIT MIT License
* @link     https://github.com/contactmyreps/sunlight-php
*/
class OpenStates extends BaseAPI
{

    const BASE_URI = 'http://openstates.org/api/v1/';

    /**
     * Create OpenStates API
     *
     * @param array $options api options (json, sync, etc.)
     */
    public function __construct($options = [])
    {
        parent::__construct($options);
    }

    /**
     * Create Guzzle Client
     *
     * @param string $key Sunlight Foundation API key
     *
     * @return null
     */
    public function setClient($key)
    {
        $this->client = new Client(
            [
            'base_uri' => self::BASE_URI,
            'headers' => [
            'X-APIKEY' => $key
            ]
            ]
        );
    }

    /**
     * Return Guzzle Client
     *
     * @return GuzzleHTTP/Client OpenStates Guzzle Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Search OpenStates Legislators
     *
     * @param array $search search fields
     * @param array $fields display fields
     *
     * @return Response         Guzzle Response
     */
    public function legislators($search = [], $fields = [])
    {
        $url = 'legislators/?';
        if (count($search) > 0) {
            $p = [];
            foreach ($search as $k => $v) {
                $p[] = "$k=$v";
            }
            $url .= implode("&", $p);
        }

        return $this->get($url, $fields);
    }

    /**
     * Lookup legislators that serve districts containing a given point
     *
     * @param float $lat    Latitude
     * @param float $lng    Longitude
     * @param array $fields display fields
     *
     * @return Response         Guzzle Response
     */
    public function geoLookup($lat, $lng, $fields = [])
    {
        $url = 'legislators/geo/?lat='.$lat.'&long='.$lng;

        return $this->get($url, $fields);
    }
}
