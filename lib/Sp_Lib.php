<?php
/**
 * API/Authentication library for API/Authentication wrappers
 *
 * To find more information and for documentation of the API please
 * visit http://developer.shootproof.com
 */
class Sp_Lib
{
    /**
     * Property to hold the version of the plugin
     *
     * @var string
     */
    protected $_version = 'php-1.5.0';

    /**
     * Wrapper method to make an api request
     *
     * @param $code auth code
     * @return json response with access/refresh token
     */
    protected function _makeApiRequest($params, $photos = array())
    {
        $token = array('access_token' => $this->_getAccessToken());

        $params = array_merge($params, $token);

        return $this->_makeRequest($this->_baseEndPoint, $params, $photos);
    }

    /**
     * Method to make the request to the API
     *
     * @param array $params
     * @param array $photos
     * @return array
     */
    protected function _makeRequest($url, $params = array(), $photos = array())
    {
        // if any photos exist, let's merge them into the params
        if (count($photos)) {
            $params = array_merge($params, $photos);
        }

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $flattened = array();
                $params = $this->_flattenMultiDimensionalParams($params, $flattened);
                $params = $flattened;
            }
        }

        // send along some headers for reporting
        $headers = array(
            'X-WRAPPER: ' . $this->_version
        );

        // init curl to make the request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // the API response
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $error = curl_error($curl);
        $errno = curl_errno($curl);

        if ($error) {
            throw new Sp_CurlException($error, $errno);
        }

        if (!$response) {
            throw new Sp_NoResponseException('The API did not return any response. Error #' . $info['http_code']);
        }

        $json = json_decode($response, true);

        if ($json['stat'] != 'ok') {
            throw new Sp_Exception(
                'The API did not return an OK response. ' . $json['msg'],
                0,
                $response
            );
        }

        return $json;
    }

    /**
     * Build the URL for given path and parameters.
     *
     * @param $path
     *   (optional) The path.
     * @param $params
     *   (optional) The query parameters in associative array.
     *
     * @return
     *   The URL for the given parameters.
     */
    protected function _getUri($path = '', $params = array()) {
        $url = $path;
        $url .= '?' . http_build_query($params, NULL, '&');
        return $url;
    }

    /**
     * Adapted from http://stackoverflow.com/a/8224117
     *
     * @param array $arrays Source array.
     * @param array &$new Array for modified arrays, by reference.
     * @param string $prefix Field prefix; optional.
     * @return void
     */
    protected function _flattenMultiDimensionalParams($arrays, array &$new = array(), $prefix = null)
    {
        if (is_object($arrays)) {
            $arrays = get_object_vars( $arrays );
        }

        foreach ($arrays as $key => $value) {
            $k =
                isset($prefix) ?
                    $prefix . '[' . $key . ']' :
                    $key;

            if (is_array($value) || is_object($value)) {
                $this->_flattenMultiDimensionalParams($value, $new, $k);
            } else {
                $new[$k] = $value;
            }
        }
    }
}
