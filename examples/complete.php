<?php
require_once('Sp_Api.php');
require_once('Sp_Auth.php');
$auth = new Sp_Auth();

$code = $_GET['code'];

// Separate try catch blocks for debugging
try {

    $tokens = $auth->requestAccessToken($code);

} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}

try {

    $client = new Sp_Api($tokens['access_token']);

    $events = $client->getEvents();

} catch (Exception $e) {

    echo $e->getMessage();
    exit;
}
?>

<h3>Access Token Response</h3>
<?php print_r($tokens) ?>

<h3>Event Listing Response</h3>
<?php print_r($events) ?>
