<?php
require __DIR__ . '/vendor/autoload.php'; // require all modules intalled with Composer

use \Firebase\JWT\JWT; // Use the JWT module

// PS! Remove this in production
// This header allows you to make requests to this host from other domains
// It's good when developing/testing
header('Access-Control-Allow-Origin: *');

$client_id = $_GET['clientId'];
// if no client_id is given show error

// Check session and stuff here, if user is allowed to connect, if not show some error

$channel_id = "I0re5mgVspBeIIkN"; // channel ID from admin panel
$secret_key = "4kCVOLIjRs1sofk611KgTuZi5SGl8tEA"; // secret key from admin panel
$milliseconds = round(microtime(true) * 1000); // current milliseconds timestamp
$buffer = 1000 * 60 * 10; // we add 10 minutes token expiration buffer time

$token = array(
    "client" => $client_id,
    "channel" => $channel_id,
    "permissions" => array(
        "^flightstats$" => array( // ^flightstats$ is regex meaning 1:1 match with flightstats
            "publish" => False, // don't allow pushing messages to flightstats
            "subscribe" => True // allow subscribing to the room
        ),
        "^chat\d+$" => array( // this regex matches rooms like chat0, chat1, chat12, basically chat plus some numbers
            "publish" => True,
            "subscribe" => True
        )
    ),
    "exp" => $milliseconds + $buffer
);

$jwt = JWT::encode($token, $secret_key);

print_r($jwt);
?>
