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

namespace ContactMyReps\Sunlight;

use ContactMyReps\Sunlight\api\openstates as OpenStates;

/**
* Sunlight Foundation API wrapper
* For more information see http://sunlightfoundation.com/api
*
* @category Sunlight_Foundation_API
* @package  ContactMyReps
* @author   edfialk <edfialk@gmail.com>
* @license  http://opensource.org/licenses/MIT MIT License
* @link     https://github.com/contactmyreps/sunlight-php
*/
class Sunlight
{

    private static $key = null;

    public $options = [
    'asnyc' => false,
    'format' => 'json'
    ];

    /**
     * Create the Sunlight object
     *
     * @param string $key     Sunlight Foundation API Key
     * @param array  $options global config options
     */
    public function __construct($key = null, $options = [])
    {
        if ($key === null) {
            if (self::$key === null) {
                $msg = 'No key provided, and none is globally set. ';
                $msg .= 'Use Sunlight::setKey, or instantiate the Sunlight class with a $key parameter.';
                throw new APIException($msg);
            }
        } else {
            self::$key = $key;
        }

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
            return $this->options[$key] ? $this->options[$key] : null;
        }

        $this->options[$key] = $value;
    }

    /**
     * Get an API instance
     *
     * @param string $api     api class path
     * @param array  $options local options for api
     *
     * @return object          api instance
     */
    public function get($api, $options)
    {
        return $api::getInstance(self::$key, $options);
    }

    /**
     * Get OpenStates API instance
     *
     * @param array $options OpenStates api options
     *
     * @return object          OpenStates api
     */
    public function openStates($options = [])
    {
        $options = array_merge($this->options, $options);

        return $this->get('ContactMyReps\\Sunlight\\API\\OpenStates', $options);
    }

    /**
     * Get Congress API instance
     *
     * @param array $options Congress api options
     *
     * @return object          Congress api
     */
    public function congress($options = [])
    {
        $options = array_merge($this->options, $options);

        return $this->get('ContactMyReps\\Sunlight\\API\\Congress', $options);
    }
}
