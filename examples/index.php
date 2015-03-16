<?php

// Configure your desired settings here
$shootproof_client_id = 'YOUR_CLIENT_ID_HERE';
$shootproof_api_scope = array(
    'sp.studio.info',
    'sp.event.get_list',
    'sp.event.create',
    'sp.event.photo_exists',
    'sp.event.get_photos',
    'sp.album.get_list',
    'sp.album.create',
    'sp.album.get_photos',
    'sp.photo.upload',
    'sp.photo.delete',
    'sp.order.get_list',
    'sp.order.get_details',
    'sp.auth.deauthorize',
);

// Include the ShootProof PHP SDK files
require_once '../lib/Sp_Exception.php';
require_once '../lib/Sp_CurlException.php';
require_once '../lib/Sp_NoResponseException.php';
require_once '../lib/Sp_Lib.php';
require_once '../lib/Sp_Api.php';
require_once '../lib/Sp_Auth.php';

session_start();

// Get the URL of the current page to redirect back to
if (empty($_SESSION['redirect_url'])) {
    $_SESSION['redirect_url'] = sprintf(
        '%s://%s%s',
        isset($_SERVER['HTTPS']) ? 'https' : 'http',
        $_SERVER['HTTP_HOST'],
        $_SERVER['REQUEST_URI']
    );
}

// Configure the ShootProof OAuth client
$auth = new Sp_Auth($shootproof_client_id, $_SESSION['redirect_url'], implode(' ', $shootproof_api_scope));

// Exchange the authorization code for an access token
if (empty($_SESSION['sp_tokens']) && ! empty($_GET['code'])) {
    try {
        $_SESSION['sp_tokens'] = $auth->requestAccessToken($_GET['code']);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

// Test the API by calling the sp.event.get_list ShootProof API method
if ( ! empty($_SESSION['sp_tokens']['access_token'])) {
    try {
        $client = new Sp_Api($_SESSION['sp_tokens']['access_token']);
        $events = $client->getEvents();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

?>

<a href="<?php echo $auth->getLoginUri(); ?>">AUTHORIZE</a>

<?php if ( ! empty($_SESSION['sp_tokens'])): ?>

    <h1>Access Tokens</h1>
    <pre><?php print_r($_SESSION['sp_tokens']) ?></pre>

    <h1>Event Listing</h1>
    <pre><?php print_r($events) ?></pre>

<?php endif; ?>
