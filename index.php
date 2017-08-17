<?php
$loader = require "vendor/autoload.php";
$loader->addPsr4( 'Cloacker\\', __DIR__ . '/cloacker/' );

$ipAddress = $_SERVER['REMOTE_ADDR'];

$host = gethostbyaddr($ipAddress);

$referer = $_SERVER['HTTP_REFERER'];

$userAgent = $_SERVER['HTTP_USER_AGENT'];

$redirectLocation = 'https://youtube.com';

$isRedirect = new \Cloacker\Redirect($ipAddress, $host, $referer, $userAgent);
$isRedirect -> isRedirect($redirectLocation);
?>
<h1>Hello World!!!</h1>
