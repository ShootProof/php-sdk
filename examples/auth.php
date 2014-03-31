<?php
require_once('Sp_Auth.php');
$auth = new Sp_Auth();
?>
<html>
    <head>
        <title>Oauth2 Tester</title>
    </head>
    <body>
        <a href="<?php echo $auth->getLoginUri(); ?>">AUTHORIZE</a>
    </body>
</html>
