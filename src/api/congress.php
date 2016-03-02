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

namespace ContactMyReps\Sunlight\API;

use ContactMyReps\Sunlight\api\BaseAPI;
use GuzzleHttp\Client;

/**
* Sunlight Foundation Congress API wrapper
* For more information see https://sunlightlabs.github.io/congress/
*
* @category Sunlight_Foundation_API
* @package  ContactMyReps
* @author   edfialk <edfialk@gmail.com>
* @license  http://opensource.org/licenses/MIT MIT License
* @link     https://github.com/contactmyreps/sunlight-php
*/
class Congress extends BaseAPI
{

    const BASE_URI = 'https://congress.api.sunlightfoundation.com/';

    /**
     * Create Congress API instance
     *
     * @param array $options api options
     */
    public function __construct($options = [])
    {
        parent::__construct($options);
    }

    /**
     * Create Guzzle Client
     *
     * @param string $key Sunlight Foundation api key
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
     * Return Congress API Guzzle Client
     *
     * @return GuzzleHTTP\Client Guzzle Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Search Congress API legislators
     *
     * @param array $search search fields
     * @param array $fields display fields
     *
     * @return Response         API Response
     */
    public function legislators($search = [], $fields = [])
    {
        $url = 'legislators?';
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
     * Find reps for a given zip
     *
     * @param int   $zip    zip code
     * @param array $fields display fields
     *
     * @return Response         API Response
     */
    public function locateByZip($zip, $fields = [])
    {
        $url = 'legislators/locate?zip='.$zip;
        return $this->get($url, $fields);
    }

    /**
     * Find reps for a given lat/lng
     *
     * @param float $lat    latitude
     * @param float $lng    longitude
     * @param array $fields display fields
     *
     * @return Response         API Response
     */
    public function locateByGeo($lat, $lng, $fields = [])
    {
        $url = 'legislators/locate?latitude='.$lat.'&longitude='.$lng;
        return $this->get($url, $fields);
    }
}
