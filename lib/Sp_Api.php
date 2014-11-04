<?php
require_once('Sp_Lib.php');
/**
 * API Wrapper class for accessing the ShootProof.com API
 *
 * To find more information and for documentation of the API please
 * visit http://developer.shootproof.com
 */
class Sp_Api extends Sp_Lib
{
	/**
	 * Property for the API base endpoint
	 *
	 * @var string
	 */
    protected $_baseEndPoint = 'https://api.shootproof.com/v2';

	/**
	 * Property to hold the access token to be used on all API requests
	 *
	 * @var string
	 */
    protected $_accessToken;

    public function __construct($accessToken)
    {
        $this->_accessToken = $accessToken;
    }

	/**
	 * Method to return the studio information
	 *
	 * @return array
	 */
	public function getStudioInfo()
	{
		$params = array(
			'method' => 'sp.studio.info'
		);

		return $this->_makeApiRequest($params);
	}

    /**
     * Method to set a studio setting
     *
     * @param string $varName
     * @param string $value
     * @return array
     */
    public function setStudioSetting($varName, $value = null)
    {
        $params = array(
            'method' => 'sp.studio.set_setting',
            'setting_key' => $varName,
            'setting_value' => $value
        );

        return $this->_makeApiRequest($params);
    }

    /**
     * Method to set a studio setting
     *
     * @param string $varName
     * @param string $value
     * @return array
     */
    public function getStudioSetting($varName)
    {
        $params = array(
            'method' => 'sp.studio.get_setting',
            'setting_key' => $varName
        );

        return $this->_makeApiRequest($params);
    }

