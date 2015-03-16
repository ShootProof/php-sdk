<?php
require_once('Sp_Lib.php');
/*
 * OAuth 2.0 authentication wrapper for authenticating with the ShootProof.com API
 *
 * To find more information and for documentation of the API please
 * visit http://developer.shootproof.com
 */
class Sp_Auth extends Sp_Lib
{
    /**
     * Property for the API authentication endpoint
     *
     * @var string
     */
    protected $_authEndPoint = 'https://auth.shootproof.com/oauth2/authorization/new';

    /**
     * Property for the API authentication token endpoint
     *
     * @var string
     */
    protected $_tokenEndPoint = 'https://auth.shootproof.com/oauth2/authorization/token';

    /**
     * Preoperty for the redirect URI
     *
     * @var string
     */
    protected $_redirectUri;

    /**
     * Property for scope of request permissions
     *
     * Example (limited) scope: "sp.event.get_list sp.event.get_photos sp.album.get_list sp.album.get_photos"
     *
     * @var string
     */
    protected $_scope;

    /**
     * Property to hold the appId / Client Id
     *
     * @var string
     */
    protected $_clientId;

    /**
     * Sp_Auth constructor
     *
     * @param string $clientID
     * @param string $redirectUri
     * @param string $scope
     */
    public function __construct($clientId = null, $redirectUri = null, $scope = null)
    {
        $this->_clientId = $clientId;
        $this->_redirectUri = $redirectUri;
        $this->_scope = $scope;
    }

    /**
     * Set the appId / Client Id
     *
     * @param string $clientId
     * @return Sp_Auth
     */
    public function setClientId($clientId)
    {
        $this->_clientId = $clientId;
        return $this;
    }

    /**
     * Set the redirect uri
     *
     * @param string $uri uri to redirec to after auth
     * @return Sp_Auth
     */
    public function setRedirectUri($uri)
    {
        $this->_redirectUri = $uri;
        return $this;
    }

    /**
     * Method to get the appId
     *
     * @return string
     */
    protected function _getClientId()
    {
        return $this->_clientId;
    }

    /**
     * Method to return the redirect uri
     *
     * @return string
     */
    protected function _getRedirectUri()
    {
        return $this->_redirectUri;
    }

    /**
     * Method to return the scope
     *
     * @return string
     */
    protected function _getScope()
    {
        return $this->_scope;
    }

    /**
     * Method to get the login uri
     *
     * @return string
     */
    public function getLoginUri()
    {
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->_getClientId(),
            'redirect_uri' => $this->_getRedirectUri(),
            'scope' => $this->_getScope()
        );

        return $this->_getUri($this->_authEndPoint, $params);
    }

    /**
    * Method to request an access token with a temporary auth code
    *
    * @param $code auth code
    * @return json response with access/refresh token
    */
    public function requestAccessToken($code)
    {
        $params = array(
            'code' => $code,
            'grant_type' => 'authorization_code',
            'client_id' => $this->_getClientId(),
            'redirect_uri' => $this->_getRedirectUri(),
            'scope' => $this->_getScope()
        );

        return $this->_makeRequest($this->_tokenEndPoint, $params);
    }

    /**
    * Method to request an access token with a temporary auth code
    *
    * @param $refreshToken refresh_token
    * @return json response with access/refresh token
    */
    public function requestAccessTokenRefresh($refreshToken)
    {
        $params = array(
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token',
            'scope' => $this->_getScope()
        );

        return $this->_makeRequest($this->_tokenEndPoint, $params);
    }
}
