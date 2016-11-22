<?php
/**
 * Base ShootProof PHP SDK exception.
 *
 * To find more information and for documentation of the API please
 * visit http://developer.shootproof.com
 */
class Sp_Exception extends Exception
{
    /**
     * Response body, if set upon construction.
     *
     * @var string
     */
    protected $_responseBody;

    /**
     * Constructor.
     *
     * @param string $msg Exception message.
     * @param integer $code Exception code; optional.
     * @param string|null $responseBody Response body string; optional.
     * @return void
     * @see Exception::__construct()
     */
    public function __construct($msg, $code = 0, $responseBody = null)
    {
        parent::__construct($msg, $code);
        $this->_responseBody = $responseBody;
    }

    /**
     * Returns the raw response body, if set.
     *
     * @return string|null
     */
    public function getResponseBody()
    {
        return $this->_responseBody;
    }

    /**
     * Gets the response body as an array, if the response body is JSON-encoded
     * data.  Otherwise, returns null.
     *
     * @return array|null
     */
    public function getResponseData()
    {
        $data = null;

        if ($body = $this->getResponseBody()) {
            if (($decoded = json_decode($body, true))) {
                $data = $decoded;
            }
        }

        return $data;
    }

    /**
     * Override __toString() to show the response data, if available.
     *
     * @return string
     */
    public function __toString()
    {
        $string = parent::__toString();

        if (($responseData = $this->getResponseData())) {
            $string .= "\nresponse body data: " . print_r($responseData, true);
        }

        return $string;
    }
}