	/**
	 * Method to return all the open events for a studio
	 *
	 * @return array
	 */
	public function getEvents()
	{
		$params = array(
			'method' => 'sp.event.get_list'
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to create a new event
	 *
	 * @param string $eventName
	 * @return array
	 */
	public function createEvent($eventName)
	{
		if (is_null($eventName) || $eventName == '') {
			throw new Exception('The eventName is required to create a new event.');
		}

		$params = array(
			'method' => 'sp.event.create',
			'event_name' => $eventName
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to delete an event
	 *
	 * @param integer $eventId
	 * @return array
	 */
	public function deleteEvent($eventId)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to delete an event.');
		}

		$params = array(
			'method' => 'sp.event.delete',
			'event_id' => $eventId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to check to see if a photo already exists within an event
	 *
	 * @param integer $eventId
	 * @param string $photoFileName
	 * @return array
	 */
	public function photoExistsInEvent($eventId, $photoFileName)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to check if a photo exists.');
		}

		if (is_null($photoFileName) || $photoFileName == '') {
			throw new Exception('The photoFileName is required to check if a photo exists.');
		}

		$params = array(
			'method' => 'sp.event.photo_exists',
			'event_id' => $eventId,
			'photo_name' => $photoFileName
		);

		return $this->_makeApiRequest($params);
	}

    /**
     * Method to set the event access level and password
     *
     * @param integer $eventId
     * @param string $accessLevel
     * @param string $password
     * @return array
     */
    public function setEventAccessLevel($eventId, $accessLevel, $password)
    {
		if (is_null($accessLevel) || $accessLevel == '') {
			throw new Exception('The access level is required.');
		}

		$params = array(
			'method' => 'sp.event.set_access_level',
			'event_id' => $eventId,
			'access_level' => $accessLevel,
            'password' => $password
		);

		return $this->_makeApiRequest($params);
    }

	/**
	 * Method to get the photos for an event
	 *
	 * @param integer $eventId
	 * @param integer $page
	 * @return array
	 */
	public function getEventPhotos($eventId, $page = 1)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to get the list of photos in the event.');
		}

		$params = array(
			'method' => 'sp.event.get_photos',
			'event_id' => $eventId,
			'page' => $page
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to return the albums for an event
	 *
	 * @param integer $eventId
	 * @return array
	 */
	public function getEventAlbums($eventId)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to check if a photo exists.');
		}

		$params = array(
			'method' => 'sp.album.get_list',
			'event_id' => $eventId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to get the photos for an album
	 *
	 * @param integer $albumId
	 * @param integer $page
	 * @return array
	 */
	public function getAlbumPhotos($albumId, $page = 1)
	{
		if (is_null($albumId) || $albumId == '') {
			throw new Exception('The albumId is required to get the list of photos in the album.');
		}

		$params = array(
			'method' => 'sp.album.get_photos',
			'album_id' => $albumId,
			'page' => $page
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to create a new album in an event
	 *
	 * @param integer $eventId
	 * @param string $albumName
	 * @param string $password
     * @param integer $parentAlbumId
	 * @return array
	 */
	public function createEventAlbum($eventId, $albumName, $password = null, $parentAlbumId = null)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to create an album.');
		}

		if (is_null($albumName) || $albumName == '') {
			throw new Exception('The albumName is required to create a new album.');
		}

		$params = array(
			'method' => 'sp.album.create',
			'event_id' => $eventId,
			'album_name' => $albumName,
			'password' => $password,
            'parent_id' => $parentAlbumId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to create a move album within an event
	 *
	 * @param integer $albumId
     * @param integer $parentAlbumId
	 * @return array
	 */
	public function moveEventAlbum($albumId, $parentAlbumId = null)
	{
		if (is_null($albumId) || $albumId == '') {
			throw new Exception('The albumId is required to move an album.');
		}

		$params = array(
			'method' => 'sp.album.move',
			'album_id' => $albumId,
            'parent_id' => $parentAlbumId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to rename an album
	 *
	 * @param integer $albumId
	 * @param string $albumName
	 * @return array
	 */
	public function renameEventAlbum($albumId, $albumName)
	{
		if (is_null($albumId) || $albumId == '') {
			throw new Exception('The albumId is required to rename an album.');
		}

		if (is_null($albumName) || $albumName == '') {
			throw new Exception('The albumName is required to create a new album.');
		}

		$params = array(
			'method' => 'sp.album.rename',
			'album_id' => $albumId,
			'album_name' => $albumName
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to delete an album
	 *
	 * @param integer $albumId
	 * @return array
	 */
	public function deleteEventAlbum($albumId)
	{
		if (is_null($albumId) || $albumId == '') {
			throw new Exception('The albumId is required to delete an album.');
		}

		$params = array(
			'method' => 'sp.album.delete',
			'album_id' => $albumId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to upload a file from a filepath
	 *
	 * @param integer $eventId
	 * @param stirng $filepath
	 * @param integer $albumId
	 * @return array
	 */
	public function uploadPhotoFromPath($eventId, $filepath, $albumId = null)
	{
		if (is_null($eventId) || $eventId == '') {
			throw new Exception('The eventId is required to upload a file.');
		}

		if (is_null($filepath) || $filepath == '') {
			throw new Exception('The filepath is required to upload a file.');
		}

		if (!file_exists($filepath)) {
			throw new Exception('The filepath does not point to an accessible file.');
		}

		$params = array(
			'method' => 'sp.photo.upload',
			'event_id' => $eventId,
			'album_id' => $albumId
		);

		$photos = array(
			'photo' => '@' . $filepath,
		);

		return $this->_makeApiRequest($params, $photos);
	}

    /**
     * Method to update a photo from a filepath
     *
     * @param integer $photoId
     * @param stirng $filepath
     * @return array
     */
    public function updatePhotoFromPath($photoId, $filepath)
    {
        if (is_null($photoId) || $photoId == '') {
            throw new Exception('The photoId is required to update a photo.');
        }

        if (is_null($filepath) || $filepath == '') {
            throw new Exception('The filepath is required to upload a file.');
        }

        if (!file_exists($filepath)) {
            throw new Exception('The filepath does not point to an accessible file.');
        }

        $params = array(
            'method' => 'sp.photo.update',
            'photo_id' => $photoId,
        );

        $photos = array(
            'photo' => '@' . $filepath,
        );

        return $this->_makeApiRequest($params, $photos);
    }

	/**
	 * Method to delete a photo from an event
	 *
	 * @param integer $photoId
	 * @return array
	 */
	public function deletePhoto($photoId)
	{
		if (is_null($photoId) || $photoId == '') {
			throw new Exception('The photoId is required to delete a photo.');
		}

		$params = array(
			'method' => 'sp.photo.delete',
			'photo_id' => $photoId
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to get the list of orders for a studio
	 *
	 * @param integer $page
	 * @return array
	 */
	public function getOrderList($page = 1)
	{
		$params = array(
			'method' => 'sp.order.get_list',
			'page' => $page
		);

		return $this->_makeApiRequest($params);
	}

	/**
	 * Method to get the details for an order
	 *
	 * @param integer $orderId
	 * @return array
	 */
	public function getOrderDetails($orderId)
	{
		if (is_null($orderId) || $orderId == '') {
			throw new Exception('The orderId is required to get the details or an order.');
		}

		$params = array(
			'method' => 'sp.order.get_details',
			'order_id' => $orderId
		);

		return $this->_makeApiRequest($params);
	}

    /**
     * Method to return all active mobile apps for a studio or brand.
     *
     * If no brand ID is provided, all mobile apps for the studio will be
     * returned.  If a brand ID is provided, then only mobile apps within
     * that brand will be returned.
     *
     * @param integer $brandId Brand ID to lookup by; optional.
     * @param integer $page
     * @return array
     */
    public function getMobileApps($brandId = null, $page = 1)
    {
        $params = array(
            'method' => 'sp.mobile_app.get_list',
            'page' => $page
        );

        if (strlen($brandId) > 0) {
            $params['brand_id'] = $brandId;
        }

        return $this->_makeApiRequest($params);
    }

    /**
     * Method to get the photos for a mobile app.
     *
     * @param integer $mobileAppId
     * @return array
     */
    public function getMobileAppPhotos($mobileAppId)
    {
        $params = array(
            'method' => 'sp.mobile_app.get_photos',
            'mobile_app_id' => $mobileAppId
        );

        return $this->_makeApiRequest($params);
    }

	/**
	 * Method to get the accessToken
	 *
	 * @return string
	 */
	protected function _getAccessToken()
	{
		return $this->_accessToken;
	}

	/**
	 * Method to set the accessToken
	 *
	 * @return string
	 */
	public function setAccessToken($accessToken)
	{
		$this->_accessToken = $accessToken;

        return $this;
	}

	/**
	 * Method to get the refreshToken
	 *
	 * @return string
	 */
	protected function _getRefreshToken()
	{
		return $this->_refreshToken;
	}

    /**
     * Method to set the accessToken
     *
     * @return string
     */
    public function setRefreshToken($refreshToken)
    {
        $this->_refreshToken = $refreshToken;

        return $this;
    }
}
