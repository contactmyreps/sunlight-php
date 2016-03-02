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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
* Sunlight Foundation Base API
 *
 * @category Sunlight_Foundation_API
 * @package  ContactMyReps
 * @author   edfialk <edfialk@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/contactmyreps/sunlight-php
*/
abstract class BaseAPI
{

    public $options = [];

    private static $_instance;

    /**
     * Create api
     *
     * @param array $options local api options
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Set or retrieve option value
     *
     * @param string or array $key   the option key to set/retrieve, or an array of options to set
     * @param object          $value value to store
     *
     * @return object          if key is string and value is null, return options[key] value
     */
    public function option($key, $value = null)
    {
        if (is_array($key)) {
            $this->options = array_merge($this->options, $key);
            return;
        }

        if (null === $value) {
            return $this->options[$key] ?? null;
        }

        $this->options[$key] = $value;
    }

    /**
     * Submit asynchronous get request
     *
     * @param string $url    request url
     * @param array  $fields response fields
     *
     * @return GuzzleHttp\Promise      Request promise
     */
    public function getAsync($url, $fields = [])
    {
        $url = $this->addFieldsToUrl($fields, $url);

        return $this->getClient()->getAsync($url)->then(
            function (ResponseInterface $response) {
                return $this->format($response);
            },
            function (RequestException $e) {
                echo "INSIDE BASE ASYNC EXCEPTION\n";
                return $e;
            }
        );
    }

    /**
     * Submit get request
     *
     * @param string $url    request url
     * @param array  $fields response fields
     *
     * @return GuzzleHttp\Promise or json or array         response
     */
    public function get($url, $fields = [])
    {
        $url = $this->addFieldsToUrl($fields, $url);

        if ($this->option('async') === true) {
            return $this->getAsync($url);
        }

        $response = $this->getClient()->get($url);
        return $this->format($response);
    }

    /**
     * Convert guzzle response to data
     *
     * @param Response $response GuzzleHttp\Response
     *
     * @return string or array           data
     */
    public function format($response)
    {
        $data = (string) $response->getBody();

        if ($this->option('json') === true) {
            return $data;
        }

        return json_decode($data);
    }

    /**
     * Get API instance
     *
     * @param string $key     API class name
     * @param array  $options API options
     *
     * @return object          API instance
     */
    public static function getInstance($key, $options)
    {
        $class = get_called_class();
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = new static($options);
            self::$_instance[$class]->setClient($key);
        }
        return self::$_instance[$class];
    }

    /**
     * Copy display fields to url string
     *
     * @param array  $fields response fields
     * @param string $url    request url
     *
     * @return string url with ?fields=field1,field2
     */
    public function addFieldsToUrl($fields, $url)
    {
        if (count($fields) == 0) {
            return $url;
        }

        $url .= strpos($url, "?") !== false ? "&" : "?";
        $url .= "fields=".implode(",", $fields);
        return $url;
    }

    /**
     * Create API Guzzle Client
     *
     * @param string $key Sunlight Foundation API key
     *
     * @return null
     */
    protected abstract function setClient($key);

    /**
     * Get API Guzzle Client
     *
     * @return GuzzleHttp\Client API Client
     */
    protected abstract function getClient();

}
